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
                                    <label class="form-label fw-bold">Update Image (Leave blank to keep current)</label>
                                    <input type="file" name="main_image" class="form-control">
                                    @if($product->main_image)
                                        <small class="text-muted">Current:
                                            {{ is_array($product->main_image) ? $product->main_image[0] : $product->main_image }}</small>
                                    @endif
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Description / Features</label>
                                    <textarea name="description" id="product-desc" class="form-control"
                                        rows="2">{{ $product->description }}</textarea>
                                </div>
                            </div>

                            <hr class="my-4">
                            <h5 class="mb-3 text-primary fw-bold">Product Variations</h5>

                            <div id="variant-wrapper" class="p-3 border rounded bg-light">
                                @foreach($product->variations as $variation)
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

                                                <div class="col-md-2 field-weight">
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
                                                    <input type="file" name="variant_images[]" class="form-control">

                                                    @if(isset($variation->image))
                                                        <div class="mt-1">
                                                            <img src="{{ asset('storage/' . $variation->image) }}" width="50"
                                                                class="img-thumbnail">
                                                            <input type="hidden" name="existing_variant_images[]"
                                                                value="{{ $variation->image }}">
                                                        </div>
                                                    @else
                                                        <input type="hidden" name="existing_variant_images[]" value="">
                                                    @endif
                                                </div>

                                                <div class="col-md-12">
                                                    <label class="form-label fw-semibold">Variant Note</label>
                                                    <textarea name="details[notes][]" class="form-control"
                                                        rows="1">{{ $variation->notes }}</textarea>
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
        // JS logic wahi rahega jo Create page par tha, bas 'remove-row' wala check behtar hai
        document.addEventListener('DOMContentLoaded', () => {
            const category = document.getElementById('product-category');
            const wrapper = document.getElementById('variant-wrapper');
            const unitInput = document.getElementById('product-unit');
            const moqInput = document.getElementById('product-moq');

            category.addEventListener('change', () => {
                const val = category.value;
                const finishes = document.querySelectorAll('.field-finish');
                finishes.forEach(el => el.style.display = (val === 'blanket' ? 'none' : 'block'));

                // Auto values for edit if needed (optional)
                if (val === 'blanket') { unitInput.value = "PIECE"; moqInput.value = 2; }
                else if (val === 'curtain') { unitInput.value = "PAIR"; moqInput.value = 1; }
                // ... baki logic as it is
            });

            document.getElementById('add-row').addEventListener('click', () => {
                const firstRow = document.querySelector('.variant-row');
                const clone = firstRow.cloneNode(true);

                // Clear all inputs including file inputs
                clone.querySelectorAll('input, textarea, select').forEach(el => {
                    el.value = '';
                });

                // Remove the image preview if it exists in the clone
                const preview = clone.querySelector('.img-thumbnail');
                if (preview) preview.remove();

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