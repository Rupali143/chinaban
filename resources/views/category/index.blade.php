@extends('layouts.master')
@section('main-content')
<div class="card">
              <div class="card-header">
                <h3 class="card-title">Categories</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped data-table">
                  <thead>
                  <tr>
                    <th>Category Name</th>
                    <th>Parent Category</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <!-- <tbody>
                  <tr>
                    <td>Trident</td>
                    <td>Internet
                      Explorer 4.0
                    </td>
                    <td>
                      <a class="btn"><i class="fas fa-edit"></i>Edit</a>
                      <a class="btn"><i class="fas fa-trash"></i>Delete</a>
                      <button type="button" class="btn btn-block btn-success">Success</button>
                    </td>
                  </tr>
                  </tbody>
 -->                </table>
              </div>
              <!-- /.card-body -->
</div>
@endsection
@section('scripts')
<script>
  $(function () {
    // $.ajaxSetup({
    //       headers: {
    //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //   },
    //   });
    //   var table = $("#example1").DataTable({
    //     processing: true,
    //     serverSide: true,
    //     ajax: "{{ route('category') }}",
    //     columns: [
    //         {data: 'DT_RowIndex', name: 'DT_RowIndex'},
    //         {data: 'en_name', name: 'en_name'},
    //         {data: 'parent_category', name: 'parent_category'},
    //         {data: 'action', name: 'action', orderable: false, searchable: false},

    //     ]

    // });


    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": true,
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "ajax": "{{ route('category') }}",
      
      "ajax":{
          "url": "{{ route('category') }}",
          "dataType": "json",
          "type": "POST",
          "data":{ _token: "{{csrf_token()}}"}
       },

      "columns":[
          { "data": "en_name" },
          { "data": "parent_category" }
       ]
    });
  });
</script>
@endsection