@extends('admin.layouts.app')

@section('title') Edit Product @endsection

@section('body')
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4">
            <h1 class="page-title fw-semibold fs-20 mb-0">Edit Product: {{ $product->name }}</h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <form action="{{ route('product.update', $product->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row g-3 mb-4">
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Select Product Category</label>
                                    <select name="category" id="product-category" class="form-select" required>
                                        <option value="blanket" {{ $product->category == 'blanket' ? 'selected' : '' }}>
                                            THERMAL BLANKETS</option>
                                        <option value="curtain" {{ $product->category == 'curtain' ? 'selected' : '' }}>BLACK
                                            OUT CURTAINS</option>
                                        <option value="fabric" {{ $product->category == 'fabric' ? 'selected' : '' }}>WOVEN
                                            FABRIC ROLLS</option>
                                        <option value="fitted_sheet" {{ $product->category == 'fitted_sheet' ? 'selected' : '' }}>FITTED SHEETS</option>
                                    </select>
                                </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Product Add-ons</label>
                                        <select name="addon_ids[]" class="form-select" multiple>
                                            @foreach($addons as $addon)
                                                <option value="{{ $addon->id }}" {{ $product->addons->contains($addon->id) ? 'selected' : '' }}>
                                                    {{ $addon->title }} - ${{ number_format($addon->price, 2) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Product Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $product->name }}"
                                        required>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Unit</label>
                                    <input type="text" name="unit" id="product-unit" class="form-control bg-light" readonly
                                        value="{{ $product->unit }}">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">MOQ</label>
                                    <input type="number" name="moq" id="product-moq" class="form-control"
                                        value="{{ $product->moq }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Material</label>
                                    <input type="text" name="material" id="material-input" class="form-control"
                                        value="{{ $product->material }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Update Main Image</label>
                                    <input type="file" name="main_image" class="form-control">
                                    @if($product->main_image)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $product->main_image) }}" width="80"
                                                class="img-thumbnail">
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Description / Features</label>
                                    <textarea name="description" id="product-desc" class="form-control"
                                        rows="3">{{ $product->description }}</textarea>
                                </div>
                            </div>
                            <hr class="my-4">
                            <h5 class="mb-3 text-primary fw-bold">Product Variations</h5>

                            <div id="variant-wrapper" class="p-3 border rounded bg-light">
                                @foreach($product->variations as $index => $variation)
                                    <div class="variant-row card mb-3 border-0 shadow-sm">
                                        <div class="card-body border rounded">
                                            <div class="row g-3">
                                                <div class="col-md-3">
                                                    <label class="form-label fw-semibold">Size / Dimension</label>
                                                    <input type="text" name="details[size][]" class="form-control"
                                                        value="{{ $variation->size }}">
                                                </div>

                                                <div class="col-md-2">
                                                    <label class="form-label fw-semibold">Color</label>
                                                    <input type="text" name="details[color][]" class="form-control"
                                                        value="{{ $variation->color }}">
                                                </div>

                                                <div class="col-md-2">
                                                    <label class="form-label fw-semibold">Weight</label>
                                                    <input type="text" name="details[weight][]" class="form-control"
                                                        value="{{ $variation->weight }}">
                                                </div>

                                                <div class="col-md-3 field-finish"
                                                    style="{{ $product->category == 'blanket' ? 'display:none;' : '' }}">
                                                    <label class="form-label fw-semibold">Style / Finish</label>
                                                    <select name="details[finish][]" class="form-select">
                                                        <option value="">Select Finish Option</option>
                                                        <option value="anti_microbial" {{ $variation->finish == 'anti_microbial' ? 'selected' : '' }}>Anti Microbial</option>
                                                        <option value="all_around" {{ $variation->finish == 'all_around' ? 'selected' : '' }}>All Around Elastic</option>
                                                        <option value="four_corner" {{ $variation->finish == 'four_corner' ? 'selected' : '' }}>4 Corner Elastic</option>
                                                        <option value="grommet" {{ $variation->finish == 'grommet' ? 'selected' : '' }}>Grommet Panel</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-2">
                                                    <label class="form-label fw-semibold">Price ($)</label>
                                                    <input type="number" step="0.01" name="details[price][]"
                                                        class="form-control" value="{{ $variation->price }}">
                                                </div>

                                                <div class="col-md-3">
                                                    <label class="form-label fw-semibold">Variant Image</label>
                                                    <input type="file" name="details[image][]" class="form-control">
                                                    <input type="hidden" name="existing_variant_images[]"
                                                        value="{{ $variation->image }}">
                                                    @if($variation->image)
                                                        <div class="mt-1">
                                                            <img src="{{ asset('storage/' . $variation->image) }}" width="50"
                                                                class="img-thumbnail">
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="col-md-12">
                                                    <label class="form-label fw-semibold">Variant Note</label>
                                                    <textarea name="details[notes][]" class="form-control"
                                                        rows="3">{{ $variation->description }}</textarea>
                                                </div>

                                                <div class="col-md-12 text-end">
                                                    <button type="button" class="btn btn-sm btn-danger remove-row">
                                                        <i class="bi bi-trash"></i> Remove Variant
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-4">
                                <button type="button" id="add-row" class="btn btn-outline-primary fw-bold">
                                    <i class="bi bi-plus-lg"></i> + Add Another Variant
                                </button>
                                <button type="submit" class="btn btn-success float-end px-5 fw-bold">Update Product
                                    Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const category = document.getElementById('product-category');
            const wrapper = document.getElementById('variant-wrapper');
            const unitInput = document.getElementById('product-unit');
            const moqInput = document.getElementById('product-moq');
            const materialInput = document.getElementById('material-input');
            const descInput = document.getElementById('product-desc');

            category.addEventListener('change', () => {
                const val = category.value;
                const finishes = document.querySelectorAll('.field-finish');

                if (val === 'blanket') {
                    unitInput.value = "PIECE";
                    moqInput.value = 2;
                    materialInput.value = "100% NEW COTTON";
                    descInput.value = "THERMAL BLANKETS";
                    finishes.forEach(el => el.style.display = 'none');
                } else if (val === 'curtain') {
                    unitInput.value = "PAIR";
                    moqInput.value = 1;
                    materialInput.value = "100% POLYESTER";
                    descInput.value = "REDUCES OUTSIDE NOISE, PROVIDES THERMAL INSULATION";
                    finishes.forEach(el => el.style.display = 'block');
                } else if (val === 'fabric') {
                    unitInput.value = "YARD";
                    moqInput.value = 350;
                    materialInput.value = "50/50% POLYESTER COTTON";
                    descInput.value = "PLAIN WEAVE CLOSED SELVEDGE 3.4 OSY, PILLING CONTROLLED";
                    finishes.forEach(el => el.style.display = 'block');
                } else if (val === 'fitted_sheet') {
                    unitInput.value = "PIECE";
                    moqInput.value = 24;
                    materialInput.value = "50/50% PC BLEND / SINGLE JERSEY KNITTED";
                    descInput.value = "WOVEN OR KNITTED FITTED SHEETS";
                    finishes.forEach(el => el.style.display = 'block');
                }
            });

            document.getElementById('add-row').addEventListener('click', () => {
                const rows = document.querySelectorAll('.variant-row');
                const firstRow = rows[0];
                const clone = firstRow.cloneNode(true);

                clone.querySelectorAll('input, textarea, select').forEach(el => {
                    if (el.type !== 'hidden') el.value = '';
                });

                const existingImgField = clone.querySelector('input[name="existing_variant_images[]"]');
                if (existingImgField) existingImgField.value = '';

                const imgPreview = clone.querySelector('.mt-1');
                if (imgPreview) imgPreview.remove();

                wrapper.appendChild(clone);
            });

            document.addEventListener('click', e => {
                if (e.target.closest('.remove-row')) {
                    const rows = document.querySelectorAll('.variant-row');
                    if (rows.length > 1) {
                        e.target.closest('.variant-row').remove();
                    } else {
                        alert("At least one variant is required.");
                    }
                }
            });
        });
    </script>
@endsection