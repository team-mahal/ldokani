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
						<h3 class="mb-0">company List</h3>
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
							<th scope="col">Email</th>
							<th scope="col">Contact</th>
							<th scope="col">Description</th>
							<th scope="col">Address</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($datas as $key => $data)
						<tr>
							<td scope="row">{{ $key+1 }}</td>
							<td style="">{{$data->name}}</td>
							<td style="">{{$data->email}}</td>
							<td style="">{{$data->contact}}</td>
							<td style="">{{$data->description}}</td>
							<td style="">{{$data->address}}</td>
							<td style="display: -webkit-inline-box;">
								<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target=".bd-update-lg" onclick="findEditData({{$data->id}})">Edit</button>
								<form action="{{ route('company.destroy',$data->id) }}" method="POST">
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
							<label>	Company Name </label>
							<input type="text" value="{{ old('name') }}" name="name" id="company_name" class="form-control" placeholder="company Name" required>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label>	Company Email </label>
							<input type="email" value="{{ old('name') }}" name="name" id="company_email" class="form-control" placeholder="company Name" required>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label for="description">Company Address</label>
							<textarea class="form-control"  name="description" id="company_address"  placeholder="company address" rows="2">{{ old('description') }}</textarea>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label for="description">Company Description</label>
							<textarea class="form-control"  name="description" id="company_description"  placeholder="company description" rows="2">{{ old('description') }}</textarea>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label>	Company Contact </label>
							<input type="text" value="{{ old('name') }}" name="name" id="company_contact" class="form-control" placeholder="company Contact" required>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer"  style="border-top: 2px solid rgb(232 227 227);">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" onclick="companyStore()">Create</button>
				<button type="button" class="btn btn-danger" onclick="resetCreateData()"><i class="fas fa-trash-restore"></i> Reset</button>
			</div>
		</div>
	</div>
</div>


<!-- Edit modal -->

<div class="modal fade bd-update-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" style="border-bottom: 2px solid rgb(232 227 227);">
				<h5 class="modal-title">Edit Company</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label>	Company Name </label>
							<input type="text" value="{{ old('name') }}" name="name" id="company_name_edit" class="form-control" placeholder="company Name" required>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label>	Company Email </label>
							<input type="email" value="{{ old('name') }}" name="name" id="company_email_edit" class="form-control" placeholder="company Name" required>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label for="description">Company Address</label>
							<textarea class="form-control"  name="Address" id="company_address_edit"  placeholder="company Address" rows="2">{{ old('description') }}</textarea>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label for="description">Company Description</label>
							<textarea class="form-control"  name="description" id="company_description_edit"  placeholder="company description" rows="2">{{ old('description') }}</textarea>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label>	Company Contact </label>
							<input type="text" value="{{ old('name') }}" name="name" id="company_contact_edit" class="form-control" placeholder="company Contact" required>
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" name="company_edit_id" id="company_edit_id">
			<div class="modal-footer" style="border-top: 2px solid rgb(232 227 227);">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" onclick="companyUpdate()">Update</button>
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

<script>
function companyStore() {
    var name = $('#company_name').val();
	var description = $('#company_description').val();
	var email = $('#company_email').val();
	var contact = $('#company_contact').val();
	var address = $('#company_address').val();
	if(name == '' || description == '' || email == '' || contact == '' || address == ''){
		Swal.fire({
			icon: 'error',
			title: 'An Error',
			text: 'company name/description/address/contact/email not required !',
			showConfirmButton: false,
			timer: 1500
		})
	}else{
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
			},
			success : function(response) {
				if(response == 'success'){
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'company Create successfully!',
						showConfirmButton: false,
						timer: 1500
					})
				$('.bd-example-modal-lg').modal('hide');
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
	}
};

function resetCreateData() {
	$('#company_name').val('');
	$('#company_description').val('');
	$('#company_email').val('');
	$('#company_contact').val('');
	$('#company_address').val('');
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
			url :"/company/"+id+"/edit",
			data : {},
			success : function(response) {
				console.log(response);
				$('#company_name_edit').val(response.result.name);
				$('#company_description_edit').val(response.result.description);
				$('#company_address_edit').val(response.result.address);
				$('#company_contact_edit').val(response.result.contact);
				$('#company_email_edit').val(response.result.email);
				$('#company_edit_id').val(response.result.id);
			}
		});
}


function companyUpdate() {
	var name = $('#company_name_edit').val();
	var description = $('#company_description_edit').val();
	var address = $('#company_address_edit').val();
	var email = $('#company_email_edit').val();
	var contact = $('#company_contact_edit').val();
	var id = $('#company_edit_id').val();
	if(name == '' || description == ''){
		Swal.fire({
			icon: 'error',
			title: 'An Error',
			text: 'company name/description not required !',
			showConfirmButton: false,
			timer: 1500
		})
	}else{
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			type: "POST",
			url :"/company/"+id,
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
						title: 'company Update successfully!',
						showConfirmButton: false,
						timer: 1500
					})
				$('.bd-update-lg').modal('hide');
				$('#company_name_edit').val('');
				$('#company_description_edit').val('');
				$('#company_address_edit').val('');
				$('#company_email_edit').val('');
				$('#company_contact_edit').val('');

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
	}
};


function resetUpdateData()
{
	$('#company_name_edit').val('');
	$('#company_description_edit').val('');
	$('#company_address_edit').val('');
	$('#company_email_edit').val('');
	$('#company_contact_edit').val('');
}
</script>