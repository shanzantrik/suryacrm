@extends('layouts.app')

@section('content')
<div class="container">
  <h2>Districts List</h2>
  <button class="btn btn-primary mb-3" id="createNewDistrict">Add District</button>

  <table class="table table-bordered" id="districts-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>State</th>
        <th>Actions</th>
      </tr>
    </thead>
  </table>

  <!-- District Modal -->
  <div class="modal fade" id="districtModal" tabindex="-1" role="dialog" aria-labelledby="districtModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="districtModalLabel"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="districtForm">
            @csrf
            <input type="hidden" id="district_id">
            <div class="form-group">
              <label for="name">District Name</label>
              <input type="text" class="form-control" id="name" name="name" required>
              <span class="text-danger error-text name_error"></span>
            </div>

            <div class="form-group">
              <label for="state_id">State</label>
              <select class="form-control" id="state_id" name="state_id" required>
                <option value="">Select State</option>
                @foreach($states as $state)
                <option value="{{ $state->id }}">{{ $state->name }}</option>
                @endforeach
              </select>
              <span class="text-danger error-text state_id_error"></span>
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
    $('#districts-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("districts.index") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'state_name', name: 'state_name' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });

    // Open Create Modal
    $('#createNewDistrict').click(function() {
        $('#districtForm').trigger("reset");
        $('#district_id').val('');
        $('#districtModalLabel').html("Create District");
        $('#saveBtn').html("Save");
        $('#districtModal').modal('show');
    });

    // Open Edit Modal
    $('body').on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        $.get("{{ url('districts') }}" + '/' + id + '/edit', function(data) {
            $('#districtModalLabel').html("Edit District");
            $('#saveBtn').html("Update");
            $('#districtModal').modal('show');
            $('#district_id').val(data.id);
            $('#name').val(data.name);
            $('#state_id').val(data.state_id);
        })
    });

    // Save/Update District
    $('#districtForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var id = $('#district_id').val();
        var method = id ? 'PUT' : 'POST';
        var url = id ? '{{ url("districts") }}/' + id : '{{ route("districts.store") }}';

        $.ajax({
            url: url,
            type: method,
            data: formData,
            success: function(response) {
                $('#districtModal').modal('hide');
                $('#districts-table').DataTable().ajax.reload();
                alert(response.success);
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                if (errors.name) {
                    $('.name_error').text(errors.name[0]);
                }
                if (errors.state_id) {
                    $('.state_id_error').text(errors.state_id[0]);
                }
            }
        });
    });

    // Delete District
    $('body').on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        if (confirm("Are you sure you want to delete this district?")) {
            $.ajax({
                url: '{{ url("districts") }}/' + id,
                type: 'DELETE',
                data: {
                    '_token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#districts-table').DataTable().ajax.reload();
                    alert(response.success);
                }
            });
        }
    });
});
</script>
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection
