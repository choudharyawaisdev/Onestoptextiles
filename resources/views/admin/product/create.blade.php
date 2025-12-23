@extends('admin.layouts.app')

@section('title') Create Product @endsection

@section('body')
<div class="container-fluid">
    <div class="d-md-flex d-block align-items-center justify-content-between my-4">
        <h1 class="page-title fw-semibold fs-20 mb-0">Create Product</h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">

                    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- ================= BASIC INFO ================= --}}
                        <div class="row g-3 mb-4">

                            <div class="col-md-12">
                                <label class="form-label fw-bold">Select Product Category</label>
                                <select name="category" id="product-category" class="form-select" required>
                                    <option value="" disabled selected>Choose product category</option>
                                    <option value="blanket">Thermal Blankets</option>
                                    <option value="curtain">Blackout Curtains</option>
                                    <option value="fabric">Woven Fabric Rolls</option>
                                    <option value="fitted_sheet">Fitted Sheets</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Product Name</label>
                                <input type="text" name="name" class="form-control"
                                    placeholder="e.g. T130 Cotton Fabric" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Base Price ($)</label>
                                <input type="number" step="0.01" name="price" class="form-control"
                                    placeholder="e.g. 8.00" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Product Description</label>
                                <textarea name="description" class="form-control" rows="2"
                                    placeholder="General description of the product"></textarea>
                            </div>

                            <div class="col-md-6" id="material-group" style="display:none;">
                                <label class="form-label">Material</label>
                                <input type="text" name="material" class="form-control"
                                    placeholder="e.g. 100% Cotton / 50-50 Poly Cotton">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Main Product Image</label>
                                <input type="file" name="main_image" class="form-control" accept="image/*" required>
                            </div>

                        </div>

                        <hr>

                        {{-- ================= VARIANTS ================= --}}
                        <h5 class="mb-3">Product Variants</h5>

                        <div id="variant-wrapper" style="display:none;">
                            <div class="variant-row card mb-3 border-primary shadow-sm">
                                <div class="card-body">
                                    <div class="row g-3">

                                        <div class="col-md-2 field-size" style="display:none;">
                                            <label class="form-label">Standard Size</label>
                                            <input type="text" name="details[size][]" class="form-control" placeholder="71 x 95">
                                        </div>

                                        <div class="col-md-2 field-dim" style="display:none;">
                                            <label class="form-label">Width (Inches)</label>
                                            <input type="text" name="details[width][]" class="form-control" placeholder="e.g. 65">
                                        </div>

                                        <div class="col-md-2 field-dim" style="display:none;">
                                            <label class="form-label">Length / Height</label>
                                            <input type="text" name="details[length][]" class="form-control" placeholder="e.g. 72">
                                        </div>

                                        {{-- COLOR ALWAYS VISIBLE --}}
                                        <div class="col-md-2 field-color">
                                            <label class="form-label">Color</label>
                                            <input type="text" name="details[color][]" class="form-control" placeholder="White / Sky Blue">
                                        </div>

                                        <div class="col-md-2 field-weight" style="display:none;">
                                            <label class="form-label">Weight</label>
                                            <input type="text" name="details[weight][]" class="form-control" placeholder="1.5 KG / 450 Grams">
                                        </div>

                                        <div class="col-md-2 field-finish" style="display:none;">
                                            <label class="form-label">Finish / Elastic</label>
                                            <select name="details[finish][]" class="form-select">
                                                <option value="">Select finish</option>
                                                <option value="standard">Standard</option>
                                                <option value="anti_microbial">Anti Microbial</option>
                                                <option value="all_around">All Around Elastic</option>
                                                <option value="four_corner">4 Corner Elastic</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="form-label">Variant Price ($)</label>
                                            <input type="number" step="0.01" name="details[price][]" class="form-control" placeholder="e.g. 9.50">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Variant Images</label>
                                            <input type="file" name="details[images][]" class="form-control" accept="image/*" multiple>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label">Variant Notes</label>
                                            <textarea name="details[description][]" class="form-control" rows="2" placeholder="Extra notes for this variant"></textarea>
                                        </div>

                                        <div class="col-md-2 d-grid">
                                            <button type="button" class="btn btn-outline-danger remove-row mt-4">Remove</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="add-row" class="btn btn-outline-primary mb-3">+ Add Another Variant</button>
                        <button type="submit" class="btn btn-primary float-end px-5">Save Product</button>

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

    const fieldsMap = {
        blanket: ['field-size', 'field-weight'],
        curtain: ['field-dim'],
        fabric: ['field-dim', 'field-finish'],
        fitted_sheet: ['field-size', 'field-weight', 'field-finish']
    };

    function toggleFields() {
        const val = category.value;
        wrapper.style.display = val ? 'block' : 'none';

        // Hide all toggle fields (except color)
        document.querySelectorAll('.field-size,.field-dim,.field-weight,.field-finish')
            .forEach(el => el.style.display = 'none');

        // Show fields for selected category
        if (fieldsMap[val]) {
            fieldsMap[val].forEach(cls => {
                document.querySelectorAll(`.${cls}`).forEach(el => el.style.display = 'block');
            });
        }
    }

    category.addEventListener('change', toggleFields);

    document.getElementById('add-row').addEventListener('click', () => {
        const first = document.querySelector('.variant-row');
        const clone = first.cloneNode(true);
        clone.querySelectorAll('input,textarea,select').forEach(el => el.value = '');
        wrapper.appendChild(clone);
        toggleFields();
    });

    document.addEventListener('click', e => {
        if (e.target.classList.contains('remove-row')) {
            const rows = document.querySelectorAll('.variant-row');
            if (rows.length > 1) e.target.closest('.variant-row').remove();
        }
    });

});
</script>
@endsection
