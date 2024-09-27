@extends('layouts.app')

@section('content')
<div class="container">
  <h2>Category List</h2>

  <!-- Success Message -->
  @if (session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
  @endif

  <button type="button" class="btn btn-primary mb-3" id="createNewCategory">Add Category</button>

  <!-- Categories Table -->
  <table class="table table-bordered" id="categories-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Created At</th>
        <th>Updated At</th>
        <th>Actions</th>
      </tr>
    </thead>
  </table>
  <!-- Create/Edit Modal -->
  <div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="categoryModalLabel"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="categoryForm">
            @csrf
            <input type="hidden" id="category_id">
            <div class="form-group">
              <label for="name">Category Name</label>
              <input type="text" class="form-control" id="name" name="name" required>
              <span class="text-danger error-text name_error"></span>
            </div>
            <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>


{{-- @push('scripts') --}}
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Initialize DataTables -->
<script type="text/javascript">
  $(document).ready(function() {
    $('#categories-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("categories.index") }}',  // URL to hit
            type: 'GET'  // Ensure this is GET, but POST works too
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });
  });

    // Open modal for creating a new category
    $('#createNewCategory').click(function() {
        $('#categoryForm').trigger("reset");
        $('#category_id').val('');
        $('#categoryModalLabel').html("Create Category");
        $('#saveBtn').html("Save");
        $('#categoryModal').modal('show');
    });

    // Open modal for editing a category
    $('body').on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        $.get("{{ url('categories') }}" + '/' + id + '/edit', function(data) {
        // Populate the modal fields with fetched data
        $('#categoryModalLabel').html("Edit Category");
        $('#saveBtn').html("Update");
        $('#categoryModal').modal('show');
        $('#category_id').val(data.id);  // Set hidden category ID
        $('#name').val(data.name);
        })
    });

    // Save or update category
    $('#categoryForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var id = $('#category_id').val();
        var method = id ? 'PUT' : 'POST';
        var url = id ? '{{ url("categories") }}/' + id : '{{ route("categories.store") }}';

        $.ajax({
            url: url,
            type: method,
            data: formData,
            success: function(response) {
                $('#categoryModal').modal('hide');
                $('#categories-table').DataTable().ajax.reload();
                alert(response.success);
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                if (errors.name) {
                    $('.name_error').text(errors.name[0]);
                }
            }
        });
    });
</script>


{{-- @push('styles') --}}

<!-- Include DataTables CSS -->
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection
