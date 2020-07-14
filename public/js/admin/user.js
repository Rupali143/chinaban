$(document).ready(function () {
    $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    $('#category').on('change',function(e) {
      var cat_id = e.target.value;
      $.ajax({
       url:subcategory,
       type:"POST",
       data: { cat_id: cat_id },
       success:function (data) {
        $('#subcategory').empty();                     
        $('#subcategory').append('<option value="'+
         data.subcategories[0].category.parent.id +'">'+
         data.subcategories[0].category.parent.en_name +'</option>');
        }
      })
    });

    $('#isImportTable').DataTable({
      processing: true,
      serverSide: true,
      ajax: isImport,
      columns: [
      // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
      {data: 'users', name: 'users.name'},
      {data: 'category', name: 'category.en_name'},
      {data: 'products', name: 'products.en_name'},
      ]
    });
  });