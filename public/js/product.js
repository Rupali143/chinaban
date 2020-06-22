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
