@extends('layouts.app')
@section('title', $product->name . ' - LuxeThread')
@section('body')

    <main class="container my-5">
        <div class="row">
            {{-- Image Section: Thumbnails + Main Image --}}
            <div class="col-md-7 mb-4">
                <div class="row g-2">
                    <div class="col-2">
                        <div id="thumbnailContainer" class="d-flex flex-column gap-2"
                            style="max-height: 500px; overflow-y: auto;">
                            <div class="thumb-item border active"
                                onclick="updateMainImage('{{ asset('storage/' . $product->main_image) }}', this)"
                                style="cursor:pointer;">
                                <img src="{{ asset('storage/' . $product->main_image) }}" class="img-fluid w-100"
                                    style="object-fit: cover; aspect-ratio: 1/1;">
                            </div>
                        </div>
                    </div>

                    <div class="col-10">
                        <div class="main-img-wrapper border overflow-hidden" style="background:#f8f9fa; height: 500px;">
                            <img id="mainProductImage" src="{{ asset('storage/' . $product->main_image) }}"
                                alt="{{ $product->name }}" class="w-100 h-100" style="object-fit:contain;">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Product Info Section --}}
            <div class="col-md-5">
                <h1 class="product-details-title h2 fw-bold">{{ $product->name }}</h1>
                <div class="h3 text-primary mb-2" id="displayPrice">${{ number_format($product->price, 2) }}</div>
                <div id="weightDisplay" class="text-muted small mb-3"></div>

                @if($product->description)
                    <p class="text-secondary mb-4" id="displayDescription">{{ $product->description }}</p>
                @endif

                <ul class="product-attributes list-unstyled mb-4 small">
                    @if($product->material)
                        <li class="mb-1"><strong>Material:</strong> {{ $product->material }}</li>
                    @endif
                    @if($product->unit)
                        <li class="mb-1"><strong>Unit:</strong> {{ $product->unit }}</li>
                    @endif
                </ul>

                <form method="POST" action="{{ route('cart.add') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    {{-- Color Selection --}}
                    <div class="mb-4">
                        <label class="small text-uppercase fw-bold d-block mb-2">Color</label>
                        <div id="colorContainer" class="d-flex gap-2 mb-2">
                            @foreach($product->variations->unique('color') as $i => $variation)
                                <span class="color-swatch rounded-circle border {{ $i === 0 ? 'active-swatch' : '' }}"
                                    style="background: {{ $variation->color }}; width:35px; height:35px; display:inline-block; cursor:pointer;"
                                    onclick="filterByColor(this, '{{ $variation->color }}')">
                                </span>
                            @endforeach
                        </div>
                        <input type="hidden" name="selected_color" id="selectedColor">
                    </div>

                    {{-- Size Selection --}}
                    <div class="mb-4">
                        <label class="small text-uppercase fw-bold d-block mb-2">Select Size</label>
                        <select class="form-control" name="size" id="sizePicker" onchange="updateDetails()">
                            <option value="">Choose Size</option>
                        </select>
                    </div>

                    {{-- Quantity --}}
                    <div class="mb-4">
                        <label class="small text-uppercase fw-bold d-block mb-2">Quantity</label>
                        <input type="number" name="quantity" id="quantityInput" class="form-control" value="1" min="1"
                            oninput="updateDetails()">
                    </div>

                    {{-- Addons --}}
                    @if($product->addons->count() > 0)
                        <div class="mb-4 p-3 bg-light border">
                            <label class="small text-uppercase fw-bold d-block mb-2">Available Add-ons</label>
                            @foreach($product->addons as $addon)
                                <div class="form-check mb-2">
                                    <input class="form-check-input addon-checkbox" type="checkbox" name="addon_ids[]"
                                        value="{{ $addon->id }}" data-price="{{ $addon->price }}" id="addon{{ $addon->id }}"
                                        onchange="updateDetails()">
                                    <label class="form-check-label small" for="addon{{ $addon->id }}">
                                        {{ $addon->title }} (+${{ number_format($addon->price, 2) }})
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <button type="submit" class="btn btn-dark w-100 py-3 fw-bold" id="addToCartBtn">
                        ADD TO CART - $<span id="btnPrice">{{ number_format($product->price, 2) }}</span>
                    </button>
                </form>
            </div>
        </div>
    </main>

    <style>
        .color-swatch.active-swatch {
            outline: 2px solid #000;
            outline-offset: 2px;
        }

        .thumb-item {
            opacity: 0.6;
            transition: 0.3s;
            border: 2px solid transparent !important;
        }

        .thumb-item.active,
        .thumb-item:hover {
            opacity: 1;
            border-color: #000 !important;
        }

        .thumb-item img {
            aspect-ratio: 1/1;
            object-fit: cover;
        }

        /* Style consistency for number input */
        input[type=number].form-control {
            text-align: left;
        }
    </style>

    <script>
        const variations = @json($product->variations);
        const storageUrl = "{{ asset('storage/') }}/";
        const mainProductImage = "{{ asset('storage/' . $product->main_image) }}";

        function updateMainImage(src, element) {
            document.getElementById('mainProductImage').src = src;
            document.querySelectorAll('.thumb-item').forEach(t => t.classList.remove('active'));
            if (element) element.classList.add('active');
        }

        function filterByColor(el, color) {
            document.querySelectorAll('.color-swatch').forEach(s => s.classList.remove('active-swatch'));
            el.classList.add('active-swatch');
            document.getElementById('selectedColor').value = color;

            const filteredVariations = variations.filter(v => v.color === color);
            const sizePicker = document.getElementById('sizePicker');
            sizePicker.innerHTML = '<option value="">Choose Size</option>';

            filteredVariations.forEach(v => {
                sizePicker.innerHTML += `<option value="${v.size}">${v.size.toUpperCase()}</option>`;
            });

            const thumbContainer = document.getElementById('thumbnailContainer');
            thumbContainer.innerHTML = `
                    <div class="thumb-item border active" onclick="updateMainImage('${mainProductImage}', this)">
                        <img src="${mainProductImage}" class="img-fluid w-100">
                    </div>`;

            filteredVariations.forEach(v => {
                if (v.image) {
                    thumbContainer.innerHTML += `
                            <div class="thumb-item border" onclick="updateMainImage('${storageUrl + v.image}', this)">
                                <img src="${storageUrl + v.image}" class="img-fluid w-100">
                            </div>`;
                }
            });

            if (filteredVariations.length > 0 && filteredVariations[0].image) {
                updateMainImage(storageUrl + filteredVariations[0].image, thumbContainer.children[1]);
            }

            updateDetails();
        }

        function updateDetails() {
            const size = document.getElementById('sizePicker').value;
            const color = document.getElementById('selectedColor').value;
            const qty = parseInt(document.getElementById('quantityInput').value) || 1;

            let unitPrice = {{ $product->price }};

            if (size) {
                const variation = variations.find(v => v.size === size && v.color === color);
                if (variation) {
                    unitPrice = parseFloat(variation.price);
                    document.getElementById('displayPrice').innerText = '$' + unitPrice.toFixed(2);
                    if (variation.weight) document.getElementById('weightDisplay').innerText = 'Weight: ' + variation.weight;
                    if (variation.image) updateMainImage(storageUrl + variation.image);
                }
            }

            let totalPrice = unitPrice;
            document.querySelectorAll('.addon-checkbox:checked').forEach(cb => {
                totalPrice += parseFloat(cb.dataset.price);
            });

            document.getElementById('btnPrice').innerText = (totalPrice * qty).toFixed(2);
        }

        window.onload = () => {
            const firstSwatch = document.querySelector('.color-swatch');
            if (firstSwatch) firstSwatch.click();
        };
    </script>

@endsection