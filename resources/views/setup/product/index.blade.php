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
								@if(!empty($data->image))
								<img src="product_img/{{$data->image}}" alt=""
									style="height: 50px; width: 50px; border-radius: 50%;">
								@else
								<img src="product_img/demo.png" alt="" style="height: 50px; width: 50px;">
								@endif
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
									<select type="text" name="category_name" id="category_name"  class="p-0"
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
									<option value="1">Genral</option>
									<option value="0">Warranty</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="image"> Product Image </label>
								<input type="file" value="{{ old('image') }}" name="image" id="image" class="form-control" placeholder="Product Image">
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



<!-- Create company modal -->
<div class="modal fade company-create-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
	aria-hidden="true"  style="z-index: 99999999999999">
	<div class="modal-dialog modal-lg">
		<form id="store_company_with_product_page" action="/company">
			{{ csrf_field() }}
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
								<input type="text" value="{{ old('name') }}" name="name" class="form-control" placeholder="company Name" required>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label>	Company Email </label>
								<input type="email" value="{{ old('name') }}" name="email" class="form-control" placeholder="company Name" required>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="description">Company Address</label>
								<textarea class="form-control"  name="address"  placeholder="company address" rows="2">{{ old('description') }}</textarea>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="description">Company Description</label>
								<textarea class="form-control"  name="description"  placeholder="company description" rows="2">{{ old('description') }}</textarea>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label>	Company Contact </label>
								<input type="text" value="{{ old('name') }}" name="contact" class="form-control" placeholder="company Contact" required>
							</div>
						</div>
						<input type="hidden" value="1" name="isproduct">
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


<!-- Create category modal -->
<div class="modal fade create-category" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
	aria-hidden="true"  style="z-index: 99999999999999">
	<div class="modal-dialog modal-lg">
		<form id="store_category_with_product_page" action="/category">
			{{ csrf_field() }}
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
							<label>Name </label>
							<input type="text" value="{{ old('name') }}" name="name" class="form-control" placeholder="Name" required>
						</div>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="form-group">
							<label for="description">Description</label>
							<textarea class="form-control"  name="description"  placeholder="Description" rows="2">{{ old('description') }}</textarea>
						</div>
					</div>
				</div>
				<input type="hidden" value="1" name="isproduct">
				<div class="modal-footer">
					<input type="submit" class="btn btn-primary" value="Create">
					<button type="reset" class="btn btn-danger"><i class="fas fa-trash-restore"></i> Reset</button>
				</div>
			</div>
		</form>
	</div>
</div>


<!-- Create unit modal -->
<div class="modal fade create-unit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="z-index: 99999999999999">
	<div class="modal-dialog modal-lg">
		<form id="store_unit_with_product_page" action="/unit">
			{{ csrf_field() }}
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
							<label>	Unit Name </label>
							<input type="text" value="{{ old('name') }}" name="name" class="form-control" placeholder="Unit Name" required>
						</div>
					</div>
				</div>
				<input type="hidden" value="1" name="isproduct">
				<div class="modal-footer">
					<input type="submit" class="btn btn-primary" value="Create">
					<button type="reset" class="btn btn-danger"><i class="fas fa-trash-restore"></i> Reset</button>
				</div>
			</div>
		</form>
	</div>
</div>



<!-- Edit modal -->

<div class="modal fade bd-update-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<form method="POST" action="" id="update" enctype="multipart/form-data">
			{{ csrf_field() }}
			@method('PUT')
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
									<option value="1">Genral</option>
									<option value="0">Warranty</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="image_edit"> Product Image </label>
								<input type="file" value="{{ old('image') }}" name="image"
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

