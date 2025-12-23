@extends('layouts.app')
@section('title', $product->name . ' - LuxeThread')
@section('body')
    <main class="container my-5">
        <div class="row">
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

            <div class="col-md-6">
                <h1 class="product-details-title">{{ $product->name }}</h1>
                <div class="product-price" id="displayPrice">${{ number_format($product->price, 2) }}</div>
                <p class="text-muted mb-4" id="displayDescription">{{ $product->description }}</p>

                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

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

                    <div class="mb-4">
                        <label class="small text-uppercase font-weight-bold">Select Size</label>
                        <select class="form-control rounded-0" name="size" id="sizePicker" onchange="updateDetails()">
                            <option value="">Choose Size</option>
                        </select>
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
                        <button type="submit" class="btn-cart">Add to Cart</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        const variations = @json($product->variations);
        const storageUrl = "{{ asset('storage/') }}/";

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
                                <img src="${storageUrl + img}" style="width:50px; height:50px; object-fit:cover;">
                            </div>`;
                });
            });

            if (filteredVariations.length > 0) {
                const firstVarImgs = Array.isArray(filteredVariations[0].images) ? filteredVariations[0].images : JSON.parse(filteredVariations[0].images || '[]');
                if (firstVarImgs.length > 0) updateMainImage(storageUrl + firstVarImgs[0]);
            }
        }

        function updateDetails() {
            const selectedSize = document.getElementById('sizePicker').value;
            const selectedColor = document.getElementById('selectedColor').value;
            const customForm = document.getElementById('custom-design-form');

            if (selectedSize === 'custom') {
                customForm.style.display = 'block';
                return;
            }
            customForm.style.display = 'none';

            const variation = variations.find(v => v.size === selectedSize && v.color === selectedColor);
            if (variation) {
                document.getElementById('displayPrice').innerText = '$' + parseFloat(variation.price).toFixed(2);
                document.getElementById('displayDescription').innerText = variation.description || "{{ $product->description }}";
            }
        }

        window.onload = () => {
            const firstSwatch = document.querySelector('.color-swatch');
            if (firstSwatch) firstSwatch.click();
        };
    </script>
@endsection