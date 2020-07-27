$(document).ready(function() {
  $('#createCategory').click(function(){
    $('#modal_category').modal({
      backdrop: 'static'
    });
  }); 
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  var table = $("#categoryTable").DataTable({
    processing: true,
    "ajax":{
      "url": categoryListing,
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

    validate();
    $('#parent_category, #category, #image').change(validate);
  });

  $('#saveBtn').click(function (e) {
    e.preventDefault();

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
      url: categoryStore,
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      cache:false,
      success: function (data) {
        $('#categoryForm').trigger("reset");
        $('#modal_category').modal('hide');
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

  function validate(){
    if ($('#parent_category').val().length > 0 &&
      $('#category').val().length > 0 &&
      $('#image').val().length > 0) {
      $("#saveBtn").attr("disabled", false);
  }
  else {
    $("#saveBtn").attr("disabled", true);
  }
}


$('body').on('click', '.editCategory', function () {
  var category_id = $(this).data('id');
  $.get(categoryEdit +'/' + category_id, function (data) {
    console.log(data.parent);
    var imagePath = data.get_image.image_location;
    $('#modelHeading').html("Edit Category");
    $('#saveBtn').val("edit-user");
    $('#modal_category').modal('show');
    $('#category_id').val(data.id);
    $('#category').val(data.en_name);
    $('#storage_image').attr('src', configPath +'/'+ imagePath);
    $('#storage_image').append("<input type='hidden' name='hidden_image' id='hidden_image' value='"+ imagePath+"''>");
    if(data.parent == null){
      $('#parent_category').val('0').trigger('change');
    }else{
      $('#parent_category').val(data.parent.id).trigger('change');
    }
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
      //   thisObj = $(this).data('id');
      // var url = 'categoryDelete/'+thisObj;
      // ajax.init();
      // ajax.method='POST';
      // alert(JSON.stringify(url));
      $.ajax({
        url: categoryDelete +'/'+category_id,
        type: "POST",
        success: function (data) {
          if(data){
            Swal.fire(
              'Deleted!',
              'Your Category has been deleted.',
              'success'
              ).then(function() {
                $("#categoryTable").DataTable().ajax.reload();
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






//Validation category
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
  });

});