$(document).ready(function () {
    $.validator.setDefaults({
      submitHandler: function () {
        console.log( "Form successful submitted!" );
      }
    });
    $('#loginForm').validate({
      rules: {
          username: {
          required: true,
          username: true,
        },
        password: {
          required: true,
        },
        captcha: {
          required: true
        },
      },
      messages: {
          username: {
          required: "Please enter username",
          username: "Please enter username"
        },
        password: {
          required: "Please provide a password",
        },
        captcha: {
          required: "Please enter captcha",
        },
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
    });
  });