$(document).ready(function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    var table = $("#productTable").DataTable({
      processing: true,
          "ajax":{
            "url": productListing,
            "type": "GET",
          },
          columns: [
          {data: 'DT_RowIndex', name: 'DT_RowIndex'},
          {data: 'en_name', name: 'en_name'},
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
          url: productStore,
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
          // alert(product_id);
          $('.error-category').empty();
          $('.error-product').empty();
          $('.error-product-detail').empty();
          $("input,select").removeClass("is-invalid");
          $('#product_detail-error').empty();
          $('#product-error').empty();
          $('#subCategory-error').empty();
          $('#category_id-error').empty();
          $.get(productEdit +'/' + product_id, function (data) {
            $('#modelHeading').html("Edit Product");
            $('#saveBtn').val("edit-user");
            $('#modal_product').modal('show');
            $('#product_id').val(data.id);
            $('#product').val(data.en_name);
            
            $('#product_detail').val(data.product_detail);
            $('#category_id').attr('data-subcategory',data.category.id);
            $('#category_id').val(data.category.parent_category).trigger('change');
            $('#subCategory').append('<option value="' + data.category.id + '">' + data.category.en_name + '</option>').attr("selected", "selected");
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
      }).then((e) => {
        if(e.value === true){
          $.ajax({
            type: "GET",
            url: productDelete +'/'+product_id,
            success: function (data) {
              // table.draw();
              if(data){
                Swal.fire(
                  'Deleted!',
                  'Your Product has been deleted.',
                  'success'
                  ).then(function() {
                    window.location.reload();
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
          Swal.fire("Your product is Safe!!");
        }
      }) 
    });

    $('#category_id').on('change',function(e){
      var categoryId = e.target.value;
      var subCategory =$(this).attr('data-subcategory');
      
      $.ajax({
        data: {'category_id':categoryId},
        type: 'get',
        url: subCat,
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


$(function(){
  $("#productForm").validate({
    rules: {
      product: "required",
      product_detail: "required",
      category_id: "required",
      subcategory:"required"
    },
    messages: {
      product: {
        required: "Please enter  product",
      },
      category_id: {
        required: "Please enter  Parent category",
      },      
      product_detail: "Please enter product detail",
      subcategory: "Please enter Category"
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.mb-3').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }     
  })

})
