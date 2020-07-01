    @extends('layouts.master')
    @section('main-content')
    <div class="card">
      <div class="card-header">
       <h3 class="card-title">Categories</h3>
       <a class="btn btn-success float-right btn-sm" href="javascript:void(0)" id="createCategory" data-toggle="modal" data-target="#modal-default" title="Add New Category">
        <i class="fa fa-plus" aria-hidden="true"></i> Add New</a>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="categoryTable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Sr.No.</th>
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
                    <option value="0">Parent</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->en_name }}</option>
                    @endforeach
                  </select>
                </div>
                @error('parent_category')
                <span class="text-danger errormsg" role="alert">
                 <p>{{ $message }}</p>
               </span>
               @enderror
               <div class="form-group">
                <label>Category</label>
                <input type="text" class="form-control" placeholder="Enter Category" id="category" name="category">
              </div>
              @error('category')
              <span class="text-danger errormsg" role="alert">
               <p>{{ $message }}</p>
             </span>
             @enderror

             <div class="form-group imageName">
              <label>Image</label>
              <input type="file" class="form-control" id="image" name="image" value="">
            </div>
            @error('image')
            <span class="text-danger errormsg" role="alert">
             <p>{{ $message }}</p>
           </span>
           @enderror

           <div class="form-group">  
            <img id="storage_image" src="" class="img-responsive" style="height:80px;width:80px;" alt="">
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
      {data: 'DT_RowIndex', name: 'DT_RowIndex'},
      {data: 'en_name', name: 'Category'},
      {data: 'parent_category', name: 'Parent Category'},
      {data: 'image', name: 'Image'},
      {data: 'action', name: 'Action'},
      ]
    });

    $('#createCategory').click(function () {
      $('#saveBtn').val("create-Item");
      $('#category_id').val('');
      $('#storage_image').attr('src', "");
      $('.imageName').append('');
      $('#categoryForm').trigger("reset");
      $('#modelHeading').html("Create New Category");
      $('#modal_category').modal('show');
    });

    $('#saveBtn').click(function (e) {
      e.preventDefault();

      $("#saveBtn").attr("disabled", true);
      
      var category = $('#category');
      var parent_category = $('#parent_category');
      var image = $('#image');
      var category_id = $('#category_id');
      var storage_image = $('#hidden_image');

      var formData = new FormData();
      formData.append('category', category.val());
      formData.append('parent_category', parent_category.val());
      formData.append('category_id', category_id.val());
      formData.append('image', image[0].files[0]); 
      formData.append('storage_image', storage_image.val()); 

      $.ajax({
        url: "{{ route('categoryStore') }}",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        cache:false,
        success: function (data) {
          $('#categoryForm').trigger("reset");
          $('#modal_category').modal('hide');
          // alert(category_id);
          if(!category_id){
            Swal.fire(
              'Created!',
              'Your Category has been Created.',
              'success'
              ).then(function() {
                $("#categoryTable").DataTable().ajax.reload();
              });
            }else{
              Swal.fire(
                'Updated!',
                'Your Category has been Updated.',
                'success'
                ).then(function() {
                  $("#categoryTable").DataTable().ajax.reload();
                }); 
              } 
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
      $.get("{{ url('category/edit') }}" +'/' + category_id, function (data) {
        // alert(data.parent);
        var imagePath = data.get_image.image_location;
        var configPath = "{{asset(config('app.file_path'))}}";
        $('#modelHeading').html("Edit Category");
        $('#saveBtn').val("edit-user");
        $('#modal_category').modal('show');
        $('#category_id').val(data.id);
        $('#category').val(data.en_name);
        $('#storage_image').attr('src', configPath +'/'+ imagePath);
        $('#storage_image').append("<input type='hidden' name='hidden_image' id='hidden_image' value='"+ imagePath+"''>");
        $('#parent_category').val(data.parent.id).trigger('change');
        $('#parent_category').append('<option value="' + data.parent.id + '">' + data.parent.en_name + '</option>').attr("selected", "selected");

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
      }).then((e) => {
        if (e.value === true) {
          $.ajax({
            url: "{{ url('category/destroy') }}"+'/'+category_id,
            type: "POST",
            success: function (data) {
              if(data){
                Swal.fire(
                  'Deleted!',
                  'Your Category has been deleted.',
                  'success'
                  ).then(function() {
                    $("#categoryTable").DataTable().ajax.reload();
                    // window.location.reload();
                  });
                }else{
                  Swal.fire({
                    title : 'Opps...',
                    text : 'Something wrong!',
                    icon : 'error',
                    timer : '1500'
                  });
                }              
              },
            });
        }else{
          Swal.fire("Your file is safe!");
        }
      });

    });
  });
</script>
@endsection