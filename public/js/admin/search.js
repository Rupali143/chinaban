$(document).ready(function(){
		fill_datatable();
		function fill_datatable(parent_category = '')
		{
			var dataTable = $('#searchTable').DataTable({
				processing: true,
				serverSide: true,
				ajax:{
					url: search,
					data:{parent_category:parent_category}
				},
				columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data:'name',name:'name'},
				{data:'mobile_number',name:'mobile_number'}
				]
			});
		}

		$('#parent_category').on('change',function(e) {
			var parent_category = e.target.value;

			if(parent_category != '')
			{
				$('#searchTable').DataTable().destroy();
				fill_datatable(parent_category);
			}
			else
			{
				alert('Select search option');
			}
		});
	});