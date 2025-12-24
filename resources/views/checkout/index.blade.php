@extends('layouts.app')
@section('title', $product->name . ' - LuxeThread')
@section('body')

    <main class="container my-5">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="row">
                    <div class="col-md-2 order-2 order-md-1">
                        <div class="thumb-list flex-column" id="thumbnailContainer">
                            @foreach($product->main_image as $imagePath)
                                <div class="thumb-item" onclick="updateMainImage('{{ $imagePath }}')">
                                    <img src="{{ $imagePath }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-10 order-1 order-md-2">
                        <div class="main-img-wrapper">
                            <img id="primaryDisplay" src="{{ $product->main_image[0] ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <h1 class="product-details-title">{{ $product->name }}</h1>
                <div class="product-price" id="displayPrice">${{ number_format($product->price, 2) }}</div>

                <div id="weightDisplay" class="text-muted small mb-2" style="font-weight:500;"></div>

                <p class="text-muted mb-4" id="displayDescription">{{ $product->description }}</p>

                <form method="POST" action="{{ route('cart.add') }}">
                    @csrf

                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="row">
                        <div class="col-12 mb-4">
                            <label class="small text-uppercase font-weight-bold">Color</label><br>
                            <div id="colorContainer">
                                @foreach($product->variations->unique('color') as $i => $variation)
                                    <span class="color-swatch {{ $i === 0 ? 'active' : '' }}"
                                        style="background: {{ $variation->color }}; width:30px; height:30px; display:inline-block; cursor:pointer; border:1px solid #ddd;"
                                        onclick="filterByColor(this, '{{ $variation->color }}')">
                                    </span>
                                @endforeach
                            </div>
                            <input type="hidden" name="selected_color" id="selectedColor">
                        </div>

                        <div class="col-md-12 mb-4">
                            <label class="small text-uppercase font-weight-bold">Select Size</label>
                            <select class="form-control rounded-0" name="size" id="sizePicker" onchange="updateDetails()">
                                <option value="">Choose Size</option>
                            </select>
                        </div>

                        <div class="col-md-12 mb-4">
                            <label class="small text-uppercase font-weight-bold">Quantity</label>
                            <input type="number" name="quantity" id="quantityInput"
                                class="form-control rounded-0 text-center" value="1" min="1" oninput="updateDetails()">
                        </div>
                    </div>

                    <div id="custom-design-form" style="display:none;">
                        <div class="custom-notice mb-3">Selection will add Rs.10,000.00 PKR</div>
                        <div class="row">
                            <div class="col-6">
                                <input type="text" name="custom_width" class="form-control" placeholder="Width">
                            </div>
                            <div class="col-6">
                                <input type="text" name="custom_height" class="form-control" placeholder="Height">
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn-cart w-100" id="addToCartBtn">
                            Add to Cart - $<span id="btnPrice">{{ number_format($product->price, 2) }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        const variations = @json($product->variations);
        const storageUrl = "{{ asset('storage/') }}/";
        let currentUnitPrice = {{ $product->price }};

        function updateMainImage(src) {
            document.getElementById('primaryDisplay').src = src;
        }

        function filterByColor(el, color) {
            document.querySelectorAll('.color-swatch').forEach(s => s.classList.remove('active'));
            el.classList.add('active');
            document.getElementById('selectedColor').value = color;

            const filteredVariations = variations.filter(v => v.color === color);
            const sizePicker = document.getElementById('sizePicker');
            sizePicker.innerHTML = '<option value="">Choose Size</option>';

            filteredVariations.forEach(v => {
                sizePicker.innerHTML += `<option value="${v.size}">${v.size.toUpperCase()}</option>`;
            });

            sizePicker.innerHTML += '<option value="custom">Custom Design (+ Rs.10,000 PKR)</option>';

            const thumbContainer = document.getElementById('thumbnailContainer');
            thumbContainer.innerHTML = '';

            filteredVariations.forEach(v => {
                const imgs = Array.isArray(v.images) ? v.images : JSON.parse(v.images || '[]');
                imgs.forEach(img => {
                    thumbContainer.innerHTML += `
                        <div class="thumb-item" onclick="updateMainImage('${storageUrl + img}')">
                            <img src="${storageUrl + img}" style="width:50px;height:50px;object-fit:cover;">
                        </div>`;
                });
            });

            if (filteredVariations.length > 0) {
                const firstImgs = Array.isArray(filteredVariations[0].images)
                    ? filteredVariations[0].images
                    : JSON.parse(filteredVariations[0].images || '[]');
                if (firstImgs.length > 0) updateMainImage(storageUrl + firstImgs[0]);
            }

            updateDetails();
        }

        function updateDetails() {
            const size = document.getElementById('sizePicker').value;
            const color = document.getElementById('selectedColor').value;
            const qty = parseInt(document.getElementById('quantityInput').value) || 1;
            const customForm = document.getElementById('custom-design-form');
            const weightBox = document.getElementById('weightDisplay');

            if (size === 'custom') {
                customForm.style.display = 'block';
                currentUnitPrice = {{ $product->price }};
                weightBox.innerText = '';
            } else {
                customForm.style.display = 'none';
                const variation = variations.find(v => v.size === size && v.color === color);

                if (variation) {
                    currentUnitPrice = parseFloat(variation.price);
                    document.getElementById('displayPrice').innerText = '$' + currentUnitPrice.toFixed(2);
                    document.getElementById('displayDescription').innerText = variation.description || "{{ $product->description }}";
                    weightBox.innerText = variation.weight ? 'Weight: ' + variation.weight + 'kg' : '';
                }
            }

            document.getElementById('btnPrice').innerText = (currentUnitPrice * qty).toFixed(2);
        }

        window.onload = () => {
            const firstSwatch = document.querySelector('.color-swatch');
            if (firstSwatch) firstSwatch.click();
        };
    </script>

@endsection