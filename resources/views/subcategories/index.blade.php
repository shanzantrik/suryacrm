@extends('layouts.app')

@section('content')
<div class="container">
  <h2>SubCategories List</h2>

  <!-- Success message -->
  @if (session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <button type="button" class="btn btn-primary mb-3" id="createNewSubCategory">Add SubCategory</button>

  <!-- SubCategories Table -->
  <table class="table table-bordered" id="subcategories-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Category</th>
        <th>Actions</th>
      </tr>
    </thead>
  </table>

  <!-- Create/Edit Modal -->
  <div class="modal fade" id="subCategoryModal" tabindex="-1" role="dialog" aria-labelledby="subCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="subCategoryModalLabel"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="subCategoryForm">
            @csrf
            <input type="hidden" id="subCategory_id">
            <input type="hidden" name="_method" value="PUT"> <!-- Ensure PUT method is sent during update -->

            <div class="form-group">
              <label for="name">SubCategory Name</label>
              <input type="text" class="form-control" id="name" name="name" required>
              <span class="text-danger error-text name_error"></span>
            </div>

            <div class="form-group">
              <label for="category_id">Category</label>
              <select class="form-control" id="category_id" name="category_id" required>
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
              </select>
              <span class="text-danger error-text category_id_error"></span>
            </div>

            <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    // Set CSRF token for all AJAX requests
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Initialize DataTables
    $('#subcategories-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("subcategories.index") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'category_name', name: 'category_name' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });

    // Open modal for creating a new subcategory
    $('#createNewSubCategory').click(function() {
        $('#subCategoryForm').trigger("reset");
        $('#subCategory_id').val('');
        $('#_method').val('POST'); // Set the method to POST for new entries
        $('#subCategoryModalLabel').html("Create SubCategory");
        $('#saveBtn').html("Save");
        $('#subCategoryModal').modal('show');
    });

    // Open modal for editing a subcategory
    $('body').on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        $.get("{{ url('subcategories') }}" + '/' + id + '/edit', function(data) {
            $('#subCategoryModalLabel').html("Edit SubCategory");
            $('#saveBtn').html("Update");
            $('#subCategoryModal').modal('show');
            $('#subCategory_id').val(data.id);
            $('#name').val(data.name);
            $('#category_id').val(data.category_id);  // Set category in dropdown
            $('#_method').val('PUT'); // Set the method to PUT for updates
        });
    });

    // Save or update subcategory
    $('#subCategoryForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var id = $('#subCategory_id').val();
        var method = id ? 'PUT' : 'POST'; // Check if it's a new or existing record
        var url = id ? '{{ url("subcategories") }}/' + id : '{{ route("subcategories.store") }}';

        $.ajax({
            url: url,
            type: method,
            data: formData,
            success: function(response) {
                $('#subCategoryModal').modal('hide');
                $('#subcategories-table').DataTable().ajax.reload();
                alert(response.success);
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                if (errors.name) {
                    $('.name_error').text(errors.name[0]);
                }
                if (errors.category_id) {
                    $('.category_id_error').text(errors.category_id[0]);
                }
            }
        });
    });
});
</script>
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection
