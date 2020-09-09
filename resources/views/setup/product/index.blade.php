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
						<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Create New</button>
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
									<img src="product_img/{{$data->product_image}}" alt="" style="height: 50px; width: 50px;">
								@else

								@endif)
							</td>
							<td style="">{{$data->product_name}}</td>
							<td style="">{{$data->category->name}}</td>
							<td style="">{{$data->company->name}}</td>
							<td style="display: -webkit-inline-box;">
								<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target=".bd-update-lg" onclick="findEditData({{$data->id}})">Edit</button>
								<form action="{{ route('product.destroy',$data->id) }}" method="POST">
									@csrf
                    				@method('DELETE')
									<input style="margin-left: 10px;" type="submit" id="deletebtn"
										class="btn btn-danger btn-sm" value="Delete">
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
		<form method="POST" id="upload_form" enctype="multipart/form-data">
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
							<label>	Category Name * </label>
							<select type="text" name="Product_category_name" id="Product_category_name" class="form-control" placeholder="Category Name" required>
								<option value="">Select a category</option>
								@foreach ($category as $value)
									<option value="{{$value->id}}">{{$value->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label>	Product Name * </label>
							<input type="text" value="{{ old('name') }}" name="Product_name" id="Product_name" class="form-control" placeholder="Product Name" required>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label>	Company Name * </label>
							<select type="text" name="Product_company_name" id="Product_company_name" class="form-control" placeholder="Company Name" required>
								<option value="">Select a company </option>
								@foreach ($company as $value)
									<option value="{{$value->id}}">{{$value->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label>	Product Model </label>
							<input type="text" value="{{ old('Product_model') }}" name="Product_model" id="Product_model" class="form-control" placeholder="Product Model" required>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label>	Unit Name * </label>
							<select type="text" name="Product_unit_name" id="Product_unit_name" class="form-control" placeholder="Unit Name" required>
								<option value="">Select a unit</option>
								@foreach ($unit as $value)
									<option value="{{$value->id}}">{{$value->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label>	Product Barcode * </label>
							<input type="text" value="{{ old('Product_barcode') }}" name="Product_barcode" id="Product_barcode" class="form-control" placeholder="Product Barcode *" required>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label>	Product Size </label>
							<input type="text" value="{{ old('Product_size') }}" name="Product_size" id="Product_size" class="form-control" placeholder="Product Size" required>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label>Alarm Level </label>
							<input type="text" value="{{ old('Alarm_level') }}" name="Alarm_level" id="Alarm_level" class="form-control" placeholder="Alarm Level" required>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label>	Genral / Warranty </label>
							<select type="text" name="Genral_warranty" id="Genral_warranty" class="form-control" placeholder="Genral / Warranty" required>
								<option value="">Select Type</option>
								<option value="">Genral</option>
								<option value="">Warranty</option>
							</select>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label>	Product Image </label>
							<input type="file" value="{{ old('Product_image') }}" name="Product_image" id="Product_image" class="form-control" placeholder="Product Image" required>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer"  style="border-top: 2px solid rgb(232 227 227);">
				<p  class="btn btn-secondary cursor-pointer" data-dismiss="modal">Close</p>
				<input type="submit" class="btn btn-primary" value="Create">
				<p class="btn btn-danger cursor-pointer" onclick="resetCreateData()"><i class="fas fa-trash-restore"></i> Reset</p>
			</div>
		</div>
		</form>
	</div>
</div>


<!-- Edit modal -->

<div class="modal fade bd-update-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" style="border-bottom: 2px solid rgb(232 227 227);">
				<h5 class="modal-title">Edit Product</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label>	Category Name </label>
							<select type="text" name="name" id="Product_name_edit" class="form-control" placeholder="Product Name" required>

							</select>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label>	Product Name </label>
							<input type="text" value="{{ old('name') }}" name="name" id="Product_name_edit" class="form-control" placeholder="Product Name" required>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label>	Product Email </label>
							<input type="email" value="{{ old('name') }}" name="name" id="Product_email_edit" class="form-control" placeholder="Product Name" required>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label for="description">Product Address</label>
							<textarea class="form-control"  name="Address" id="Product_address_edit"  placeholder="Product Address" rows="2">{{ old('description') }}</textarea>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label for="description">Product Description</label>
							<textarea class="form-control"  name="description" id="Product_description_edit"  placeholder="Product description" rows="2">{{ old('description') }}</textarea>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label>	Product Contact </label>
							<input type="text" value="{{ old('name') }}" name="name" id="Product_contact_edit" class="form-control" placeholder="Product Contact" required>
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" name="Product_edit_id" id="Product_edit_id">
			<div class="modal-footer" style="border-top: 2px solid rgb(232 227 227);">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" onclick="ProductUpdate()">Update</button>
				<button type="button" class="btn btn-danger" onclick="resetUpdateData()"><i class="fas fa-trash-restore"></i> Reset</button>
			</div>
		</div>
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
<script>
$(document).ready(function(){
$('#upload_form').on('submit', function(event){
  event.preventDefault();
    

	// $.ajaxSetup({
	// 	headers: {
	// 		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	// 	}
	// });
	$.ajax({
		url : "{{ route('product.store') }}",
		method:"POST",
		data:new FormData(this),
		dataType:'JSON',
		contentType: false,
		cache: false,
		processData: false,
		success : function(response) {
			console.log(response);
			if(response == 'success'){
				Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: 'Product Create successfully!',
					showConfirmButton: false,
					timer: 1500
				})
				$('.bd-example-modal-lg').modal('hide');
				$('#Product_name').val('');
				$('#Product_category_name').val('');
				$('#Product_company_name').val('');
				$('#Product_unit_name').val('');
				$('#Product_barcode').val('');
				$('#Product_model').val('');
				$('#Product_size').val('');
				$('#Product_level').val('');
				$('#Genral_warranty').val('');
				$('#Product_image').val('');
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

function resetCreateData() {
	$('#Product_name').val('');
	$('#Product_category_name').val('');
	$('#Product_company_name').val('');
	$('#Product_unit_name').val('');
	$('#Product_barcode').val('');
	$('#Product_model').val('');
	$('#Product_size').val('');
	$('#Product_level').val('');
	$('#Genral_warranty').val('');
	$('#Product_image').val('');
}

function findEditData(id)
{
	
	$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			type:"GET",
			url :"/product/"+id+"/edit",
			data : {},
			success : function(response) {
				console.log(response);
				$('#Product_name_edit').val(response.result.name);
				$('#Product_description_edit').val(response.result.description);
				$('#Product_address_edit').val(response.result.address);
				$('#Product_contact_edit').val(response.result.contact);
				$('#Product_email_edit').val(response.result.email);
				$('#Product_edit_id').val(response.result.id);
			}
		});
}


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
	$('#Product_name_edit').val('');
	$('#Product_description_edit').val('');
	$('#Product_address_edit').val('');
	$('#Product_email_edit').val('');
	$('#Product_contact_edit').val('');
}
</script>