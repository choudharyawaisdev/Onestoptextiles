@extends('layouts.app')

@section('title', 'Menu Items')

@section('body')
    <main class="container my-5">
        <div class="row">
            @foreach ($products as $product)
                <div class="col-6 col-md-4 col-lg-3 mb-4">
                    <div class="product-card shadow-sm border-0 h-100">
                        <div class="img-wrapper overflow-hidden" style="height:300px; background:#f8f9fa;">
                            <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}"
                                class="w-100 h-100" style="object-fit:cover;">
                        </div>
                        <div class="card-body bg-white d-flex flex-column">
                            <h5 class="fw-bold" style="font-size:1rem;">
                                {{ \Illuminate\Support\Str::words($product->name, 7) }}
                            </h5>
                            <p class="text-muted small mb-2" style="min-height:40px;">
                                {{ \Illuminate\Support\Str::limit($product->description, 35) }}
                            </p>
                            <div class="mb-3 mt-auto">
                                <span class="fw-bold" style="color:#c5a992; font-size:1.1rem;">
                                    ${{ number_format($product->price, 2) }}
                                </span>
                            </div>
                            <button class="btn btn-dark btn-sm rounded-0 add-to-cart">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
@endsection