@extends('layouts.master')
@section('title', 'Pay with Razorpay')
@section('content')
<section class="checkout-area ptb-80 text-center" style="min-height: 400px; padding: 100px 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm p-4">
                    <h3 class="mb-4 text-rose">Processing Payment...</h3>
                    <p class="mb-4 text-muted">Please click the button below if the payment window does not open automatically.</p>
                    
                    <style>
                        .razorpay-payment-button {
                            color: var(--theme-color, #7524b7) !important;
                            background-color: transparent !important;
                            border: 2px solid var(--theme-color, #7524b7) !important;
                            padding: 12px 30px !important;
                            font-size: 16px !important;
                            font-weight: 600 !important;
                            border-radius: 25px !important;
                            transition: all 0.3s ease-in-out !important;
                            cursor: pointer !important;
                            width: 100% !important;
                            margin-top: 15px !important;
                            display: inline-block !important;
                            text-align: center !important;
                        }
                        .razorpay-payment-button:hover {
                            color: #fff !important;
                            background-color: var(--theme-color, #7524b7) !important;
                            border-color: var(--theme-color, #7524b7) !important;
                        }
                    </style>
                    
                    <form action="{{ route('razorpay.callback') }}" method="POST" id="razorpayForm">
                        @csrf
                        <script
                            src="https://checkout.razorpay.com/v1/checkout.js"
                            data-key="{{ env('RAZORPAY_KEY_ID') }}"
                            data-amount="{{ $order->total * 100 }}"
                            data-currency="INR"
                            data-order_id="{{ $razorpay_order_id }}"
                            data-buttontext="Pay Now"
                            data-name="Ranayas"
                            data-description="Order #{{ $order->order_number }}"
                            data-prefill.name="{{ $order->user_name }}"
                            data-prefill.email="{{ $order->user->email }}"
                            data-prefill.contact="{{ $order->user->mobile }}"
                            data-theme.color="#f23e70"
                        ></script>
                        <input type="hidden" name="order_db_id" value="{{ $order->id }}">
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Auto-click the Razorpay payment button to trigger modal immediately
    window.onload = function() {
        var payButton = document.querySelector('.razorpay-payment-button');
        if (payButton) {
            payButton.click();
        }
    };
</script>
@endsection
