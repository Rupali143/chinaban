    @extends('layouts.master')
    @section('main-content')
    <div class="card">
      <div class="card-header">
       <h3 class="card-title">Categories</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
          <a class="btn btn-success pull-right" href="javascript:void(0)" id="createCategory" data-toggle="modal" data-target="#modal-default"> Add</a>
          <table id="categoryTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Category Name</th>
                  <th>Parent Category</th>
                  <th>Image</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
          </table>
      </div>
      <!-- /.card-body -->
    </div>

          <div class="modal fade" id="modal_category">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title" id="modelHeading"></h4>
                  <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form role="form" id="categoryForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="category_id" id="category_id">
                    <div class="card-body">
                      <div class="form-group">
                      <label>Parent Category</label>
                      <select class="form-control select2bs4" style="width: 100%;" name="parent_category" id="parent_category">
                        <option selected="selected" value="">Parent</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category }}</option>
                      @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                    <label>Category</label>
                        <input type="text" class="form-control" placeholder="Enter Category" id="category" name="category">
                    </div>

                    <div class="form-group">
                    <label>Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>

                    <div class="form-group">  
                    <img id="imagePath" src="" class="img-responsive" style="height:80px;width:80px;" alt="">
                    </div>
                      
                    </div>
                    <!-- /.card-body -->
                    <div class="modal-footer justify-content-between">
                      <button type="submit" class="btn btn-primary" id="saveBtn">Submit</button>
                    </div>
                  </form>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->
    @endsection
    @section('scripts')
      <script type="text/javascript" src="{{ asset('js/category.js') }}"></script>

      <script type="text/javascript">
      $(document).ready(function() {
        $.ajaxSetup({
              headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          var configPath = "{{asset(config('app.file_path'))}}";
          var table = $("#categoryTable").DataTable({
            processing: true,
            "ajax":{
              "url": "{{ route('category.listing') }}",
              "type": "GET",
           },
            columns: [
                {data: 'en_name', name: 'en_name'},
                {data: 'parent_category', name: 'parent_category'},
                {data: 'image', name: 'Image'},
                {data: 'action', name: 'Action'},
            ]
        });

          $('#createCategory').click(function () {
            $('#saveBtn').val("create-Item");
            $('#category_id').val('');
            $('#imagePath').attr('src', "");
            $('#categoryForm').trigger("reset");
            $('#modelHeading').html("Create New Category");
            $('#modal_category').modal('show');
        });

        $('#saveBtn').click(function (e) {
        e.preventDefault();
        var category = $('#category');
        var parent_category = $('#parent_category');
        var image = $('#image');

        var formData = new FormData();
        formData.append('category', category.val());
        formData.append('parent_category', parent_category.val());
        formData.append('image', image[0].files[0]); 
        $.ajax({
          url: "{{ route('categoryStore') }}",
          type: "POST",
          data: formData,
          processData: false,
          contentType: false,
          success: function (data) {
              $('#categoryForm').trigger("reset");
              $('#modal_category').modal('hide');
              Swal.fire(
                  'Created!',
                  'Your Category has been Created.',
                  'success'
                  ).then(function() {
                    window.location.reload();
                  });
               table.draw();
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Submit');
          }
        });
        });

        $('body').on('click', '.editCategory', function () {
          var category_id = $(this).data('id');
          $.get("{{ url('categoryEdit') }}" +'/' + category_id, function (data) {
            
            var imagePath = data.get_image.image_location;
            var configPath = "{{asset(config('app.file_path'))}}";
            // var abc  ="{{Config::get('constants.imagePath')}}";
            // alert(abc);
              $('#modelHeading').html("Edit Product");
              $('#saveBtn').val("edit-user");
              $('#modal_category').modal('show');
              $('#category_id').val(data.id);
              $('#category').val(data.en_name);
              $('#parent_category').val(data.parent_category);
              $('#imagePath').attr('src', configPath +'/'+ imagePath);
          
// $("#imagePath").append('<img src="{{asset(config('app.file_path'))}}.'/'.'+imagePath+'" class="img-responsive" style="height:80px;width:80px;">');
          })
        });

        $('body').on('click', '.deleteCategory', function () {
            var category_id = $(this).data("id");
            Swal.fire({
              title: 'Are you sure?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                $.ajax({
                type: "GET",
                url: "{{ url('categoryDestroy') }}"+'/'+category_id,
                success: function (data) {
                  table.draw();
                  Swal.fire(
                  'Deleted!',
                  'Your Category has been deleted.',
                  'success'
                  ).then(function() {
                    window.location.reload();
                  });              
                },
                error: function (data) {
                    console.log('Error:', data);
                }
              });
            })
            
          });
      });
  </script>
    @endsection