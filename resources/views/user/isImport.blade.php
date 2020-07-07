@extends('layouts.master')
@section('main-content')
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Is import details</h3>
	</div>
	<div class="card-body">
		<table id="isImportTable" class="table table-bordered table-striped">
			<thead>
				<tr>
					<!-- <th>Sr.No.</th> -->
					<th>User Name</th>
					<th>Category Name</th>
					<th>Product Name</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
	$(document).ready(function() {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$('#isImportTable').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('user.isImport') }}",
			columns: [
			// {data: 'DT_RowIndex', name: 'DT_RowIndex'},
			{data: 'users', name: 'users.name'},
			{data: 'category', name: 'category.en_name'},
			{data: 'products', name: 'products.en_name'},
			]
		});
	});
</script>
@endsection