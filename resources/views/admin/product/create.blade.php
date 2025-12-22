@extends('admin.layouts.app')

@section('title') Create Menu Item @endsection

@section('body')
<div class="container-fluid">
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-20 mb-0">Create Menu Item</h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Product Category --}}
                        <div class="row mb-4">
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Select Product Category</label>
                                <select name="category" id="product-category" class="form-select" required>
                                    <option value="" selected disabled>Choose Category...</option>
                                    <option value="blanket">Thermal Blankets</option>
                                    <option value="curtain">Blackout Curtains</option>
                                    <option value="fabric">Woven Fabric Rolls</option>
                                    <option value="fitted_sheet">Fitted Sheets</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Product Name</label>
                                <input type="text" name="name" class="form-control" placeholder="e.g. T130 Woven Fabric" required>
                            </div>

                            <div class="col-md-6" id="material-group" style="display:none;">
                                <label class="form-label">Material</label>
                                <input type="text" name="material" class="form-control" placeholder="e.g. 100% New Cotton">
                            </div>
                        </div>

                        {{-- Main Image --}}
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Main Product Image <span class="text-danger">*</span></label>
                                <input type="file" name="main_image" class="form-control" accept="image/*" required>
                            </div>
                        </div>

                        <hr>

                        {{-- Product Variants --}}
                        <h5 class="mb-3">Product Variants</h5>
                        <div id="variant-wrapper">
                            <div class="card variant-row mb-3 shadow-sm border-primary">
                                <div class="card-body">
                                    <div class="row g-3">

                                        <div class="col-md-2" id="size-field" style="display:none;">
                                            <label class="form-label">Standard Size</label>
                                            <input type="text" name="details[size][]" class="form-control" placeholder="71x95">
                                        </div>

                                        <div class="col-md-2 custom-dim" style="display:none;">
                                            <label class="form-label">Width (Inches)</label>
                                            <input type="text" name="details[width][]" class="form-control">
                                        </div>

                                        <div class="col-md-2 custom-dim" style="display:none;">
                                            <label class="form-label">Length/Height</label>
                                            <input type="text" name="details[length][]" class="form-control">
                                        </div>

                                        <div class="col-md-2" id="color-field" style="display:none;">
                                            <label class="form-label">Color</label>
                                            <input type="text" name="details[color][]" class="form-control" placeholder="Sky Blue">
                                        </div>

                                        <div class="col-md-2">
                                            <label class="form-label">Price ($)</label>
                                            <input type="number" step="0.01" name="details[price][]" class="form-control" required>
                                        </div>

                                        <div class="col-md-2" id="weight-field" style="display:none;">
                                            <label class="form-label">Weight (KG/Grams)</label>
                                            <input type="text" name="details[weight][]" class="form-control">
                                        </div>

                                        <div class="col-md-2" id="finish-field" style="display:none;">
                                            <label class="form-label">Finish/Elastic</label>
                                            <select name="details[finish][]" class="form-select">
                                                <option value="none">Standard</option>
                                                <option value="anti_microbial">Anti-Microbial</option>
                                                <option value="all_around">All Around Elastic</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Variant Images</label>
                                            <input type="file" name="details[images][]" class="form-control" accept="image/*" multiple>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label">Variant Description / Notes</label>
                                            <textarea name="details[description][]" class="form-control" rows="2"></textarea>
                                        </div>

                                        <div class="col-md-2 d-grid">
                                            <button type="button" class="btn btn-outline-danger remove-row mt-4">Remove</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-outline-primary mb-3" id="add-row">+ Add Another Variant</button>
                        <button type="submit" class="btn btn-primary float-end px-5">Save Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const categorySelect = document.getElementById('product-category');

    const materialGroup = document.getElementById('material-group');
    const weightField = document.getElementById('weight-field');
    const finishField = document.getElementById('finish-field');
    const sizeField = document.getElementById('size-field');
    const customDims = document.querySelectorAll('.custom-dim');
    const colorField = document.getElementById('color-field');
    const variantWrapper = document.getElementById('variant-wrapper');

    function toggleFields() {
        const val = categorySelect.value;

        // Hide all fields by default
        materialGroup.style.display = 'none';
        weightField.style.display = 'none';
        finishField.style.display = 'none';
        sizeField.style.display = 'none';
        customDims.forEach(d => d.style.display = 'none');
        colorField.style.display = 'none';

        // Hide entire variant section if no category selected
        if (!val) {
            variantWrapper.style.display = 'none';
            return;
        } else {
            variantWrapper.style.display = 'block';
        }

        // Show material for all categories
        materialGroup.style.display = 'block';

        // Color should always show and be required
        colorField.style.display = 'block';
        colorField.querySelector('input').required = true;

        if (val === 'blanket') {
            sizeField.style.display = 'block';
            weightField.style.display = 'block';
        }
        else if (val === 'curtain') {
            customDims.forEach(d => d.style.display = 'block'); // width & length
        }
        else if (val === 'fabric') {
            finishField.style.display = 'block';
        }
        else if (val === 'fitted_sheet') {
            weightField.style.display = 'block';
            finishField.style.display = 'block';
        }
    }

    categorySelect.addEventListener('change', toggleFields);

    // Clone variant row
    document.getElementById('add-row').addEventListener('click', function () {
        let wrapper = document.getElementById('variant-wrapper');
        let row = wrapper.querySelector('.variant-row').cloneNode(true);
        row.querySelectorAll('input, textarea').forEach(input => input.value = '');
        wrapper.appendChild(row);
        toggleFields(); // apply category visibility to new row
    });

    // Remove row
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row')) {
            let rows = document.querySelectorAll('.variant-row');
            if (rows.length > 1) e.target.closest('.variant-row').remove();
        }
    });

    // Initialize visibility
    toggleFields();
});
</script>

@endsection
