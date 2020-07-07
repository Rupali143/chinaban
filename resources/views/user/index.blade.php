    @extends('layouts.master')
    @section('main-content')
    <div class="card">
      <div class="card-header">
       <h3 class="card-title">Users</h3>
     </div>
     <div class="card-body">
      <table id="userTable" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Sr.No.</th>
            <th>Name</th>
            <th>Mobile Number</th>
            <th>Is Manufacture?</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
  @endsection
  @section('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      var table = $("#userTable").DataTable({
        "ajax":{
          "url": "{{ route('user.listing') }}",
          "type": "GET",
        },
        columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
        {data: 'name', name: 'Name'},
        {data: 'mobile_number', name: 'Mobile Number'},
        {data: 'is_manufacture', name:'Is manufacture'},
        {data: 'action', name: 'Action'},
        ]
      });
    });
  </script>
  @endsection