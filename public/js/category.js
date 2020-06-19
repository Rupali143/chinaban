   $('#image').on('change', function(e) {
    let size = this.files[0].size;
    if (size > 1000000) {
      alert('size is greater than 2mb');
    }
    event.preventDefault(); 
  });


  $(function(){
    $("#categoryForm").validate({
      rules: {
        parent_category: {
          required: true,
        },
        category: "required",
        image: "required"

      },
      messages: {
       parent_category: {
        required: "Please enter a Parent category",
      },
      category: {
        required: "Please provide a category",
      },
      image: {
        required: "Please provide a Image",
      },
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }

  })

    $("#saveBtn").on("click", function(){
      if($("#categoryForm").valid()){
        $("#modal_category").modal("show");
      } else {}
        return false;
      });
  })