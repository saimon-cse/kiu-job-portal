<x-guest-layout>
    <div class="text-center">
        <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100">
            <i class="fas fa-check-circle text-5xl text-green-600"></i>
        </div>
        <h2 class="mt-6 text-2xl font-bold text-gray-900">Payment Successful!</h2>

        <p class="mt-2 text-gray-600">
            {{ $message ?? 'Your application has been successfully submitted. You will be notified of any updates.' }}
        </p>

        @if(isset($transaction_id))
            <div class="mt-4 text-sm text-gray-500">
                <p>Transaction ID: <span class="font-mono bg-gray-100 p-1 rounded">{{ $transaction_id }}</span></p>
            </div>
        @endif

        <div class="mt-8">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-white hover:bg-primary-700">
                Go to Dashboard
            </a>
        </div>
    </div>
</x-guest-layout>
