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
								<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target=".bd-update-lg" onclick="find_distributor({{$data->id}})">Edit</button>
								<form action="{{ route('distributor.destroy',$data->id) }}" method="POST">
									@csrf
                    				@method('DELETE')
									<input style="margin-left: 10px;" type="submit" class="btn btn-danger btn-sm" value="Delete">
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
		<form id="store" action="/distributor">
			{{ csrf_field() }}
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
								<input type="text" value="{{ old('name') }}" name="name" class="form-control" placeholder="Distributor Name" required>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="email">	Distributor Email </label>
								<input type="email" value="{{ old('email') }}" name="email" class="form-control" placeholder="Distributor Name" required>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="address">Distributor Address</label>
								<textarea class="form-control"  name="address" placeholder="Distributor address" rows="2">{{ old('description') }}</textarea>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="description">Distributor Description</label>
								<textarea class="form-control"  name="description" placeholder="Distributor description" rows="2">{{ old('description') }}</textarea>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="contact">Distributor Contact </label>
								<input type="text" value="{{ old('contact') }}" name="contact" class="form-control" placeholder="Distributor Contact" required>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="balence">	Int Balence </label>
								<input type="text" value="{{ old('balence') }}" name="balence" class="form-control" placeholder="Distributor balence" required>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer"  style="border-top: 2px solid rgb(232 227 227);">
					<input type="submit" class="btn btn-primary" value="Create">
					<button type="reset" class="btn btn-danger"><i class="fas fa-trash-restore"></i> Reset</button>
				</div>
			</div>
		</form>
	</div>
</div>


<!-- Edit modal -->

<div class="modal fade bd-update-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<form id="update" action="">
			{{ csrf_field() }}
			@method('PUT')
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
								<input type="text" value="{{ old('name') }}" name="name" id="name" class="form-control" placeholder="Distributor Name" required>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label>	Distributor Email </label>
								<input type="email" value="{{ old('email') }}" name="email" id="email" class="form-control" placeholder="Distributor Name" required>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="description">Distributor Address</label>
								<textarea class="form-control"  name="address" id="address"  placeholder="Distributor Address" rows="2">{{ old('description') }}</textarea>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="description">Distributor Description</label>
								<textarea class="form-control"  name="description" id="description"  placeholder="Distributor description" rows="2">{{ old('description') }}</textarea>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label>	Distributor Contact </label>
								<input type="text" value="{{ old('contact') }}" name="contact" id="contact" class="form-control" placeholder="Distributor Contact" required>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label>	Int Balence </label>
								<input type="text" value="{{ old('balance') }}" name="balance" id="balance" class="form-control" placeholder="Distributor balence" required>
							</div>
						</div>
					</div>
				</div>
				<input type="hidden" name="distributor_edit_id" id="distributor_edit_id">
				<div class="modal-footer" style="border-top: 2px solid rgb(232 227 227);">
					<input type="submit" class="btn btn-primary" value="Update">
					<button type="reset" class="btn btn-danger"><i class="fas fa-trash-restore"></i> Reset</button>
				</div>
			</div>
		</form>
	</div>
</div>

</div>
@endsection
