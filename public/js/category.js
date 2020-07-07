   $('#image').on('change', function(e) {
    let size = this.files[0].size;
    if (size > 1000000) {
      alert('size is greater than 2mb');
    }
    event.preventDefault(); 
  });


   jQuery.validator.addMethod("category1", function(value, element) {
    if (/^[a-zA-Z-O'.\s]{1,40}$/.test(value)) {
      return true;
    } else {
      return false;
    };
  }, 'Please provide a valid category name.');

   $(function(){

    $("#categoryForm").validate({
      rules: {
        category: {
          required:true,
          category1: true,
          remote:{
            url:"/checkCategory",
            type:"post",
          }
        },
        image: "required"

      },
      messages: {
        category:{
          required: "Please provide a category",
          remote: "This category already exits."
        },

        image: {
          required: "Please provide a Image",
        },
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
        error.fadeOut(4000);
      },

      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        // $(element).css('border-color', '#2b88e8');
      },
    })

    // $("#saveBtn").on("click", function(){
    //   if($("#categoryForm").valid()){
    //     $("#modal_category").modal("show");
    //   } else {}
    //   return false;
    // });
  })