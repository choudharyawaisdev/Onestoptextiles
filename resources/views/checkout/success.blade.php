@extends('layouts.app')

@section('title')
    Order Success - LuxeThread
@endsection

@section('body')
<style>
    :root {
        --success-green: #2ecc71;
    }

    .success-container {
        max-width: 800px;
        margin: 80px auto;
        text-align: center;
        animation: fadeIn 0.8s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .success-icon {
        font-size: 5rem;
        color: var(--success-green);
        margin-bottom: 20px;
    }

    .success-title {
        font-family: 'Playfair Display', serif;
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: var(--text-main);
    }

    .order-number {
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 600;
        color: var(--accent-color);
        margin-bottom: 40px;
    }

    .confirmation-card {
        background: #fff;
        border: 1px solid var(--border-color);
        padding: 40px;
        text-align: left;
        margin-bottom: 30px;
    }

    .summary-heading {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 15px;
        margin-bottom: 20px;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 0.95rem;
    }

    .btn-luxe-outline {
        border: 1px solid var(--text-main);
        color: var(--text-main);
        background: transparent;
        padding: 15px 40px;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 1px;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-luxe-outline:hover {
        background: var(--text-main);
        color: #fff;
    }

    .check-mark-circle {
        width: 100px;
        height: 100px;
        background: #f0fdf4;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 30px;
    }

    .track-link {
        color: var(--accent-color);
        text-decoration: underline;
        font-weight: 600;
    }
</style>

<main class="container">
    <div class="success-container">
        <div class="check-mark-circle">
            <svg width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="#2ecc71" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>
        
        <h1 class="success-title">Thank You!</h1>
        <p class="lead text-muted">Your order has been placed successfully.</p>
        <div class="order-number">Order #LT-88291</div>

        <div class="confirmation-card shadow-sm">
            <h3 class="summary-heading">Order Confirmation</h3>
            
            <div class="detail-row">
                <span class="text-muted">Date:</span>
                <span class="font-weight-bold">October 24, 2023</span>
            </div>
            
            <div class="detail-row">
                <span class="text-muted">Payment Method:</span>
                <span class="font-weight-bold">Cash on Delivery</span>
            </div>

            <div class="detail-row">
                <span class="text-muted">Shipping To:</span>
                <span class="font-weight-bold text-right">House 123, Street 5,<br>Faisalabad, 38000</span>
            </div>

            <hr>

            <div class="detail-row" style="font-size: 1.2rem; color: var(--accent-color);">
                <span class="font-weight-bold">Total Amount paid:</span>
                <span class="font-weight-bold">$225.00</span>
            </div>
        </div>

        <p class="mb-5">
            A confirmation email has been sent to your inbox. <br>
            You can <a href="#" class="track-link">track your order status</a> in your account dashboard.
        </p>

        <div class="d-flex flex-column flex-md-row justify-content-center gap-3" style="gap: 20px;">
            <a href="/shop" class="btn-luxe-outline">Continue Shopping</a>
            <a href="/orders" class="btn-luxe-outline" style="background: var(--text-main); color: #fff;">View My Orders</a>
        </div>
    </div>
</main>
@endsection