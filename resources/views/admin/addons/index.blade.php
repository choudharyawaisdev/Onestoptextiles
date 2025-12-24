@extends('admin.layouts.app')

@section('title', 'Add-ons Index')

@section('body')
<div class="container-fluid">
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add-ons</li>
            </ol>
        </nav>
        <button class="btn btn-primary btn-sm" onclick="openAddModal()">Add Add-on</button>
    </div>

    <div class="col-xl-12">
        <div class="card custom-card overflow-hidden">
            <div class="card-header">
                <h6 class="card-title">All Add-ons</h6>
            </div>
            <div class="card-body p-2">
                <div class="table-responsive">
                    <table id="example" class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Sr</th>
                                <th>Title</th> <th>Price</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($adons as $index => $adon)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $adon->title }}</td> <td>{{ number_format($adon->price, 2) }}</td>
                                    <td>{{ $adon->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <form action="{{ route('addons.destroy', $adon->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirmDelete()">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                        <button class="btn btn-sm btn-warning" onclick="openEditModal(@json($adon))">
                                            <i class="fa fa-pen-to-square"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="adonModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="adonForm" method="POST">
            @csrf
            <div id="methodContainer"></div> <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="adonModalLabel">Add Add-on</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="title">Add-on Title</label>
                        <input type="text" class="form-control" name="title" id="adon_title" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" name="price" id="adon_price" step="0.01" min="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddModal() {
        $('#adonForm').attr('action', '{{ route("addons.store") }}');
        $('#methodContainer').html(''); // No PUT for store
        $('#adonModalLabel').text('Add Add-on');
        $('#adon_title').val('');
        $('#adon_price').val('');
        $('#adonModal').modal('show');
    }

    function openEditModal(adon) {
        // Build the update URL dynamically
        let updateUrl = '{{ route("addons.update", ":id") }}';
        updateUrl = updateUrl.replace(':id', adon.id);

        $('#adonForm').attr('action', updateUrl);
        $('#methodContainer').html('@method("PUT")'); // Add Laravel PUT method
        $('#adonModalLabel').text('Edit Add-on');
        
        // Fill the fields using the correct database keys
        $('#adon_title').val(adon.title); 
        $('#adon_price').val(adon.price);
        
        $('#adonModal').modal('show');
    }

    function confirmDelete() {
        return confirm('Are you sure you want to delete this add-on?');
    }
</script>
@endsection