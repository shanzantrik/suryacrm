@extends('layouts.app')

@section('content')
<div class="container">
  <h2>Holidays List</h2>
  <button class="btn btn-primary mb-3" id="createNewHoliday">Add Holiday</button>
  <div class="row">
    <div class="col-md-6">
      <!-- Calendar -->
      <div id="holiday-calendar"></div>
    </div>
    <div class="col-md-6">
      <!-- Holiday DataTable -->
      <table class="table table-bordered" id="holidays-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Description</th>
            <th>Religion</th>
            <th>Category</th>
            <th>Subcategory</th>
            <th>Actions</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
  <!-- Holiday Modal -->
  <div class="modal fade" id="holidayModal" tabindex="-1" role="dialog" aria-labelledby="holidayModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="holidayModalLabel"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="holidayForm">
            @csrf
            <input type="hidden" id="holiday_id">

            <div class="form-group">
              <label for="holiday_date">Holiday Date</label>
              <input type="text" class="form-control datepicker" id="holiday_date" name="holiday_date" required>
              <span class="text-danger error-text holiday_date_error"></span>
            </div>

            <div class="form-group">
              <label for="description">Description</label>
              <input type="text" class="form-control" id="description" name="description" required>
              <span class="text-danger error-text description_error"></span>
            </div>

            <div class="form-group">
              <label for="religion">Religion</label>
              <select class="form-control" id="religion" name="religion[]" multiple required>
                <option value="Hinduism">Hinduism</option>
                <option value="Christianity">Christianity</option>
                <option value="Islam">Islam</option>
                <option value="Buddhism">Buddhism</option>
                <!-- Add more religions as needed -->
              </select>
              <span class="text-danger error-text religion_error"></span>
            </div>


            <div class="form-group">
              <label for="category_id">Category</label>
              <select class="form-control" id="category_id" name="category_id" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
              </select>
              <span class="text-danger error-text category_id_error"></span>
            </div>

            <div class="form-group">
              <label for="subcategory_id">SubCategory</label>
              <select class="form-control" id="subcategory_id" name="subcategory_id" required>
                <option value="">Select SubCategory</option>
                <!-- Subcategories will be populated based on the selected category -->
              </select>
              <span class="text-danger error-text subcategory_id_error"></span>
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
    // Initialize Datepicker
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
    });

    // Initialize DataTable
    $('#holidays-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("holidays.index") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'holiday_date', name: 'holiday_date' },
            { data: 'description', name: 'description' },
            { data: 'religion', name: 'religion' },
            { data: 'category_name', name: 'category_name' },
            { data: 'subcategory_name', name: 'subcategory_name' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
            error: function(xhr, status, error) {
                // Handle DataTable error case
                console.log("DataTable loading error: ", xhr.responseText);
            }
    });

    // Open Create Modal
    $('#createNewHoliday').click(function() {
        $('#holidayForm').trigger("reset");
        $('#holiday_id').val('');
        $('#holidayModalLabel').html("Create Holiday");
        $('#saveBtn').html("Save");
        $('#holidayModal').modal('show');
    });

    // Open Edit Modal
    $('body').on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        $.get("{{ url('holidays') }}" + '/' + id + '/edit', function(data) {
            $('#holidayModalLabel').html("Edit Holiday");
            $('#saveBtn').html("Update");
            $('#holidayModal').modal('show');
            $('#holiday_id').val(data.id);
            $('#holiday_date').val(data.holiday_date);
            $('#description').val(data.description);
            $('#religion').val(data.religion);
            $('#category_id').val(data.category_id);
            $('#subcategory_id').val(data.subcategory_id);
        });
    });

    // Save or Update Holiday
    $('#holidayForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var id = $('#holiday_id').val();
        var method = id ? 'PUT' : 'POST';
        var url = id ? '{{ url("holidays") }}/' + id : '{{ route("holidays.store") }}';

        $.ajax({
            url: url,
            type: method,
            data: formData,
            success: function(response) {
                $('#holidayModal').modal('hide');
                $('#holidays-table').DataTable().ajax.reload();
                alert(response.success);
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                if (errors.holiday_date) {
                    $('.holiday_date_error').text(errors.holiday_date[0]);
                }
                if (errors.description) {
                    $('.description_error').text(errors.description[0]);
                }
                if (errors.religion) {
                    $('.religion_error').text(errors.religion[0]);
                }
                if (errors.category_id) {
                    $('.category_id_error').text(errors.category_id[0]);
                }
                if (errors.subcategory_id) {
                    $('.subcategory_id_error').text(errors.subcategory_id[0]);
                }
            }
        });
    });

    // Delete Holiday
    $('body').on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        if (confirm("Are you sure you want to delete this holiday?")) {
            $.ajax({
                url: '{{ url("holidays") }}/' + id,
                type: 'DELETE',
                data: {
                    '_token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#holidays-table').DataTable().ajax.reload();
                    alert(response.success);
                }
            });
        }
    });

    // Populate Subcategories based on selected Category
    $('#category_id').change(function() {
        var categoryId = $(this).val();
        $.get("{{ url('get-subcategories-by-category') }}/" + categoryId, function(data) {
            var subcategoryOptions = '<option value="">Select SubCategory</option>';
            $.each(data, function(index, subcategory) {
                subcategoryOptions += '<option value="' + subcategory.id + '">' + subcategory.name + '</option>';
            });
            $('#subcategory_id').html(subcategoryOptions);
        });
    });
});

</script>
<script type="text/javascript">
  $(document).ready(function() {
        // Populate Subcategories based on selected Category
        $('#category_id').change(function() {
            var categoryId = $(this).val(); // Get the selected category ID

            if (categoryId) {
                // Make an AJAX request to fetch subcategories
                $.ajax({
                    url: "{{ url('get-subcategories-by-category') }}/" + categoryId, // Correct Blade directive inside JavaScript
                    type: 'GET',
                    success: function(data) {
                        var subcategoryOptions = '<option value="">Select SubCategory</option>';

                        // Iterate through the data and append options to the dropdown
                        $.each(data, function(index, subcategory) {
                            subcategoryOptions += '<option value="' + subcategory.id + '">' + subcategory.name + '</option>';
                        });

                        // Update the subcategory dropdown with new options
                        $('#subcategory_id').html(subcategoryOptions);
                    },
                    error: function(xhr, status, error) {
                        console.log("Error occurred:");
                        console.log(xhr.responseText); // Check for any detailed error message
                        console.log("Status: " + status);
                        console.log("Error: " + error);

                        // Optional: Show a user-friendly message if needed
                        alert("An error occurred while fetching subcategories. Please try again.");
                    }
                });
            } else {
                // If no category is selected, clear the subcategory dropdown
                $('#subcategory_id').html('<option value="">Select SubCategory</option>');
            }
        });
    });
</script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.min.css" rel="stylesheet">

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.min.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
        // Initialize FullCalendar
        var calendarEl = document.getElementById('holiday-calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: "{{ url('holidays/calendar-data') }}" // Fetch holiday events
        });
        calendar.render();

    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection
