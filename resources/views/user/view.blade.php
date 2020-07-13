  @extends('layouts.master')
  @section('main-content')
  <div class="card">
  	<div class="card-header">
  		<h3 class="card-title">User details</h3>
  	</div>
  	<div class="card-body">
  		<div class="form-group row">
  			<label for="userName" class="col-sm-4 col-form-label">Name</label>
  			<div class="col-sm-8">
  				<input type="text" readonly class="form-control" id="name" value="{{ $users->name }}">
  			</div>
  		</div>
  		<div class="form-group row">
  			<label for="UserMobile" class="col-sm-4 col-form-label">Mobile Number</label>
  			<div class="col-sm-8">
  				<input type="text" readonly class="form-control" id="mobile_number" value="{{ $users->mobile_number }}">
  			</div>
  		</div>
  		@if($users->is_manufacture == 1)
  		@php $manufacture = "Yes"; @endphp
  		@else
  		@php $manufacture = "No"; @endphp 
  		@endif
  		<div class="form-group row">
  			<label for="IsManufacture" class="col-sm-4 col-form-label">Is Manufacture</label>
  			<div class="col-sm-8">
  				<input type="text" readonly class="form-control" id="is_manufacture" value="{{ $manufacture }}">
  			</div>
  		</div>
  		<div class="form-group row">
  			<label for="Category" class="col-sm-4 col-form-label">Parent Category</label>
  			<div class="col-sm-8">
  				<select class="form-control" style="width: 100%;" name="category" id="category">
  					@foreach($categories as $category)
  					<option value="{{ $category->category->id }}">{{ $category->category->en_name }}</option>
  					@endforeach
  				</select>
  			</div>
  		</div>
  		<div class="form-group row">
  			<label for="Category" class="col-sm-4 col-form-label">Category</label>
  			<div class="col-sm-8">
  				<select class="browser-default custom-select" name="subcategory" id="subcategory">
          </select>
        </div>
      </div>

      <div class="form-group row">
       @if($users->is_manufacture == 0)	
       @else
       <label for="IsImport" class="col-sm-4 col-form-label">Is import?</label>
       <div class="col-sm-8">
        <u><a href="{{ route('user.isImport') }}">Is import outside of india?</a></u>
       </div>
       @endif
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
    $('#category').on('change',function(e) {
      var cat_id = e.target.value;
      $.ajax({
       url:"{{ route('subcat') }}",
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
  });
</script>
@endsection