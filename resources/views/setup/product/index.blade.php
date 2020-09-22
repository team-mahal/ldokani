@extends('layouts.app')

@section('content')
<div class="header bg-gradient-primary pt-5 pt-md-7"></div>
<div class="container-fluid min-700px">

	{{-- Product List  --}}
	<div class="col-xl-12">
		@csrf
		@if ($message = Session::get('success'))
		<div class="row justify-content-center">
			<div class="col-lg-6 col-md-8col-sm-12 mt-2 alert alert-success">
				{{ $message }}
			</div>
		</div>
		@endif

		@if (count($errors) > 0)
		<div class="row justify-content-center">
			<div class="col-lg-6 col-md-8col-sm-12 mt-2 alert alert-danger">
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</div>
		</div>
		@endif


		<div class="card mt-5">
			<div class="card-header border-0">
				<div class="row align-items-center">
					<div class="col">
						<h3 class="mb-0">Product List</h3>
					</div>
					<div class="col text-right">
						<button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
							data-target=".bd-example-modal-lg">Create New</button>
					</div>
				</div>
			</div>
			<?php if(empty($datas)){  ?>
			<div class="alert alert-danger mr-2 ml-2">
				Sorry No Information Found !!!
			</div>
			<?php }else{ ?>
			<div class="table-responsive">
				<!-- Projects table -->
				<table class="table align-items-center table-flush">
					<thead class="thead-light">
						<tr>
							<th scope="col">#</th>
							<th scope="col">Name</th>
							<th scope="col">Product Name</th>
							<th scope="col">Product Category</th>
							<th scope="col">Product Company</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($datas as $key => $data)
						<tr>
							<td scope="row">{{ $key+1 }}</td>
							<td style="">
								@if(!empty($data->product_image))
								<img src="product_img/{{$data->product_image}}" alt=""
									style="height: 50px; width: 50px;">
								@else
								<img src="product_img/demo.png" alt="" style="height: 50px; width: 50px;">
								@endif)
							</td>
							<td style="">{{$data->name}}</td>
							<td style="">@if(!is_null($data->category)) {{$data->category->name}} @endif</td>
							<td style="">@if(!is_null($data->company)) {{$data->company->name}} @endif</td>
							<td style="display: -webkit-inline-box;">
								<button type="button" class="btn btn-sm btn-success" data-toggle="modal"
									data-target=".bd-update-lg" onclick="find_product({{$data->id}})">Edit</button>
								<form action="{{ route('product.destroy',$data->id) }}" method="POST">
									@csrf
									@method('DELETE')
									<input style="margin-left: 10px;" type="submit" class="btn btn-danger btn-sm"
										value="Delete">
								</form>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				<div class="justify-content-center">
					{{ $datas->render() }}
				</div>
			</div>
			<?php } ?>
		</div>
	</div>

</div>

<!-- Create modal -->

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<form method="POST" action="/product" id="store" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div class="modal-content">
				<div class="modal-header" style="border-bottom: 2px solid rgb(232 227 227);">
					<h5 class="modal-title">Create A New Product</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="category_name"> Category Name * </label>
								<div class="form-control p-0">
									<select type="text" name="category_name" id="category_name" class="p-0"
										style="height:100%;width:90%;" placeholder="Category Name" required>
										<option value="">Select a category</option>
										@foreach ($category as $value)
										<option value="{{$value->id}}">{{$value->name}}</option>
										@endforeach
									</select>
									<i class="fas fa-plus-square fa-w-14 fa-2x"
										style="font-size: 52px;transform: translate(5px, -4px);position: absolute;"
										type="button" class="btn btn-sm btn-primary" data-toggle="modal"
										data-target=".create-category"></i>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group p-0">
								<label for="name"> Product Name * </label>
								<input type="text" value="{{ old('name') }}" name="name" id="name" class="form-control"
									placeholder="Product Name" required>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="company_name"> Company Name * </label>
								<div class="form-control p-0">
									<select type="text" name="company_name" id="company_name" class="p-0"
										style="height:100%;width:90%;" placeholder="Company Name" required>
										<option value="">Select a company </option>
										@foreach ($company as $value)
										<option value="{{$value->id}}">{{$value->name}}</option>
										@endforeach
									</select>
									<i class="fas fa-plus-square fa-w-14 fa-2x"
										style="font-size: 52px;transform: translate(5px, -4px);position: absolute;"
										type="button" class="btn btn-sm btn-primary" data-toggle="modal"
										data-target=".company-create-modal"></i>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="model"> Product Model </label>
								<input type="text" value="{{ old('model') }}" name="model" id="model"
									class="form-control" placeholder="Product Model">
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="unit_name"> Unit Name * </label>
								<div class="form-control p-0">
									<select type="text" name="unit_name" id="unit_name" style="height:100%;width:90%;"
										placeholder="Unit Name" required>
										<option value="">Select a unit</option>
										@foreach ($unit as $value)
										<option value="{{$value->id}}">{{$value->name}}</option>
										@endforeach
									</select>
									<i class="fas fa-plus-square fa-w-14 fa-2x"
										style="font-size: 52px;transform: translate(5px, -4px);position: absolute;"
										type="button" class="btn btn-sm btn-primary" data-toggle="modal"
										data-target=".create-unit"></i>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="barcode"> Product Barcode * </label>
								<input type="number" name="barcode" id="barcode" class="form-control"
									placeholder="Product Barcode *" required>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="size"> Product Size </label>
								<input type="text" value="{{ old('Product_size') }}" name="size" id="size"
									class="form-control" value="0" placeholder="Product Size">
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="level">Alarm Level </label>
								<input type="text" value="{{ old('level') }}" name="level" id="level"
									class="form-control" placeholder="Alarm Level">
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="genral_warranty"> Genral / Warranty </label>
								<select type="text" name="genral_warranty" id="genral_warranty" class="form-control"
									placeholder="Genral / Warranty" required>
									<option value="">Select Type</option>
									<option value="">Genral</option>
									<option value="">Warranty</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="image"> Product Image </label>
								<input type="file" value="{{ old('image') }}" name="image" id="image"
									class="form-control" placeholder="Product Image">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer" style="border-top: 2px solid rgb(232 227 227);">
					<input type="submit" class="btn btn-primary" value="Create">
					<button type="reset" class="btn btn-danger"><i class="fas fa-trash-restore"></i> Reset</button>
				</div>
			</div>
		</form>
	</div>
</div>



<!-- Create modal -->

<div class="modal fade company-create-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" style="border-bottom: 2px solid rgb(232 227 227);">
				<h5 class="modal-title">Create A New company</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label> Company Name </label>
							<input type="text" value="{{ old('name') }}" name="name" id="company_name"
								class="form-control" placeholder="company Name" required>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label> Company Email </label>
							<input type="email" value="{{ old('name') }}" name="name" id="company_email"
								class="form-control" placeholder="company Name" required>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label for="description">Company Address</label>
							<textarea class="form-control" name="description" id="company_address"
								placeholder="company address" rows="2">{{ old('description') }}</textarea>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label for="description">Company Description</label>
							<textarea class="form-control" name="description" id="company_description"
								placeholder="company description" rows="2">{{ old('description') }}</textarea>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label> Company Contact </label>
							<input type="text" value="{{ old('name') }}" name="name" id="company_contact"
								class="form-control" placeholder="company Contact" required>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer" style="border-top: 2px solid rgb(232 227 227);">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" onclick="companyStore()">Create</button>
				<button type="button" class="btn btn-danger" onclick="resetCreateData()"><i
						class="fas fa-trash-restore"></i> Reset</button>
			</div>
		</div>
	</div>
</div>


<!-- Create modal -->

<div class="modal fade create-category" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Create A New Category</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="form-group">
						<label> Category Name </label>
						<input type="text" value="{{ old('name') }}" name="name" id="category_name" class="form-control"
							placeholder="Category Name" required>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="form-group">
						<label for="description">Category Description</label>
						<textarea class="form-control" name="description" id="category_description"
							placeholder="Category description" rows="2">{{ old('description') }}</textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" onclick="categoryStore()">Create</button>
				<button type="button" class="btn btn-danger" onclick="resetCreateDataCategory()"><i
						class="fas fa-trash-restore"></i> Reset</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade create-unit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Create A New Unit</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="form-group">
						<label> Unit Name </label>
						<input type="text" value="{{ old('name') }}" name="name" id="name" class="form-control"
							placeholder="Unit Name" required>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" onclick="UnitStore()">Create</button>
				<button type="button" class="btn btn-danger" onclick="resetCreateDataUnit()"><i
						class="fas fa-trash-restore"></i> Reset</button>
			</div>
		</div>
	</div>
</div>


<!-- Edit modal -->

<div class="modal fade bd-update-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<form method="POST" action="" id="update" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div class="modal-content">
				<div class="modal-header" style="border-bottom: 2px solid rgb(232 227 227);">
					<h5 class="modal-title">Create A New Product</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="category_name_edit"> Category Name * </label>
								<div class="form-control p-0">
									<select type="text" name="category_name" id="category_name_edit" class="p-0"
										style="height:100%;width:90%;" placeholder="Category Name" required>
										<option value="">Select a category</option>
										@foreach ($category as $value)
										<option value="{{$value->id}}">{{$value->name}}</option>
										@endforeach
									</select>
									<i class="fas fa-plus-square fa-w-14 fa-2x"
										style="font-size: 52px;transform: translate(5px, -4px);position: absolute;"
										type="button" class="btn btn-sm btn-primary" data-toggle="modal"
										data-target=".create-category"></i>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group p-0">
								<label for="name_edit"> Product Name * </label>
								<input type="text" value="{{ old('name') }}" name="name" id="name_edit" class="form-control"
									placeholder="Product Name" required>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="company_name_edit"> Company Name * </label>
								<div class="form-control p-0">
									<select type="text" name="company_name" id="company_name_edit" class="p-0"
										style="height:100%;width:90%;" placeholder="Company Name" required>
										<option value="">Select a company </option>
										@foreach ($company as $value)
										<option value="{{$value->id}}">{{$value->name}}</option>
										@endforeach
									</select>
									<i class="fas fa-plus-square fa-w-14 fa-2x"
										style="font-size: 52px;transform: translate(5px, -4px);position: absolute;"
										type="button" class="btn btn-sm btn-primary" data-toggle="modal"
										data-target=".company-create-modal"></i>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="model_edit"> Product Model </label>
								<input type="text" value="{{ old('model') }}" name="model" id="model_edit"
									class="form-control" placeholder="Product Model">
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="unit_name_edit"> Unit Name * </label>
								<div class="form-control p-0">
									<select type="text" name="unit_name" id="unit_name_edit" style="height:100%;width:90%;"
										placeholder="Unit Name" required>
										<option value="">Select a unit</option>
										@foreach ($unit as $value)
										<option value="{{$value->id}}">{{$value->name}}</option>
										@endforeach
									</select>
									<i class="fas fa-plus-square fa-w-14 fa-2x"
										style="font-size: 52px;transform: translate(5px, -4px);position: absolute;"
										type="button" class="btn btn-sm btn-primary" data-toggle="modal"
										data-target=".create-unit"></i>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="barcode_edit"> Product Barcode * </label>
								<input type="number" name="barcode" id="barcode_edit" class="form-control"
									placeholder="Product Barcode *" required>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="size_edit"> Product Size </label>
								<input type="text" value="{{ old('Product_size') }}" name="size" id="size_edit"
									class="form-control" value="0" placeholder="Product Size">
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="level_edit">Alarm Level </label>
								<input type="text" value="{{ old('level') }}" name="level" id="level_edit"
									class="form-control" placeholder="Alarm Level">
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="genral_warranty_edit"> Genral / Warranty </label>
								<select type="text" name="genral_warranty" id="genral_warranty_edit" class="form-control"
									placeholder="Genral / Warranty" required>
									<option value="">Select Type</option>
									<option value="">Genral</option>
									<option value="">Warranty</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="image_edit"> Product Image </label>
								<input type="file" value="{{ old('image') }}" name="image_edit" id="image"
									class="form-control" placeholder="Product Image">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer" style="border-top: 2px solid rgb(232 227 227);">
					<input type="submit" class="btn btn-primary" value="Create">
					<button type="reset" class="btn btn-danger"><i class="fas fa-trash-restore"></i> Reset</button>
				</div>
			</div>
		</form>
	</div>
</div>

</div>
@endsection

@push('js')
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

{{-- <script>
	function GenerateUniqueID() {
		return (Math.random() * (78500000 - 78400101) + 78400101)|0;
	}
	console.log(GenerateUniqueID());
	console.log($('#barcode'));
	document.getElementById('product_barcode').value = GenerateUniqueID();
</script> --}}



<script>
	function ProductUpdate() {
	var name = $('#Product_name_edit').val();
	var description = $('#Product_description_edit').val();
	var address = $('#Product_address_edit').val();
	var email = $('#Product_email_edit').val();
	var contact = $('#Product_contact_edit').val();
	var id = $('#Product_edit_id').val();
	// if(name == '' || description == ''){
	// 	Swal.fire({
	// 		icon: 'error',
	// 		title: 'An Error',
	// 		text: 'Product name/description not required !',
	// 		showConfirmButton: false,
	// 		timer: 1500
	// 	})
	// }else{
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			type: "POST",
			url :"/product/"+id,
			data : {
				name: name,
				description: description,
				email: email,
				contact: contact,
				address: address,
				_method: 'PUT'
			},
			success : function(response) {
				if(response == 'success'){
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Product Update successfully!',
						showConfirmButton: false,
						timer: 1500
					})
				$('.bd-update-lg').modal('hide');
				$('#Product_name_edit').val('');
				$('#Product_description_edit').val('');
				$('#Product_address_edit').val('');
				$('#Product_email_edit').val('');
				$('#Product_contact_edit').val('');

				}else{
					Swal.fire({
						position: 'top-end',
						icon: 'error',
						title: 'An error across',
						showConfirmButton: false,
						timer: 1500
					})
				}
			}
		});
	// }
};


function resetUpdateData()
{
	$('#product_name_edit').val('');
	$('#product_category_name_edit').val('');
	$('#product_company_name_edit').val('');
	$('#product_unit_name_edit').val('');
	$('#product_barcode_edit').val('');
	$('#product_model_edit').val('');
	$('#product_size_edit').val('');
	$('#alarm_level_edit').val('');
	$('#genral_warranty_edit').val('');
}

function companyStore() {
    var name = $('#company_name').val();
	var description = $('#company_description').val();
	var email = $('#company_email').val();
	var contact = $('#company_contact').val();
	var address = $('#company_address').val();
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			type:"POST",
			url : "{{ route('company.store') }}",
			data : {
				name: name,
				description: description,
				email: email,
				contact: contact,
				address: address,
				isproduct: 1,
			},
			success : function(response) {
				if(jQuery.isNumeric(response)){
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'company Create successfully!',
						showConfirmButton: false,
						timer: 1500
					})
				var x = document.getElementById("product_company_name");
				var option = document.createElement("option");
  				option.text = name;
				option.value = response;
				option.setAttribute("selected", "selected");
				x.add(option, x[1]);
				$('.company-create-modal').modal('hide');
				$('#company_name').val('');
				$('#company_description').val('');
				$('#company_email').val('');
				$('#company_contact').val('');
				$('#company_address').val('');
				}else{
					Swal.fire({
						position: 'top-end',
						icon: 'error',
						title: 'An error across',
						showConfirmButton: false,
						timer: 1500
					})
				}
			}
		});
};

function resetCreateData() {
	$('#company_name').val('');
	$('#company_description').val('');
	$('#company_email').val('');
	$('#company_contact').val('');
	$('#company_address').val('');
}

function categoryStore() {
var name = $('#category_name').val();
var description = $('#category_description').val();
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
		type:"POST",
		url : "{{ route('category.store') }}",
		data : {
			name: name,
			description: description,
			isproduct: 1,
		},
		success : function(response) {
			if(jQuery.isNumeric(response)){
				Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: 'Category Create successfully!',
					showConfirmButton: false,
					timer: 1500
				})
			var x = document.getElementById("product_category_name");
			var option = document.createElement("option");
			option.text = name;
			option.value = response;
			option.setAttribute("selected", "selected");
			x.add(option, x[1]);
			$('.create-category').modal('hide');
			$('#category_name').val('');
			$('#category_description').val('');

			}else{
				Swal.fire({
					position: 'top-end',
					icon: 'error',
					title: 'An error across',
					showConfirmButton: false,
					timer: 1500
				})
			}
		}
	});
};

function resetCreateDataCategory() {
	$('#category_name').val('');
	$('#category_description').val('');
}


function UnitStore() {
    var name = $('#name').val();
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
		type:"POST",
		url : "{{ route('unit.store') }}",
		data : {
			name: name,
			isproduct: 1,
		},
		success : function(response) {
			if(jQuery.isNumeric(response)){
				Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: 'Unit Create successfully!',
					showConfirmButton: false,
					timer: 1500
				})
			var x = document.getElementById("product_unit_name");
			var option = document.createElement("option");
			option.text = name;
			option.value = response;
			option.setAttribute("selected", "selected");
			x.add(option, x[1]);
			$('.create-unit').modal('hide');
			$('#name').val('');

			}else{
				Swal.fire({
					position: 'top-end',
					icon: 'error',
					title: 'An error across',
					showConfirmButton: false,
					timer: 1500
				})
			}
		}
	});
};

function resetCreateDataUnit() {
	$('#name').val('');
}

//****** product data update ****** //

$(document).ready(function(){
$('#upload_update_form_data').on('submit', function(event){
	var id = $('#product_edit_id').val();
	console.log(this);
  event.preventDefault();
  console.log("asdasd");
	$.ajax({
		url : "/product/"+id,
		method:"PUT",
		data:new FormData(this),
		type: 'PUT',
		dataType:'multipart/form-data',
		contentType: false,
		cache: false,
		processData: false,
		success : function(response) {
			console.log(response);
			console.log("response");
			if(response == 'success'){
				Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: 'Product Update successfully!',
					showConfirmButton: false,
					timer: 1500
				})
				$('.bd-update-lg').modal('hide');
				$('#product_name_edit').val('');
				$('#product_category_name_edit').val('');
				$('#product_company_name_edit').val('');
				$('#product_unit_name_edit').val('');
				$('#product_barcode_edit').val('');
				$('#product_model_edit').val('');
				$('#product_size_edit').val('');
				$('#alarm_level_edit').val('');
				$('#genral_warranty_edit').val('');
			}else{
				Swal.fire({
					position: 'top-end',
					icon: 'error',
					title: 'An error across',
					showConfirmButton: false,
					timer: 1500
				})
			}
		},
		error: function(response) {
			if(response.responseText == 'success'){
				Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: 'Product Update successfully!',
					showConfirmButton: false,
					timer: 1500
				})
				$('.bd-update-lg').modal('hide');
				$('#product_name_edit').val('');
				$('#product_category_name_edit').val('');
				$('#product_company_name_edit').val('');
				$('#product_unit_name_edit').val('');
				$('#product_barcode_edit').val('');
				$('#product_model_edit').val('');
				$('#product_size_edit').val('');
				$('#alarm_level_edit').val('');
				$('#genral_warranty_edit').val('');
			}else{
				Swal.fire({
					position: 'top-end',
					icon: 'error',
					title: 'An error across',
					showConfirmButton: false,
					timer: 1500
				})
			}
		}
	});
});
});


</script>


<script>
	function GenerateUniqueID() {
		return (Math.random() * (78500000 - 78400101) + 78400101)|0;
	}
	setTimeout(() => {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
		method:"POST",
		url : "{{ route('LastProduct') }}",
		dataType:'JSON',
		contentType: false,
		cache: false,
		processData: false,
		success : function(response) {
			document.getElementById('barcode').value = response.toString()+GenerateUniqueID();
		}
	});
	}, 500);

	
</script>