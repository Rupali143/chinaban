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
	var isImport = "{{ route('user.isImport') }}";
</script>
<script type="text/javascript" src="{{ asset('js/admin/user.js')}}"></script>
@endsection