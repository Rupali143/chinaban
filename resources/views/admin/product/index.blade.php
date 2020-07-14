@extends('layouts.master')
@section('main-content')
<div class="card">
 <div class="card-header">
  <h3 class="card-title">Products</h3>
  <a href="" class="btn btn-success btn-sm float-right" href="javascript:void(0)" id="createProduct" data-toggle="modal" data-target="#modal-default" title="Add New Product">
    <i class="fa fa-plus" aria-hidden="true"></i> Add New
  </a>
</div>
<!-- /.card-header -->
<div class="card-body">
  <table id="productTable" class="table table-bordered table-striped">
   <thead>
    <tr>
     <th>Sr.No.</th>
     <th>Product Name</th>
     <th>Category Name</th>
     <th>Product Details</th>
     <th>Action</th>
   </tr>
 </thead>
 <tbody>
 </tbody>
</table>
</div>
<!-- /.card-body -->
</div>
<div class="modal fade" id="modal_product">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <h4 class="modal-title" id="modelHeading"></h4>
    <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <form role="form" id="productForm" method="post">
     @csrf
     <input type="hidden" name="product_id" id="product_id">
     <div class="card-body">
      <div class="form-group mb-3">
       <label>Parent Category</label>
       <select class="form-control select2bs4" style="width: 100%;" name="category_id" id="category_id">
        <option  value="">Select Category</option>
        @foreach($categories as $category)
        <option value="{{ $category->id }}">{{ $category->en_name }}</option>
        @endforeach
      </select>
      <span class="text-danger error-category" role="alert">
      </span>
    </div>
    <div class="form-group mb-3">
     <label>Category</label>
     <select class="form-control select2bs4" style="width: 100%;" name="subcategory" id="subCategory">
      <option  value="">Select Subcategory</option>
      <option value=""></option>
    </select>
    <span class="text-danger error-category" role="alert">
    </span>
  </div>
  <div class="form-group mb-3">
   <label>Product</label>
   <input type="text" class="form-control" placeholder="Enter Product" id="product" name="product">
   <span class="text-danger error-product" role="alert">
   </span> 
 </div>
 <div class="form-group mb-3">
   <label>Product Detail</label>
   <input type="text" class="form-control" placeholder="Enter Product Detail" id="product_detail" name="product_detail">
   <span class="text-danger error-product-detail" role="alert">
   </span>
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
<script type="text/javascript">
  var productListing = "{{ route('product.listing') }}";
  var productStore = "{{ route('product.store') }}";
  var productEdit = "{{ url('admin/product/edit') }}";
  var productDelete = "{{ url('admin/product/destroy') }}";
  var subCat = "{{route('getSubCategory')}}";
</script>
<script type="text/javascript" src="{{ asset('js/admin/product.js') }}"></script>
@endsection
