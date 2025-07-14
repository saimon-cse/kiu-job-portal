<?php

namespace App\Http\Controllers;

use App\Models\ApplicationHistory;
use App\Services\SnapshotService; // <-- Import the service class
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * The snapshot service instance.
     * @var SnapshotService
     */
    protected $snapshotService;

    /**
     * Inject the SnapshotService into the controller via the constructor.
     * Laravel's service container will automatically create and provide an instance for us.
     */
    public function __construct(SnapshotService $snapshotService)
    {
        $this->snapshotService = $snapshotService;
    }

    /**
     * Initiate the payment process for a specific ApplicationHistory record.
     */
    public function pay(ApplicationHistory $application)
    {
        if ($application->user_id !== Auth::id()) {
            abort(403);
        }
        if ($application->status !== 'pending') {
            return redirect()->route('dashboard')->with('info', 'This application has already been processed.');
        }

        $user = $application->user;
        $transaction_id = 'APP_' . $application->id . '_' . uniqid();

        $application->update(['transaction_id' => $transaction_id]);

        # Prepare the data array for SSLCOMMERZ
        $post_data = array();
        $post_data['total_amount'] = $application->due_amount;
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = $transaction_id;

        # Set callback URLs
        $post_data['success_url'] = '/success?tran_id=' . $transaction_id;
        $post_data['fail_url'] = route('payment.fail');
        $post_data['cancel_url'] = route('payment.cancel');
        $post_data['ipn_url'] = route('payment.ipn');

        # Customer & Product Info
        $post_data['cus_name'] = $user->name;
        $post_data['cus_email'] = $user->email;
        $post_data['cus_phone'] = '000000001';
        $post_data['cus_add1'] = 'N/A';
        $post_data['cus_country'] = "Bangladesh";
        $post_data['product_name'] = "Job Application Fee";
        $post_data['product_category'] = "Service";
        $post_data['product_profile'] = "non-physical-goods";
        $post_data['shipping_method'] = "NO";
        $post_data['value_a'] = $application->id;

        $sslc = new SslCommerzNotification();
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    /**
     * Handle the SUCCESS callback from SSLCOMMERZ.
     */
        public function success(Request $request)
        {
            $tran_id = $request->input('tran_id');
            $amount = $request->input('amount');
            $currency = $request->input('currency');

            $sslc = new SslCommerzNotification();
            $application = ApplicationHistory::where('transaction_id', $tran_id)->first();

            if (!$application) {
                 return redirect()->route('dashboard')->with('error', 'Invalid Transaction!');
            }

            if ($application->status == 'pending') {
                $validation = $sslc->orderValidate($request->all(), $tran_id, (string)$application->due_amount, $currency);

                if ($validation) {
                    DB::beginTransaction();
                    try {
                        $application->update([
                            'status' => 'submitted',
                            'paid_amount' => $amount,
                            'payment_data' => json_encode($request->all()),
                        ]);
    // dd($application);
                        // --- DELEGATE TO THE SERVICE ---
                        // The controller doesn't need to know HOW the snapshot is made,
                        // it just needs to tell the service TO make it.
                        $this->snapshotService->createForJob($application->user, $application->job_id);
                        // --- END DELEGATION ---

                        DB::commit();
                        return redirect()->route('applications.history.index')->with('success', 'Payment successful! Your application has been submitted.');
                    } catch (\Exception $e) {
                        DB::rollBack();
                        Log::error("Payment Success/Snapshot Error for Tran ID: " . $tran_id . " - " . $e->getMessage());
                        $application->update(['status' => 'pending']);
                        return redirect()->route('dashboard')->with('error', 'A critical error occurred after payment. Please contact support.');
                    }
                } else {
                    $application->update(['status' => 'rejected', 'payment_data' => json_encode($request->all())]);
                    return redirect()->route('dashboard')->with('error', 'Payment validation failed.');
                }
            } else if ($application->status == 'submitted') {
                return redirect()->route('dashboard')->with('success', 'Application has already been submitted.');
            } else {
                return redirect()->route('dashboard')->with('error', 'Invalid Transaction!');
            }
        }


    public function successPage(Request $request)
    {
        // dd("This is the success page. You can customize it as needed.");
        // You can get the transaction ID to show it to the user
        $tran_id = $request->input('tran_id');

        // It's good practice to check if the application status is 'submitted' yet.
        // If not, it means the IPN is just a little delayed.
        $application = ApplicationHistory::where('transaction_id', $tran_id)->first();

        // Pass a friendly message and the application details to a view.
        return view('payment.success', [
            'transaction_id' => $tran_id,
            'application' => $application,
            'message' => 'Thank you for your payment! Your transaction is being processed and you will be notified. Your application has been submitted.'
        ]);
    }

    /**
     * Handle the SUCCESS WEBHOOK from SSLCOMMERZ (server-to-server).
     * This method is now used for the POST /payment/success route.
     */
    // public function success(Request $request)
    // {
    //     // This method now contains the core logic for validating and finalizing the application.
    //     // The code you already have here is perfect for this purpose.
    //     $tran_id = $request->input('tran_id');
    //     $amount = $request->input('amount');
    //     $currency = $request->input('currency');

    //     $sslc = new SslCommerzNotification();
    //     $application = ApplicationHistory::where('transaction_id', $tran_id)->first();

    //     if (!$application) {
    //         Log::error("Invalid Transaction! Application not found for tran_id: " . $tran_id);
    //         return; // Just stop execution for IPN
    //     }

    //     if ($application->status == 'pending') {
    //         $validation = $sslc->orderValidate($request->all(), $tran_id, (string)$application->due_amount, $currency);

    //         if ($validation) {
    //             DB::beginTransaction();
    //             try {
    //                 $application->update([
    //                     'status' => 'submitted',
    //                     'paid_amount' => $amount,
    //                     'payment_data' => json_encode($request->all()),
    //                 ]);
    //                 $this->snapshotService->createForJob($application->user, $application->job_id);
    //                 DB::commit();
    //             } catch (\Exception $e) {
    //                 DB::rollBack();
    //                 Log::error("Payment Success/Snapshot Error for Tran ID: " . $tran_id . " - " . $e->getMessage());
    //                 $application->update(['status' => 'pending']);
    //             }
    //         } else {
    //             $application->update(['status' => 'rejected', 'payment_data' => json_encode($request->all())]);
    //             Log::error("Payment validation failed for tran_id: " . $tran_id);
    //         }
    //     }
    // }

    // ... (fail and cancel methods are fine as they are) ...



    /**
     * Handle the FAIL callback from SSLCOMMERZ.
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
     * Handle the AJAX request to initiate payment via the popup modal.
     * This method must return a JSON response.
     */
    public function payViaAjax(Request $request)
    {
        // --- Validation and Security ---
        $request->validate([
            'application_id' => 'required|integer|exists:applications_history,id'
        ]);

        $application = ApplicationHistory::find($request->application_id);

        if (!$application) {
            return response()->json(['error' => 'Application not found.'], 404);
        }
        if ($application->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized action.'], 403);
        }
        if ($application->status !== 'pending') {
            return response()->json(['error' => 'This application has already been processed.'], 422);
        }

        $user = $application->user;
        $job = $application->job;

        // --- Generate and store a unique transaction ID ---
        $transaction_id = 'APP_' . $application->id . '_' . uniqid();
        $application->update(['transaction_id' => $transaction_id]);

        # Prepare the data array for SSLCOMMERZ
        $post_data = array();
        $post_data['total_amount'] = $application->due_amount;
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = $transaction_id;

        # Set the same callback URLs as before
        $post_data['success_url'] = route('payment.success');
        $post_data['fail_url'] = route('payment.fail');
        $post_data['cancel_url'] = route('payment.cancel');
        $post_data['ipn_url'] = route('payment.ipn');

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $user->name;
        $post_data['cus_email'] = $user->email;
        $post_data['cus_phone'] = isset($user->profile) ? $user->profile->phone_mobile : '01000000000';
        $post_data['cus_add1'] = 'N/A';
        $post_data['cus_country'] = "Bangladesh";

        # PRODUCT INFORMATION
        $post_data['product_name'] = "Job Application Fee";
        $post_data['product_category'] = "Service";
        $post_data['product_profile'] = "non-physical-goods";
        $post_data['shipping_method'] = "NO";

        $sslc = new SslCommerzNotification();

        # The key difference is the third parameter: 'json'
        # This tells the library to return the API response as JSON instead of redirecting.
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (is_array($payment_options) && array_key_exists('GatewayPageURL', $payment_options)) {
            // Return the JSON response that the embed.js script is expecting
            return json_encode($payment_options);
        } else {
            // If the API call fails, return an error JSON
            Log::error("SSLCommerz AJAX API Error:", (array)$payment_options);
            return response()->json(['error' => 'Could not connect to payment gateway.'], 500);
        }
    }

    /**
     * Handle the CANCEL callback from SSLCOMMERZ.
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
        if ($request->input('tran_id')) {
            $this->success($request);
        }
    }
}
