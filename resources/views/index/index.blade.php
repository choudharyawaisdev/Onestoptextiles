@extends('layouts.app')

@section('title')
    Create Menu Item
@endsection

@section('body')
    <main class="container my-5">
        <div class="row">
            <div class="col-6 col-md-4 col-lg-3">
                <div class="product-card">
                    <div class="img-wrapper">
                        <img src="https://images.unsplash.com/photo-1539109136881-3be0616acf4b?auto=format&fit=crop&w=600&q=80"
                            alt="Product">
                    </div>
                    <div class="card-body">
                        <p class="product-title">Tailored Wool Coat</p>
                        <p class="product-price">$180.00</p>
                        <button class="btn btn-cart add-to-cart">Add to Cart</button>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-3">
                <div class="product-card">
                    <div class="img-wrapper">
                        <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=600&q=80"
                            alt="Product">
                    </div>
                    <div class="card-body">
                        <p class="product-title">Yellow Summer Maxi</p>
                        <p class="product-price">$95.00</p>
                        <button class="btn btn-cart add-to-cart">Add to Cart</button>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-3">
                <div class="product-card">
                    <div class="img-wrapper">
                        <img src="https://images.unsplash.com/photo-1543076447-215ad9ba6923?auto=format&fit=crop&w=600&q=80"
                            alt="Product">
                    </div>
                    <div class="card-body">
                        <p class="product-title">Denim Casual Jacket</p>
                        <p class="product-price">$120.00</p>
                        <button class="btn btn-cart add-to-cart">Add to Cart</button>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-3">
                <div class="product-card">
                    <div class="img-wrapper">
                        <img src="https://images.unsplash.com/photo-1434389677669-e08b4cac3105?auto=format&fit=crop&w=600&q=80"
                            alt="Product">
                    </div>
                    <div class="card-body">
                        <p class="product-title">White Silk Blouse</p>
                        <p class="product-price">$75.00</p>
                        <button class="btn btn-cart add-to-cart">Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection