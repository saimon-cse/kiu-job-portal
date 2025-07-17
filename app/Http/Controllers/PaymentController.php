<?php

namespace App\Http\Controllers;

use App\Models\ApplicationHistory;
use App\Services\SnapshotService;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $snapshotService;

    /**
     * Inject the SnapshotService via the constructor.
     */
    public function __construct(SnapshotService $snapshotService)
    {
        $this->snapshotService = $snapshotService;
    }

    /**
     * Initiate a standard redirect-based payment.
     * This can be used as a fallback or for simpler "Pay Now" links.
     */
    public function pay(ApplicationHistory $application)
    {
        if ($application->user_id !== Auth::id()) { abort(403); }
        if ($application->status !== 'pending') {
            return redirect()->route('dashboard')->with('info', 'This application has already been processed.');
        }

        $post_data = $this->preparePostData($application);

        $sslc = new SslCommerzNotification();
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options); // This will show the error from the library
        }
    }

    /**
     * Handle the AJAX request to initiate payment via the popup modal.
     */
    public function payViaAjax(Request $request)
    {
        $request->validate(['application_id' => 'required|integer|exists:applications_history,id']);
        $application = ApplicationHistory::find($request->application_id);

        if (!$application || $application->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized or invalid application.'], 403);
        }
        if ($application->status !== 'pending') {
            return response()->json(['error' => 'This application has already been processed.'], 422);
        }

        $post_data = $this->preparePostData($application);

        $sslc = new SslCommerzNotification();
        # The key difference is the third parameter: 'json'
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (is_array($payment_options) && array_key_exists('GatewayPageURL', $payment_options)) {
            return json_encode($payment_options);
        }

        Log::error("SSLCommerz AJAX API Error:", (array)$payment_options);
        return response()->json(['error' => 'Could not connect to payment gateway.'], 500);
    }


    /**
     * Display a success page to the user after they are redirected from SSLCommerz.
     * This is a GET route and does NOT contain critical logic.
     */
    public function successPage(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $application = ApplicationHistory::where('transaction_id', $tran_id)->first();

        return view('payment.success', [
            'transaction_id' => $tran_id,
            'application' => $application,
            'message' => 'Thank you for your payment! We are processing your application and will notify you of any updates.'
        ]);
    }

    /**
     * Handle the SUCCESS WEBHOOK from SSLCOMMERZ (server-to-server POST request).
     * This is the secure endpoint for finalizing the transaction and taking the snapshot.
     */
    public function success(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();
        $application = ApplicationHistory::where('transaction_id', $tran_id)->first();

        if (!$application) {
             Log::error("Invalid Transaction! Application not found for tran_id: " . $tran_id);
             return; // Stop execution
        }

        // Only process if the status is still 'Pending' to prevent double processing
        if ($application->status == 'pending') {
            // Validate the payment against the amount stored in OUR database
            $validation = $sslc->orderValidate($request->all(), $tran_id, (string)$application->due_amount, $currency);

            if ($validation) {
                DB::beginTransaction();
                try {
                    // 1. Update the ApplicationHistory record
                    $application->update([
                        'status' => 'submitted',
                        'paid_amount' => $amount,
                        'payment_data' => json_encode($request->all()),
                    ]);

                    // 2. Create the Data Snapshot for the associated job
                    $this->snapshotService->createForJob($application->user, $application->job_id);

                    DB::commit(); // Finalize the changes

                    return redirect()->route('applications.history.index')->with('success', 'Payment Success');
                } catch (\Exception $e) {
                    DB::rollBack(); // Revert all changes if an error occurs
                    Log::error("Payment Success/Snapshot Error for Tran ID: " . $tran_id . " - " . $e->getMessage());
                }
            } else {
                 $application->update(['status' => 'rejected', 'payment_data' => json_encode($request->all())]);
                 Log::error("Payment validation failed for tran_id: " . $tran_id);
            }
        }
    }

    /**
     * Handle the FAIL callback.
     */
    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');
        if ($tran_id) {
            ApplicationHistory::where('transaction_id', $tran_id)
                ->where('status', 'pending')
                ->update(['status' => 'rejected', 'payment_data' => json_encode($request->all())]);
        }
        return redirect()->route('dashboard')->with('error', 'The payment transaction has failed.');
    }

    /**
     * Handle the CANCEL callback.
     */
    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');
        if ($tran_id) {
            ApplicationHistory::where('transaction_id', $tran_id)
                ->where('status', 'pending')
                ->update(['payment_data' => json_encode($request->all())]);
        }
        return redirect()->route('dashboard')->with('info', 'Your payment transaction was cancelled.');
    }

    /**
     * Handle the IPN (Instant Payment Notification).
     */
    public function ipn(Request $request)
    {
        // IPN is a backup. It should run the same secure logic as the success webhook.
        if ($request->input('tran_id')) {
            $this->success($request);
        }
    }

    /**
     * A private helper method to prepare the POST data for SSLCommerz.
     * This avoids code duplication between pay() and payViaAjax().
     *
     * @param ApplicationHistory $application
     * @return array
     */
    private function preparePostData(ApplicationHistory $application)
    {
        $user = $application->user;
        $transaction_id = 'APP_' . $application->id . '_' . uniqid();

        // Store the unique transaction ID in our record first
        $application->update(['transaction_id' => $transaction_id]);

        $post_data = array();
        $post_data['total_amount'] = $application->due_amount;
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = $transaction_id;

        // The success_url is where the USER'S BROWSER will be redirected (GET request).
        $post_data['success_url'] = route('payment.success.page');
        $post_data['fail_url'] = route('payment.fail');
        $post_data['cancel_url'] = route('payment.cancel');
        // The ipn_url is where the SSLCOMMERZ SERVER will send a POST request.
        $post_data['ipn_url'] = route('payment.ipn');


        $post_data['cus_name'] = $user->name;
        $post_data['cus_email'] = $user->email;
        $post_data['cus_phone'] = '01000000000';
        $post_data['cus_add1'] = 'N/A';
        $post_data['cus_country'] = "Bangladesh";

        $post_data['product_name'] = "Job Application Fee";
        $post_data['product_category'] = "Service";
        $post_data['product_profile'] = "non-physical-goods";
        $post_data['shipping_method'] = "NO";

        $post_data['value_a'] = $application->id;

        return $post_data;
    }
}
