@extends('layouts.master')
@section('main-content')
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Search Manufacturer</h3>
	</div>
	<div class="card-body">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<div class="form-group">
				<label>Parent Category</label>
				<select class="form-control select2bs4" style="width: 100%;" name="parent_category" id="parent_category">
					<option>Select Category</option>
					<option value="0">Parent</option>
					@foreach($categories as $category)
					<option value="{{ $category->id }}">{{ $category->en_name }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-md-4"></div>
		<table id="searchTable" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Sr.No.</th>
					<th>User Name</th>
					<th>Mobille Number</th>
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
	var search = "{{ route('search.manufacturer') }}";
</script>>
<script src="{{ asset('js/admin/search.js')}}"></script>
@endsection
