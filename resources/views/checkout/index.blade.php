@extends('layouts.app')

@section('title')
    Tailored Wool Coat - LuxeThread
@endsection

@section('body')
<style>
    .thumb-list {
        display: flex;
        gap: 10px;
    }

    .thumb-item {
        width: 100%;
        height: 100px;
        overflow: hidden;
        background: #f0f0f0;
        cursor: pointer;
        border: 1px solid transparent;
        transition: var(--transition);
    }

    .thumb-item:hover { border-color: var(--accent-color); }

    .thumb-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .main-img-wrapper {
        overflow: hidden;
        background: #f0f0f0;
        height: 600px;
    }

    .main-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-details-title {
        font-family: 'Playfair Display', serif;
        font-weight: 600;
        font-size: 2.2rem;
    }

    .product-price {
        color: var(--accent-color);
        font-weight: 600;
        font-size: 1.8rem;
        margin-bottom: 20px;
    }

    .color-swatch {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 12px;
        cursor: pointer;
        border: 2px solid var(--white);
        box-shadow: 0 0 0 1px var(--border-color);
        transition: var(--transition);
    }

    .color-swatch.active { box-shadow: 0 0 0 2px var(--accent-color); }

z
    .measurement-input {
        border-radius: 0;
        border: 1px solid var(--border-color);
        padding: 10px;
        font-size: 0.85rem;
        margin-bottom: 15px;
    }

    .measurement-input:focus {
        border-color: var(--accent-color);
        box-shadow: none;
    }

    .custom-notice {
        border: 1px solid #eddccf;
        padding: 12px;
        color: #1b8e76;
        font-weight: 500;
        text-align: center;
        font-size: 0.9rem;
    }

    .btn-cart {
        background: var(--text-main);
        color: var(--white);
        border-radius: 0;
        font-size: 0.9rem;
        text-transform: uppercase;
        padding: 15px;
        border: none;
        width: 100%;
        font-weight: 600;
        letter-spacing: 1px;
        transition: var(--transition);
    }

    .btn-cart:hover {
        background: var(--accent-color);
        color: var(--white);
    }

    @media (max-width: 768px) {
        .main-img-wrapper { height: 400px; }
        .thumb-list { flex-direction: row !important; margin-top: 15px; }
        .thumb-item { width: 80px; height: 80px; }
    }
</style>

<main class="container my-5">
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="row">
                <div class="col-md-2 order-2 order-md-1">
                    <div class="thumb-list flex-column">
                        <div class="thumb-item" onclick="updateMainImage('https://images.unsplash.com/photo-1539109136881-3be0616acf4b?w=600')">
                            <img src="https://images.unsplash.com/photo-1539109136881-3be0616acf4b?w=200">
                        </div>
                        <div class="thumb-item" onclick="updateMainImage('https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=600')">
                            <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=200">
                        </div>
                        <div class="thumb-item" onclick="updateMainImage('https://images.unsplash.com/photo-1544022613-e87ca75a784a?w=600')">
                            <img src="https://images.unsplash.com/photo-1544022613-e87ca75a784a?w=200">
                        </div>
                        <div class="thumb-item" onclick="updateMainImage('https://images.unsplash.com/photo-1511401139252-f158d3209c17?w=600')">
                            <img src="https://images.unsplash.com/photo-1511401139252-f158d3209c17?w=200">
                        </div>
                    </div>
                </div>
                <div class="col-md-10 order-1 order-md-2">
                    <div class="main-img-wrapper">
                        <img id="primaryDisplay" src="https://images.unsplash.com/photo-1539109136881-3be0616acf4b?auto=format&fit=crop&w=600&q=80">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <h1 class="product-details-title">Tailored Wool Coat</h1>
            <div class="product-price">$180.00 <del class="text-muted ml-3" style="font-size: 1.1rem; font-weight: 400;">$240.00</del></div>

            <p class="text-muted mb-4">
                A masterpiece of winter elegance. Our Tailored Wool Coat features a high-density wool blend, premium satin lining, and a structured silhouette that commands attention in any setting.
            </p>

            <div class="mb-4">
                <label class="font-weight-bold small text-uppercase">Color:</label><br>
                <div class="color-swatch active" style="background: #1a1a1a;"></div>
                <div class="color-swatch" style="background: #4b3621;"></div>
                <div class="color-swatch" style="background: #2e4053;"></div>
                <div class="color-swatch" style="background: #8e8e8e;"></div>
            </div>

            <div class="mb-4">
                <label class="font-weight-bold small text-uppercase">Select Size:</label>
                <select class="form-control rounded-0" id="sizePicker" onchange="checkCustomOption()">
                    <option value="s">Small (S)</option>
                    <option value="m">Medium (M)</option>
                    <option value="l">Large (L)</option>
                    <option value="xl">Extra Large (XL)</option>
                    <option value="xxl">Double XL (XXL)</option>
                    <option value="custom">Custom Design (+ Rs.10,000 PKR)</option>
                </select>
            </div>

            <div id="custom-design-form">
                <div class="custom-notice mb-4">
                    Selection will add Rs.10,000.00 PKR to the price
                </div>
                <div class="row no-gutters">
                    <div class="col-6 pr-1"><input type="text" class="form-control measurement-input" placeholder="Widht"></div>
                    <div class="col-6 pl-1"><input type="text" class="form-control measurement-input" placeholder="Height"></div>
                    <div class="col-12 mt-2">
                        <label class="small font-weight-bold text-uppercase">Reference Image:</label>
                        <input type="file" class="form-control-file border p-2" style="font-size: 0.8rem;">
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button class="btn-cart">Add to Cart</button>
            </div>
        </div>
    </div>
</main>

<script>
    function updateMainImage(src) {
        document.getElementById('primaryDisplay').src = src;
    }

    function checkCustomOption() {
        const picker = document.getElementById('sizePicker');
        const form = document.getElementById('custom-design-form');
        form.style.display = (picker.value === 'custom') ? 'block' : 'none';
    }

    document.querySelectorAll('.color-swatch').forEach(swatch => {
        swatch.addEventListener('click', function() {
            document.querySelector('.color-swatch.active').classList.remove('active');
            this.classList.add('active');
        });
    });
</script>
@endsection