@extends('layouts.app')

@section('title')
    Create Menu Item
@endsection

@section('body')
   <main class="container my-5">
    <div class="row">
        <div class="col-6 col-md-4 col-lg-3 mb-4">
            <div class="product-card shadow-sm border-0">
                <div class="img-wrapper overflow-hidden" style="height: 300px; background: #f8f9fa;">
                    <img src="https://images.unsplash.com/photo-1539109136881-3be0616acf4b?auto=format&fit=crop&w=600&q=80" class="w-100 h-100" style="object-fit: cover;" alt="Product">
                </div>
                <div class="card-body bg-white text-center">
                    <div class="rating mb-2" style="color: #ffc107; font-size: 0.8rem;">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                        <span class="text-muted small">(4.5)</span>
                    </div>
                    
                    <p class="product-title font-weight-bold mb-1" style="font-size: 1rem;">Tailored Wool Coat</p>
                    
                    <p class="product-desc text-muted small mb-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        Premium winter blend with a soft interior lining and modern slim-fit cut.
                    </p>

                    <div class="price-box mb-3">
                        <span class="product-price font-weight-bold" style="color: #c5a992; font-size: 1.1rem;">$180.00</span>
                        <small class="text-muted ml-2"><del>$240.00</del></small>
                    </div>

                    <button class="btn btn-dark btn-sm btn-block rounded-0 add-to-cart">Add to Cart</button>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-lg-3 mb-4">
            <div class="product-card shadow-sm border-0">
                <div class="img-wrapper overflow-hidden" style="height: 300px; background: #f8f9fa;">
                    <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=600&q=80" class="w-100 h-100" style="object-fit: cover;" alt="Product">
                </div>
                <div class="card-body bg-white text-center">
                    <div class="rating mb-2" style="color: #ffc107; font-size: 0.8rem;">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                        <span class="text-muted small">(4.0)</span>
                    </div>
                    
                    <p class="product-title font-weight-bold mb-1" style="font-size: 1rem;">Yellow Summer Maxi</p>
                    
                    <p class="product-desc text-muted small mb-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        Lightweight breathable cotton fabric, perfect for beach outings and sunny days.
                    </p>

                    <div class="price-box mb-3">
                        <span class="product-price font-weight-bold" style="color: #c5a992; font-size: 1.1rem;">$95.00</span>
                        <small class="text-muted ml-2"><del>$130.00</del></small>
                    </div>

                    <button class="btn btn-dark btn-sm btn-block rounded-0 add-to-cart">Add to Cart</button>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-lg-3 mb-4">
            <div class="product-card shadow-sm border-0">
                <div class="img-wrapper overflow-hidden" style="height: 300px; background: #f8f9fa;">
                    <img src="https://images.unsplash.com/photo-1543076447-215ad9ba6923?auto=format&fit=crop&w=600&q=80" class="w-100 h-100" style="object-fit: cover;" alt="Product">
                </div>
                <div class="card-body bg-white text-center">
                    <div class="rating mb-2" style="color: #ffc107; font-size: 0.8rem;">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <span class="text-muted small">(5.0)</span>
                    </div>
                    
                    <p class="product-title font-weight-bold mb-1" style="font-size: 1rem;">Denim Casual Jacket</p>
                    
                    <p class="product-desc text-muted small mb-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        Vintage washed denim with industrial silver buttons and four-pocket utility.
                    </p>

                    <div class="price-box mb-3">
                        <span class="product-price font-weight-bold" style="color: #c5a992; font-size: 1.1rem;">$120.00</span>
                        <small class="text-muted ml-2"><del>$160.00</del></small>
                    </div>

                    <button class="btn btn-dark btn-sm btn-block rounded-0 add-to-cart">Add to Cart</button>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-lg-3 mb-4">
            <div class="product-card shadow-sm border-0">
                <div class="img-wrapper overflow-hidden" style="height: 300px; background: #f8f9fa;">
                    <img src="https://images.unsplash.com/photo-1434389677669-e08b4cac3105?auto=format&fit=crop&w=600&q=80" class="w-100 h-100" style="object-fit: cover;" alt="Product">
                </div>
                <div class="card-body bg-white text-center">
                    <div class="rating mb-2" style="color: #ffc107; font-size: 0.8rem;">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i><i class="far fa-star"></i>
                        <span class="text-muted small">(3.8)</span>
                    </div>
                    
                    <p class="product-title font-weight-bold mb-1" style="font-size: 1rem;">White Silk Blouse</p>
                    
                    <p class="product-desc text-muted small mb-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        Elegant pure silk blouse with a draped neckline, perfect for office or dinner.
                    </p>

                    <div class="price-box mb-3">
                        <span class="product-price font-weight-bold" style="color: #c5a992; font-size: 1.1rem;">$75.00</span>
                        <small class="text-muted ml-2"><del>$110.00</del></small>
                    </div>

                    <button class="btn btn-dark btn-sm btn-block rounded-0 add-to-cart">Add to Cart</button>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection