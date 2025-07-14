<x-app-layout>
    {{-- Page Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Complete Your Payment</h1>
        <p class="text-gray-500">Please review the details below before proceeding to our secure payment gateway.</p>
    </div>

    @include('partials._session-messages')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Left Column: Payment Form & Action --}}
        <div class="lg:col-span-2">
            <div class="bg-white p-6 rounded-xl shadow-soft">
                <h2 class="text-lg font-semibold text-gray-900 border-b pb-4 mb-6">Payment Confirmation</h2>

                {{-- This form will submit to your PaymentController@store method, which then handles the gateway redirect --}}
                <form action="{{ route('payment.store') }}" method="POST">
                    @csrf
                    {{-- Hidden input to pass the application ID to the controller --}}
                    <input type="hidden" name="application_id" value="{{ $application->id }}">

                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Applying for Post:</span>
                            <span class="font-semibold text-gray-800">{{ $application->job->post_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">From Circular No:</span>
                            <span class="font-semibold text-gray-800">{{ $application->job->circular->circular_no }}</span>
                        </div>
                        <div class="border-t my-4"></div>
                        <div class="flex justify-between text-lg">
                            <span class="font-bold text-gray-700">Total Amount Due:</span>
                            <span class="font-bold text-primary-600">BDT {{ number_format($application->due_amount, 2) }}</span>
                        </div>
                    </div>

                    <div class="mt-8 border-t pt-6">
                        <button type="submit" class="w-full flex items-center justify-center bg-primary-600 hover:bg-primary-700 text-white py-3 px-6 rounded-lg font-semibold text-base">
                            <i class="fas fa-lock mr-2"></i>
                            Proceed to Secure Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Right Column: Instructions/Help --}}
        <div class="lg:col-span-1">
            <div class="bg-blue-50 border-l-4 border-blue-400 p-6 rounded-r-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                         <i class="fas fa-info-circle text-blue-500 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-blue-800">What Happens Next?</h3>
                        <div class="mt-2 text-sm text-blue-700 space-y-2">
                            <p>1. Clicking "Proceed" will take you to our secure payment partner's website.</p>
                            <p>2. You can complete the payment using bKash, Nagad, Rocket, or your debit/credit card.</p>
                            <p>3. After a successful payment, you will be redirected back here, and your application status will be updated to "Submitted".</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
