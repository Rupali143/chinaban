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
                <input type="text" class="form-control" placeholder="Enter Category" id="category" name="category" value="{{ old('category') }}">
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
<script>
  var categoryListing = "{{route('category.listing')}}";
  var categoryStore = "{{ route('categoryStore') }}";
  var categoryEdit = "{{ url('admin/category/edit') }}";
  var configPath = "{{asset(config('app.file_path'))}}";
  var categoryDelete = "{{ url('admin/category/destroy') }}";
</script>
<script type="text/javascript" src="{{ asset('js/admin/category.js') }}"></script>
@endsection