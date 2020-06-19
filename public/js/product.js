$(function(){
  $("#productForm").validate({
      rules: {
          product: "required",
          product_detail: "required",
          category_id: "required"
      },
      messages: {
        product: {
          required: "Please enter  product",
          },
        category_id: {
          required: "Please enter  category",
        },      
          product_detail: "Please enter product detail"
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

  $("#saveBtn").on("click", function(){
      if($("#productForm").valid()){
          $("#modal_product").modal("show");
      } else {
        console.log('value not entered');
      }
      return false;
  });
})
