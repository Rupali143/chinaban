@extends('layouts.master')
@section('main-content')
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Search Manufacturer</h3>
	</div>
	<div class="card-body">
		<div class="form-group">
			<label>Parent Category</label>
			<select class="form-control select2bs4" style="width: 100%;" name="parent_category" id="parent_category">
				<option value="0">Parent</option>
				@foreach($categories as $category)
				<option value="{{ $category->id }}">{{ $category->en_name }}</option>
				@endforeach
			</select>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$(document).ready(function () {
		$('#parent_category').on('change',function(e) {
			var parent_category = e.target.value;
			// alert(parent_category);exit;
			$.ajax({
				url:"{{ route('search.manufacturer') }}",
				type:"POST",
				data: { parent_category: parent_category },
				success:function (data) {
					alert(data);
					// $('#subcategory').empty();                     
					// $('#subcategory').append('<option value="'+
					// 	data.subcategories[0].category.parent.id +'">'+
					// 	data.subcategories[0].category.parent.en_name +'</option>');
				}
			})
		});
	});
</script>
@endsection
