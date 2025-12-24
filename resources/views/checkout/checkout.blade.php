@extends('layouts.app')

@section('title')
    Checkout - LuxeThread
@endsection

@section('body')
    <style>
        .checkout-title {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            font-size: 1.8rem;
            margin-bottom: 30px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 10px;
        }

        .checkout-card {
            background: var(--white);
            border: 1px solid var(--border-color);
            padding: 30px;
            margin-bottom: 20px;
        }

        .form-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .measurement-input {
            border-radius: 0;
            border: 1px solid var(--border-color);
            padding: 12px;
            font-size: 0.9rem;
            margin-bottom: 20px;
            width: 100%;
            outline: none;
            transition: var(--transition);
        }

        .measurement-input:focus {
            border-color: var(--accent-color);
        }

        .order-summary {
            background: var(--white);
            border: 1px solid var(--border-color);
            padding: 25px;
            position: sticky;
            top: 20px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 0.95rem;
        }

        .product-mini-card {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }

        .product-mini-card img {
            width: 70px;
            height: 80px;
            object-fit: cover;
            background: #f0f0f0;
        }

        .total-row {
            border-top: 2px solid var(--border-color);
            margin-top: 15px;
            padding-top: 15px;
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--accent-color);
        }

        .payment-option {
            border: 1px solid var(--border-color);
            padding: 15px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .payment-option:hover {
            border-color: var(--accent-color);
        }

        input[type="radio"] {
            accent-color: var(--accent-color);
        }
    </style>

    <main class="container my-5">
        <div class="row">
            <div class="col-lg-8">
                <h2 class="checkout-title">Billing Details</h2>
                <div class="checkout-card">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">First Name</label>
                            <input type="text" class="measurement-input" placeholder="John">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="measurement-input" placeholder="Doe">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Street Address</label>
                            <input type="text" class="measurement-input" placeholder="House number and street name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Town / City</label>
                            <input type="text" class="measurement-input">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Postcode / ZIP</label>
                            <input type="text" class="measurement-input">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="tel" class="measurement-input">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="measurement-input">
                        </div>
                    </div>
                </div>

                <h2 class="checkout-title">Payment Method</h2>
                <div class="checkout-card">
                    <label class="payment-option">
                        <input type="radio" name="payment" checked>
                        <span>Cash on Delivery (COD)</span>
                    </label>
                    <label class="payment-option">
                        <input type="radio" name="payment">
                        <span>Bank Transfer</span>
                    </label>
                    <label class="payment-option">
                        <input type="radio" name="payment">
                        <span>Credit / Debit Card</span>
                    </label>
                </div>
            </div>

            <div class="col-lg-4 mt-5">
                <div class="order-summary mt-4">
                    <h3 class="form-label mb-4">Your Order</h3>

                    @php
                        $subtotal = 0;
                        $shipping = 10;
                    @endphp

                    @forelse($cart as $item)
                        @php $subtotal += $item['price']; @endphp

                        <div class="product-mini-card">
                            <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-100 h-100"
                                style="object-fit:cover;">

                            <div>
                                <div style="font-weight:600">
                                    {{ $item['name'] }}
                                </div>

                                <div class="text-muted small">
                                    Color: {{ ucfirst($item['color']) }} <br>
                                    Size: {{ strtoupper($item['size']) }} <br>
                                    Qty: {{ $item['quantity'] }}
                                </div>

                                @if(!empty($item['weight']))
                                    <div class="text-muted small">
                                        {{ $item['weight'] }}
                                    </div>
                                @endif

                                <div style="color:var(--accent-color);font-weight:600">
                                    ${{ number_format($item['price'], 2) }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">Your cart is empty.</p>
                    @endforelse

                    <div class="summary-item">
                        <span>Subtotal</span>
                        <span>${{ number_format($subtotal, 2) }}</span>
                    </div>

                    <div class="summary-item">
                        <span>Shipping</span>
                        <span>${{ number_format($shipping, 2) }}</span>
                    </div>

                    <div class="summary-item total-row">
                        <span>Total</span>
                        <span>${{ number_format($subtotal + $shipping, 2) }}</span>
                    </div>

                    <button type="submit" class="btn-cart mt-4">
                        Place Order
                    </button>
                </div>
            </div>

        </div>
    </main>
@endsection