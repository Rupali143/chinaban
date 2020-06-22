@extends('layouts.master')
    @section('main-content')
<div class="card">
   <div class="card-header">
      <h3 class="card-title">Products</h3>
   </div>
   <!-- /.card-header -->
   <div class="card-body">
      <a href="" class="btn btn-success   btn-sm" href="javascript:void(0)" id="createProduct" data-toggle="modal" data-target="#modal-default" title="Add New Product">
      <i class="fa fa-plus" aria-hidden="true"></i> Add New
      </a>
      <table id="productTable" class="table table-bordered table-striped">
         <thead>
            <tr>
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
  <script type="text/javascript" src="{{ asset('js/product.js') }}"></script>

  <script type="text/javascript">
    $(document).ready(function() {
          
      $.ajaxSetup({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
        var table = $("#productTable").DataTable({
          processing: true,
          //serverSide: true,
          "ajax":{
          "url": "{{ route('product.listing') }}",
          "type": "GET",
        },
        columns: [
            {data: 'en_name', name: 'product'},
            {data: 'category_name', name: 'category_name'},
            {data: 'product_detail', name: 'product_deatil'},
            {data: 'action', name: 'Action'},
          ]
      });

      $('#createProduct').click(function () {
        $('#saveBtn').val("create-Item");
        $('#select2-category_id-container').text('');
        $('#select2-subCategory-container').text('');
        $('#product_id').val('');
        $("input,select").removeClass("is-invalid");
        $('#product_detail-error').empty();
        $('#product-error').empty();
        $('#subCategory-error').empty();
        $('#category_id-error').empty();
        $('#productForm').trigger("reset");
        $('#modelHeading').html("Create New Product");
        $('#modal_product').modal('show');
      });

      $('#saveBtn').click(function (e) {
        var product_id =$('#product_id').val();
        e.preventDefault();
        if($("#productForm").valid()){
          $.ajax({
              data: $('#productForm').serialize(),
              url: "{{ route('product.store') }}",
              type: "POST",
              dataType: 'json',
              success: function (data) {
                $('#productForm').trigger("reset");
                $('#modal_product').modal('hide');
                  if(!product_id){
                    Swal.fire(
                      'Created!',
                      'Your Product has been Created.',
                      'success'
                      ).then(function() {
                        window.location.reload();
                      });
                  }else{
                    Swal.fire(
                      'Updated!',
                      'Your Product has been Updated.',
                      'success'
                    ).then(function() {
                        window.location.reload();
                    }); 
                  }   
                  table.draw();
                },
              error:function(result){
                if(typeof result.responseJSON.errors.category_id != "undefined"){
                  let category_id = (result.responseJSON.errors.category_id[0]);
                  $('.error-category').html(category_id);
                }else{
                  $('.error-category').empty();
                }
                if(typeof result.responseJSON.errors.product != "undefined"){
                  let product = (result.responseJSON.errors.product[0]);
                  $('.error-product').html(product);
                }else{
                  $('.error-product').empty();
                }
                if(typeof result.responseJSON.errors.product_detail != "undefined"){
                  let product_detail = (result.responseJSON.errors.product_detail[0]);
                  $('.error-product-detail').html(product_detail);
                }else{
                  $('.error-product-detail').empty();
                }
              }
          });
        }
          
      });

      $('body').on('click', '.editProduct', function () {
          var product_id = $(this).data('id');
          $('.error-category').empty();
          $('.error-product').empty();
          $('.error-product-detail').empty();
          $("input,select").removeClass("is-invalid");
          $('#product_detail-error').empty();
          $('#product-error').empty();
          $('#subCategory-error').empty();
          $('#category_id-error').empty();
          $.get("{{ url('product/edit') }}" +'/' + product_id, function (data) {
            $('#modelHeading').html("Edit Product");
            $('#saveBtn').val("edit-user");
            $('#modal_product').modal('show');
            $('#product_id').val(data.id);
            $('#product').val(data.en_name);
            
            $('#product_detail').val(data.product_detail);
            $('#category_id').attr('data-subcategory',data.category.id);
            $('#category_id').val(data.category.parent_category).trigger('change');
            $('#subCategory').append('<option value="' + data.category_id + '">' + data.en_name + '</option>').attr("selected", "selected");
          })
      });

      $('body').on('click', '.deleteProduct', function () {
          var product_id = $(this).data("id");
            
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
              url: "{{ url('product/destroy') }}"+'/'+product_id,
              success: function (data) {
              table.draw();
              Swal.fire(
              'Deleted!',
              'Your Product has been deleted.',
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

      $('#category_id').on('change',function(e){
        var categoryId = e.target.value;
        var subCategory =$(this).attr('data-subcategory');
      
        $.ajax({
          data: {'category_id':categoryId},
          type: 'get',
          url: "{{route('getSubCategory')}}",
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function (response) {   
            $('#subCategory').empty();
            $('#subCategory').append(' Please choose one');
            $.each(response, function(index, subcatObj){
              if(subCategory && subCategory == subcatObj.id){
                $('#subCategory').append('<option value="' + subcatObj.id + '" selected = "selected">' + subcatObj.en_name + '</option>'); 
              }
              else{
                $('#subCategory').append('<option value="' + subcatObj.id + '">' + subcatObj.en_name + '</option>');
              }
            });
          }
        });
      });
    });
</script>
@endsection
