@extends('layouts.app')

@section('content')
<div class="container">
  <h2 class="mb-4">Dashboard</h2>

  <!-- Today's Birth Anniversary Section -->
  <div class="dashboard-card">
    <h4 class="orange-label">Today's Birth Anniversary</h4>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Member's Name</th>
          <th>Date of Anniversary</th>
          <th>Phone Number</th>
          <th>Email Address</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>XYZ</td>
          <td>00-00-0000</td>
          <td>00000-00000</td>
          <td>xyz@suryagoldcement.com</td>
        </tr>
      </tbody>
    </table>
    <button class="view-more-btn">View More</button>
  </div>

  <!-- Today's Wedding Anniversary Section -->
  <div class="dashboard-card">
    <h4 class="orange-label">Today's Wedding Anniversary</h4>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Member's Name</th>
          <th>Date of Anniversary</th>
          <th>Phone Number</th>
          <th>Email Address</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>XYZ</td>
          <td>00-00-0000</td>
          <td>00000-00000</td>
          <td>xyz@suryagoldcement.com</td>
        </tr>
      </tbody>
    </table>
    <button class="view-more-btn">View More</button>
  </div>
</div>
@endsection
