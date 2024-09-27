@extends('layouts.app')

@section('content')
<div class="container">
  <h2>States List</h2>
  <button class="btn btn-primary mb-3" id="createNewState">Add State</button>

  <table class="table table-bordered" id="states-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Actions</th>
      </tr>
    </thead>
  </table>

  <!-- State Modal -->
  <div class="modal fade" id="stateModal" tabindex="-1" role="dialog" aria-labelledby="stateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="stateModalLabel"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="stateForm">
            @csrf
            <input type="hidden" id="state_id">
            <div class="form-group">
              <label for="name">State Name</label>
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
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    // Initialize DataTable
    $('#states-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("states.index") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });

    // Open Create Modal
    $('#createNewState').click(function() {
        $('#stateForm').trigger("reset");
        $('#state_id').val('');
        $('#stateModalLabel').html("Create State");
        $('#saveBtn').html("Save");
        $('#stateModal').modal('show');
    });

    // Open Edit Modal
    $('body').on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        $.get("{{ url('states') }}" + '/' + id + '/edit', function(data) {
            $('#stateModalLabel').html("Edit State");
            $('#saveBtn').html("Update");
            $('#stateModal').modal('show');
            $('#state_id').val(data.id);
            $('#name').val(data.name);
        })
    });

    // Save/Update State
    $('#stateForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var id = $('#state_id').val();
        var method = id ? 'PUT' : 'POST';
        var url = id ? '{{ url("states") }}/' + id : '{{ route("states.store") }}';

        $.ajax({
            url: url,
            type: method,
            data: formData,
            success: function(response) {
                $('#stateModal').modal('hide');
                $('#states-table').DataTable().ajax.reload();
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

    // Delete State
    $('body').on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        if (confirm("Are you sure you want to delete this state?")) {
            $.ajax({
                url: '{{ url("states") }}/' + id,
                type: 'DELETE',
                data: {
                    '_token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#states-table').DataTable().ajax.reload();
                    alert(response.success);
                }
            });
        }
    });
});
</script>
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection
