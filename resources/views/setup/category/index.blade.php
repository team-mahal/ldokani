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
						<h3 class="mb-0">Category List</h3>
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
							<th scope="col">Description</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($datas as $key => $data)
						<tr>
							<td scope="row">{{ $key+1 }}</td>
							<td style="">{{$data->name}}</td>
							<td style="">{{$data->description}}</td>
							<td style="display: -webkit-inline-box;">
								<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target=".bd-update-lg" onclick="findEditData({{$data->id}})">Edit</button>
								<form action="{{ route('category.destroy',$data->id) }}" method="POST">
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
			<div class="modal-header">
				<h5 class="modal-title">Create A New Category</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="form-group">
						<label>	Category Name </label>
						<input type="text" value="{{ old('name') }}" name="name" id="category_name" class="form-control" placeholder="Category Name" required>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="form-group">
						<label for="description">Category Description</label>
						<textarea class="form-control"  name="description" id="category_description"  placeholder="Category description" rows="2">{{ old('description') }}</textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" onclick="categoryStore()">Create</button>
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
			<div class="modal-header">
				<h5 class="modal-title">Edit Category</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="form-group">
						<label>	Category Name </label>
						<input type="text" value="{{ old('name') }}" name="name" id="category_name_edit" class="form-control" placeholder="Category Name" required>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="form-group">
						<label for="description">Category Description</label>
						<textarea class="form-control"  name="description" id="category_description_edit"  placeholder="Category description" rows="2">{{ old('description') }}</textarea>
					</div>
				</div>
			</div>
			<input type="hidden" name="category_edit_id" id="category_edit_id">
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" onclick="categoryUpdate()">Update</button>
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
function categoryStore() {
    var name = $('#category_name').val();
	var description = $('#category_description').val();
	if(name == '' || description == ''){
		Swal.fire({
			icon: 'error',
			title: 'An Error',
			text: 'Category name/description not required !',
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
			url : "{{ route('category.store') }}",
			data : {
				name: name,
				description: description
			},
			success : function(response) {
				console.log(response);
				if(response == 'success'){
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Category Create successfully!',
						showConfirmButton: false,
						timer: 1500
					})
				$('.bd-example-modal-lg').modal('hide');
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
	}
};

function resetCreateData() {
	$('#category_name').val('');
	$('#category_description').val('');
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
			url :"/category/"+id+"/edit",
			data : {},
			success : function(response) {
				$('#category_name_edit').val(response.result.name);
				$('#category_description_edit').val(response.result.description);
				$('#category_edit_id').val(response.result.id);
			}
		});
}


function categoryUpdate() {
	var name = $('#category_name_edit').val();
	var description = $('#category_description_edit').val();
	var id = $('#category_edit_id').val();
	if(name == '' || description == ''){
		Swal.fire({
			icon: 'error',
			title: 'An Error',
			text: 'Category name/description not required !',
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
			url :"/category/"+id,
			data : {
				name: name,
				description: description,
				_method: 'PUT'
			},
			success : function(response) {
				if(response == 'success'){
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Category Update successfully!',
						showConfirmButton: false,
						timer: 1500
					})
				$('.bd-update-lg').modal('hide');
				$('#category_name_edit').val('');
				$('#category_description_edit').val('');

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
	$('#category_name_edit').val('');
	$('#category_description_edit').val('');
}
</script>