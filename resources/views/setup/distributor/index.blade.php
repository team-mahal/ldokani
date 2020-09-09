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
						<h3 class="mb-0">Distributor List</h3>
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
							<th scope="col">Distributor Name</th>
							<th scope="col">Distributor Email</th>
							<th scope="col">Distributor Contact</th>
							<th scope="col">Distributor Description</th>
							<th scope="col">Distributor Int Balance</th>
							<th scope="col">Distributor Address</th>
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
							<td style="">{{$data->balance}}</td>
							<td style="">{{$data->address}}</td>
							<td style="display: -webkit-inline-box;">
								<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target=".bd-update-lg" onclick="findEditData({{$data->id}})">Edit</button>
								<form action="{{ route('distributor.destroy',$data->id) }}" method="POST">
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
				<h5 class="modal-title">Create A New distributor</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label>	Distributor Name </label>
							<input type="text" value="{{ old('name') }}" name="name" id="distributor_name" class="form-control" placeholder="Distributor Name" required>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label>	Distributor Email </label>
							<input type="email" value="{{ old('name') }}" name="name" id="distributor_email" class="form-control" placeholder="Distributor Name" required>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label for="description">Distributor Address</label>
							<textarea class="form-control"  name="description" id="distributor_address"  placeholder="Distributor address" rows="2">{{ old('description') }}</textarea>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label for="description">Distributor Description</label>
							<textarea class="form-control"  name="description" id="distributor_description"  placeholder="Distributor description" rows="2">{{ old('description') }}</textarea>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label>	Distributor Contact </label>
							<input type="text" value="{{ old('name') }}" name="name" id="distributor_contact" class="form-control" placeholder="Distributor Contact" required>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label>	Int Balence </label>
							<input type="text" value="{{ old('name') }}" name="balence" id="distributor_balence" class="form-control" placeholder="Distributor balence" required>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer"  style="border-top: 2px solid rgb(232 227 227);">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" onclick="distributorStore()">Create</button>
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
				<h5 class="modal-title">Edit distributor</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label>	Distributor Name </label>
							<input type="text" value="{{ old('name') }}" name="name" id="distributor_name_edit" class="form-control" placeholder="Distributor Name" required>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label>	Distributor Email </label>
							<input type="email" value="{{ old('name') }}" name="name" id="distributor_email_edit" class="form-control" placeholder="Distributor Name" required>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label for="description">Distributor Address</label>
							<textarea class="form-control"  name="Address" id="distributor_address_edit"  placeholder="Distributor Address" rows="2">{{ old('description') }}</textarea>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label for="description">Distributor Description</label>
							<textarea class="form-control"  name="description" id="distributor_description_edit"  placeholder="Distributor description" rows="2">{{ old('description') }}</textarea>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label>	Distributor Contact </label>
							<input type="text" value="{{ old('name') }}" name="name" id="distributor_contact_edit" class="form-control" placeholder="Distributor Contact" required>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="form-group">
							<label>	Int Balence </label>
							<input type="text" value="{{ old('name') }}" name="balence" id="distributor_balence_edit" class="form-control" placeholder="Distributor balence" required>
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" name="distributor_edit_id" id="distributor_edit_id">
			<div class="modal-footer" style="border-top: 2px solid rgb(232 227 227);">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" onclick="distributorUpdate()">Update</button>
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
function distributorStore() {
    var name = $('#distributor_name').val();
	var description = $('#distributor_description').val();
	var email = $('#distributor_email').val();
	var contact = $('#distributor_contact').val();
	var address = $('#distributor_address').val();
	var balence = $('#distributor_balence').val();
	// if(name == '' || description == '' || email == '' || contact == '' || address == '' || balence == ''){
	// 	Swal.fire({
	// 		icon: 'error',
	// 		title: 'An Error',
	// 		text: 'distributor name/description/address/contact/email not required !',
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
			type:"POST",
			url : "{{ route('distributor.store') }}",
			data : {
				name: name,
				description: description,
				email: email,
				contact: contact,
				address: address,
				balance: balence
			},
			success : function(response) {
				if(response == 'success'){
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'distributor Create successfully!',
						showConfirmButton: false,
						timer: 1500
					})
				$('.bd-example-modal-lg').modal('hide');
				$('#distributor_name').val('');
				$('#distributor_description').val('');
				$('#distributor_email').val('');
				$('#distributor_contact').val('');
				$('#distributor_address').val('');
				$('#distributor_balence').val('');
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

function resetCreateData() {
	$('#distributor_name').val('');
	$('#distributor_description').val('');
	$('#distributor_email').val('');
	$('#distributor_contact').val('');
	$('#distributor_address').val('');
	$('#distributor_balence').val('');
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
			url :"/distributor/"+id+"/edit",
			data : {},
			success : function(response) {
				console.log(response);
				$('#distributor_name_edit').val(response.result.name);
				$('#distributor_description_edit').val(response.result.description);
				$('#distributor_address_edit').val(response.result.address);
				$('#distributor_contact_edit').val(response.result.contact);
				$('#distributor_email_edit').val(response.result.email);
				$('#distributor_edit_id').val(response.result.id);
				$('#distributor_balence_edit').val(response.result.balance);
			}
		});
}


function distributorUpdate() {
	var name = $('#distributor_name_edit').val();
	var description = $('#distributor_description_edit').val();
	var address = $('#distributor_address_edit').val();
	var email = $('#distributor_email_edit').val();
	var contact = $('#distributor_contact_edit').val();
	var id = $('#distributor_edit_id').val();
	var balence = $('#distributor_balence_edit').val();
	// if(name == '' || description == '' || address == '' || email == '' || contact == '' || balence == ''){
	// 	Swal.fire({
	// 		icon: 'error',
	// 		title: 'An Error',
	// 		text: 'distributor name/description not required !',
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
			url :"/distributor/"+id,
			data : {
				name: name,
				description: description,
				email: email,
				contact: contact,
				address: address,
				balance: balence,
				_method: 'PUT'
			},
			success : function(response) {
				if(response == 'success'){
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'distributor Update successfully!',
						showConfirmButton: false,
						timer: 1500
					})
				$('.bd-update-lg').modal('hide');
				$('#distributor_name_edit').val('');
				$('#distributor_description_edit').val('');
				$('#distributor_address_edit').val('');
				$('#distributor_email_edit').val('');
				$('#distributor_contact_edit').val('');
				$('#distributor_balence_edit').val('');

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
	$('#distributor_name_edit').val('');
	$('#distributor_description_edit').val('');
	$('#distributor_address_edit').val('');
	$('#distributor_email_edit').val('');
	$('#distributor_contact_edit').val('');
	$('#distributor_balence_edit').val('');
}
</script>