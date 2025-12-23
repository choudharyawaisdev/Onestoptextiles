@extends('layouts.app')
@section('title', $product->name . ' - LuxeThread')
@section('body')
    <main class="container my-5">
        <div class="row">
            {{-- Image Section --}}
            <div class="col-md-6 mb-4">
                <div class="row">
                    <div class="col-md-2 order-2 order-md-1">
                        <div class="thumb-list flex-column" id="thumbnailContainer">
                            <div class="thumb-item"
                                onclick="updateMainImage('{{ asset('storage/' . $product->main_image) }}')">
                                <img src="{{ asset('storage/' . $product->main_image) }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 order-1 order-md-2">
                        <div class="main-img-wrapper">
                            <img id="primaryDisplay" src="{{ asset('storage/' . $product->main_image) }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Details Section --}}
            <div class="col-md-6">
                <h1 class="product-details-title">{{ $product->name }}</h1>
                <div class="product-price" id="displayPrice">${{ number_format($product->price, 2) }}</div>

                <div id="weightDisplay" class="text-muted small mb-2" style="font-weight: 500;"></div>

                <p class="text-muted mb-4" id="displayDescription">{{ $product->description }}</p>

                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    {{-- Color Selection --}}
                    <div class="mb-4">
                        <label class="small text-uppercase font-weight-bold">Color</label><br>
                        <div id="colorContainer">
                            @foreach($product->variations->unique('color') as $i => $variation)
                                <span class="color-swatch {{ $i === 0 ? 'active' : '' }}"
                                    style="background: {{ $variation->color }}; width:30px; height:30px; display:inline-block; cursor:pointer; border:1px solid #ddd;"
                                    onclick="filterByColor(this, '{{ $variation->color }}')">
                                </span>
                            @endforeach
                        </div>
                        <input type="hidden" name="selected_color" id="selectedColor" value="">
                    </div>

                    {{-- Size Selection (Dropdown) --}}
                    <div class="mb-4">
                        <label class="small text-uppercase font-weight-bold">Select Size</label>
                        <select class="form-control rounded-0" name="size" id="sizePicker" onchange="updateDetails()">
                            <option value="">Choose Size</option>
                        </select>
                    </div>

                    {{-- Quantity Selection --}}
                    <div class="mb-4">
                        <label class="small text-uppercase font-weight-bold">Quantity</label>
                        <input type="number" name="quantity" id="quantityInput" class="form-control rounded-0" value="1"
                            min="1" style="width: 100px;" oninput="updateDetails()">
                    </div>

                    <div id="custom-design-form" style="display:none;">
                        <div class="custom-notice mb-4">Selection will add Rs.10,000.00 PKR</div>
                        <div class="row no-gutters">
                            <div class="col-6 pr-1"><input type="text" name="custom_width" class="form-control"
                                    placeholder="Width"></div>
                            <div class="col-6 pl-1"><input type="text" name="custom_height" class="form-control"
                                    placeholder="Height"></div>
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
        // Variations injected from PHP (includes weight, price, size, color)
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

            // Update thumbnails for this color
            const thumbContainer = document.getElementById('thumbnailContainer');
            thumbContainer.innerHTML = '';
            filteredVariations.forEach(v => {
                const imgs = Array.isArray(v.images) ? v.images : JSON.parse(v.images || '[]');
                imgs.forEach(img => {
                    thumbContainer.innerHTML += `
                                    <div class="thumb-item" onclick="updateMainImage('${storageUrl + img}')">
                                        <img src="${storageUrl + img}" style="width:50px; height:50px; object-fit:cover;">
                                    </div>`;
                });
            });

            // Set default image for selected color
            if (filteredVariations.length > 0) {
                const firstVarImgs = Array.isArray(filteredVariations[0].images) ? filteredVariations[0].images : JSON.parse(filteredVariations[0].images || '[]');
                if (firstVarImgs.length > 0) updateMainImage(storageUrl + firstVarImgs[0]);
            }
            updateDetails();
        }

        function updateDetails() {
            const selectedSize = document.getElementById('sizePicker').value;
            const selectedColor = document.getElementById('selectedColor').value;
            const customForm = document.getElementById('custom-design-form');
            const qty = parseInt(document.getElementById('quantityInput').value) || 1;
            const weightBox = document.getElementById('weightDisplay');

            if (selectedSize === 'custom') {
                customForm.style.display = 'block';
                currentUnitPrice = {{ $product->price }}; // Or add the custom fee logic here
                weightBox.innerText = "";
            } else {
                customForm.style.display = 'none';

                // Find the specific row from the variations table
                const variation = variations.find(v => v.size === selectedSize && v.color === selectedColor);

                if (variation) {
                    currentUnitPrice = parseFloat(variation.price);
                    document.getElementById('displayPrice').innerText = '$' + currentUnitPrice.toFixed(2);
                    document.getElementById('displayDescription').innerText = variation.description || "{{ $product->description }}";

                    // FETCH AND DISPLAY WEIGHT FROM VARIATION
                    if (variation.weight) {
                        weightBox.innerText = "Weight: " + variation.weight + "kg";
                    } else {
                        weightBox.innerText = "";
                    }
                }
            }

            // UPDATE BUTTON PRICE (Unit Price * Quantity)
            const total = currentUnitPrice * qty;
            document.getElementById('btnPrice').innerText = total.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        window.onload = () => {
            const firstSwatch = document.querySelector('.color-swatch');
            if (firstSwatch) firstSwatch.click();
        };
    </script>
@endsection