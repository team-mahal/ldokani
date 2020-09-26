@extends('layouts.app')

@section('content')
<div class="header bg-gradient-primary pt-5 pt-md-7"></div>
<div class="container-fluid min-700px">
	{{-- Card List  --}}
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
						<h3 class="mb-0">Card List</h3>
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
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($datas as $key => $data)
						<tr>
							<td scope="row">{{ $key+1 }}</td>
							<td style="">{{$data->name}}</td>
							<td style="display: -webkit-inline-box;">
								<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target=".bd-update-lg" onclick="find_card({{$data->id}})">Edit</button>
								<form action="{{ route('card.destroy',$data->id) }}" method="POST">
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
		<form id="store" action="/card">
			{{ csrf_field() }}
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Create A New Card</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="form-group">
							<label>	Card Name </label>
							<input type="text" value="{{ old('name') }}" name="name" class="form-control" placeholder="Card Name" required>
						</div>
					</div>
				</div>
				<div class="modal-footer">
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
				<div class="modal-header">
					<h5 class="modal-title">Edit Card</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="form-group">
							<label>	Card Name </label>
							<input type="text" value="{{ old('name') }}" name="name" id="name" class="form-control" placeholder="Card Name" required>
						</div>
					</div>
				</div>
				<input type="hidden" name="edit_id" id="edit_id">
				<div class="modal-footer">
					<input type="submit" class="btn btn-primary" value="Update">
					<button type="reset" class="btn btn-danger"><i class="fas fa-trash-restore"></i> Reset</button>
				</div>
			</div>
		</form>
	</div>
</div>

</div>
@endsection
