@extends('admin.layouts.app')

@section('title') Create Product @endsection

@section('body')
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4">
            <h1 class="page-title fw-semibold fs-20 mb-0">Create Product</h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-3 mb-4">
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Select Product Category</label>
                                    <select name="category" id="product-category" class="form-select" required>
                                        <option value="" disabled selected>Choose product category...</option>
                                        <option value="blanket">THERMAL BLANKETS</option>
                                        <option value="curtain">BLACK OUT CURTAINS</option>
                                        <option value="fabric">WOVEN FABRIC ROLLS</option>
                                        <option value="fitted_sheet">FITTED SHEETS</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Select Addon</label>
                                    <select name="addon_id" id="addon" class="form-select">
                                        <option value="">-- Choose an Addon --</option>
                                        @foreach ($addons as $addon)
                                            <option value="{{ $addon->id }}">
                                                {{ $addon->title }} - ${{ number_format($addon->price, 2) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Product Name</label>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="e.g. Premium Cotton Blanket" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Unit</label>
                                    <input type="text" name="unit" id="product-unit" class="form-control bg-light" readonly
                                        placeholder="Auto-set (Piece/Pair/Yard)">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">MOQ</label>
                                    <input type="number" name="moq" id="product-moq" class="form-control"
                                        placeholder="Minimum Order Quantity">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Material</label>
                                    <input type="text" name="material" id="material-input" class="form-control"
                                        placeholder="e.g. 100% Cotton / Polyester">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Price</label>
                                    <input type="text" name="price" class="form-control" placeholder="Price">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Main Product Image</label>
                                    <input type="file" name="main_image" class="form-control" required>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Description / Features</label>
                                    <textarea name="description" id="product-desc" class="form-control" rows="2"
                                        placeholder="Describe the main features of the product..."></textarea>
                                </div>
                            </div>

                            <hr class="my-4">
                            <h5 class="mb-3 text-primary fw-bold">Product Variations</h5>

                            <div id="variant-wrapper" style="display:none;" class="p-3 border rounded bg-light">
                                <div class="variant-row card mb-3 border-0 shadow-sm">
                                    <div class="card-body border rounded">
                                        <div class="row g-3">

                                            <div class="col-md-3">
                                                <label class="form-label fw-semibold">Size / Dimension</label>
                                                <input type="text" name="details[size][]" class="form-control"
                                                    placeholder="e.g. 71x95, 90x100, or 65 inches">
                                            </div>

                                            <div class="col-md-2">
                                                <label class="form-label fw-semibold">Color</label>
                                                <input type="text" name="details[color][]" class="form-control"
                                                    placeholder="e.g. White, Blue, Grey">
                                            </div>

                                            <div class="col-md-2 field-weight">
                                                <label class="form-label fw-semibold">Weight</label>
                                                <input type="text" name="details[weight][]" class="form-control"
                                                    placeholder="e.g. 1.5 KG or 300 GSM">
                                            </div>

                                            <div class="col-md-3 field-finish" style="display:none;">
                                                <label class="form-label fw-semibold">Style / Finish</label>
                                                <select name="details[finish][]" class="form-select">
                                                    <option value="">Select Finish Option</option>
                                                    <option value="anti_microbial">Anti Microbial</option>
                                                    <option value="all_around">All Around Elastic</option>
                                                    <option value="four_corner">4 Corner Elastic</option>
                                                    <option value="grommet">Grommet Panel</option>
                                                </select>
                                            </div>

                                            <div class="col-md-2">
                                                <label class="form-label fw-semibold">Price ($)</label>
                                                <input type="number" step="0.01" name="details[price][]"
                                                    class="form-control" placeholder="0.00">
                                            </div>

                                            <div class="col-md-12">
                                                <label class="form-label fw-semibold">Variant Note</label>
                                                <textarea name="details[notes][]" class="form-control" rows="1"
                                                    placeholder="Add specific notes for this variation (Packing, Warehouse info etc.)"></textarea>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="form-label fw-semibold">Variant Image</label>
                                                <input type="file" name="details[image][]" class="form-control">
                                            </div>


                                            <div class="col-md-12 text-end">
                                                <button type="button" class="btn btn-sm btn-danger remove-row">
                                                    <i class="bi bi-trash"></i> Remove Variant
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="button" id="add-row" class="btn btn-outline-primary fw-bold">
                                    <i class="bi bi-plus-lg"></i> + Add Another Variant
                                </button>
                                <button type="submit" class="btn btn-primary float-end px-5 fw-bold">Save All Product
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
                wrapper.style.display = 'block';
                const val = category.value;

                // Default: Hide special fields
                document.querySelectorAll('.field-finish').forEach(el => el.style.display = 'none');

                if (val === 'blanket') {
                    unitInput.value = "PIECE";
                    moqInput.value = 2;
                    materialInput.value = "100% NEW COTTON";
                    descInput.value = "THERMAL BLANKETS";
                } else if (val === 'curtain') {
                    unitInput.value = "PAIR";
                    moqInput.value = 1;
                    materialInput.value = "100% POLYESTER";
                    descInput.value = "REDUCES OUTSIDE NOISE, PROVIDES THERMAL INSULATION";
                    document.querySelectorAll('.field-finish').forEach(el => el.style.display = 'block');
                } else if (val === 'fabric') {
                    unitInput.value = "YARD";
                    moqInput.value = 350;
                    materialInput.value = "50/50% POLYESTER COTTON";
                    descInput.value = "PLAIN WEAVE CLOSED SELVEDGE 3.4 OSY, PILLING CONTROLLED";
                    document.querySelectorAll('.field-finish').forEach(el => el.style.display = 'block');
                } else if (val === 'fitted_sheet') {
                    unitInput.value = "PIECE";
                    moqInput.value = 24;
                    materialInput.value = "50/50% PC BLEND / SINGLE JERSEY KNITTED";
                    descInput.value = "WOVEN OR KNITTED FITTED SHEETS";
                    document.querySelectorAll('.field-finish').forEach(el => el.style.display = 'block');
                }
            });

            document.getElementById('add-row').addEventListener('click', () => {
                const firstRow = document.querySelector('.variant-row');
                const clone = firstRow.cloneNode(true);
                // Clear inputs in the clone
                clone.querySelectorAll('input, textarea, select').forEach(el => {
                    if (el.type !== 'file') {
                        el.value = '';
                    }
                });
                wrapper.appendChild(clone);
            });

            document.addEventListener('click', e => {
                if (e.target.classList.contains('remove-row')) {
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