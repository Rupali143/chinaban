  $(document).ready(function () {
        $.validator.setDefaults({
          submitHandler: function () {
            alert( "Form successful submitted!" );
          }
        });
        $('#categoryForm').validate({
          rules: {
            parent_category: {
              required: true,
            },
            category: {
              required: true,
            },
          },
          messages: {
            parent_category: {
              required: "Please enter a Parent category",
            },
            category: {
              required: "Please provide a category",
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
        });
      });




  // @extends('layouts.master')
  //    $(document).ready(function() {
  //       $.ajaxSetup({
  //             headers: {
  //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //             }
  //         });
  //         var table = $("#categoryTable").DataTable({
  //           processing: true,
  //           // serverSide: true,
  //           "ajax":{
  //             "url": "{{ route('category.listing') }}",
  //             "type": "GET",
  //          },
  //           columns: [
  //               {data: 'category', name: 'en_name'},
  //               {data: 'parentCategory', name: 'parent_category'},
  //               {data: 'action', name: 'Action'},
  //           ]
  //       });

  //         $('#createCategory').click(function () {
  //           $('#saveBtn').val("create-Item");
  //           $('#category_id').val('');
  //           $('#categoryForm').trigger("reset");
  //           $('#modelHeading').html("Create New Category");
  //           $('#modal_category').modal('show');
  //       });

  //       $('#saveBtn').click(function (e) {
  //       e.preventDefault();
  //       $.ajax({
  //         data: $('#categoryForm').serialize(),
  //         url: "{{ route('categoryStore') }}",
  //         type: "POST",
  //         dataType: 'json',
  //         success: function (data) {
  //             $('#categoryForm').trigger("reset");
  //             $('#modal_category').modal('hide');
  //             Swal.fire(
  //                 'Created!',
  //                 'Your Category has been Created.',
  //                 'success'
  //                 ).then(function() {
  //                   window.location.reload();
  //                 });
  //              table.draw();
  //         },
  //         error: function (data) {
  //             console.log('Error:', data);
  //             $('#saveBtn').html('Submit');
  //         }
  //       });
  //       });

  //       $('body').on('click', '.editCategory', function () {
  //         var category_id = $(this).data('id');
  //         $.get("{{ url('categoryEdit') }}" +'/' + category_id, function (data) {
  //             $('#modelHeading').html("Edit Product");
  //             $('#saveBtn').val("edit-user");
  //             $('#modal_category').modal('show');
  //             $('#category_id').val(data.id);
  //             $('#category').val(data.en_name);
  //             $('#parent_category').val(data.parent_category);
  //         })
  //       });

  //       $('body').on('click', '.deleteCategory', function () {
  //           var category_id = $(this).data("id");
  //           Swal.fire({
  //             title: 'Are you sure?',
  //             icon: 'warning',
  //             showCancelButton: true,
  //             confirmButtonColor: '#3085d6',
  //             cancelButtonColor: '#d33',
  //             confirmButtonText: 'Yes, delete it!'
  //           }).then((result) => {
  //               $.ajax({
  //               type: "GET",
  //               url: "{{ url('categoryDestroy') }}"+'/'+category_id,
  //               success: function (data) {
  //                 table.draw();
  //                 Swal.fire(
  //                 'Deleted!',
  //                 'Your Category has been deleted.',
  //                 'success'
  //                 ).then(function() {
  //                   window.location.reload();
  //                 });              
  //               },
  //               error: function (data) {
  //                   console.log('Error:', data);
  //               }
  //             });
  //           })
            
  //         });
  //     });
  
      