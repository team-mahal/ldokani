@extends('layouts.app')

@section('content')

<!-- flatpickr  -->
<link rel="stylesheet" href="{{ asset('argon') }}/css/flatpickr.css" type="text/css">
<link rel="stylesheet" href="{{ asset('argon') }}/css/dark.css" type="text/css">

<div class="header bg-gradient-primary pt-5 pt-md-7"></div>
<div class="container-fluid min-700px">

	{{-- purchasereceipt List  --}}
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
						<h3 class="mb-0">Purchase Listing</h3>
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
							<th scope="col">Pr. ID</th>
							<th scope="col">Product Name</th>
							<th scope="col">Quantity</th>
							<th scope="col">Unit Buy Price</th>
							<th scope="col">Total Buy Price</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($datas as $key => $data)
						<tr>
							<td scope="row">{{ $key+1 }}</td>
							<td style="">{{$data->purchasereceipt_id}}</td>
							<td style="">{{$data->product->name}}</td>
							<td style="">{{$data->quantity}}</td>
							<td style="">{{$data->unit_buy_price}}</td>
							<td style="">{{$data->total_buy_price}}</td>
							<td style="display: -webkit-inline-box;">
								<button type="button" class="btn btn-sm btn-success" data-toggle="modal"
									data-target=".bd-update-lg" onclick="find_purchaselisting({{$data->id}})">Edit</button>
								<form action="{{ route('purchaselisting.destroy',$data->id) }}" method="POST">
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


<!-- Create modal -->

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<form method="POST" action="/purchaselisting" id="store">
			{{ csrf_field() }}
			<div class="modal-content">
				<div class="modal-header" style="border-bottom: 2px solid rgb(232 227 227);">
					<h5 class="modal-title">Purchase Listing</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row"  id="vuejscom">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="distributor_id"> Select Receipt * </label>
								<multiselect  v-model="selectedpurchasereceipts" :options="purchasereceipts" hideSelected="true" allowEmpty="false" placeholder="Type To Search Distributor" track-by="name" label="name">
									<template slot="option" slot-scope="props">
										<div class="option__desc"><span class="option__title" v-html="props.option.distributor.name"></span></div>
									</template>
									<template slot="singleLabel" slot-scope="{ option }"><strong v-html="option.distributor.name"></strong> </template>
								</multiselect>
								<input type="text" name="purchasereceipt_id"  :value="selectedpurchasereceipts.id" required style="opacity: 0;height: 0px;width: 0px;transform: translate(20px, -30px);">
							</div>
						</div>
						<div class="col-12">
							<div class="table-responsive">
								<!-- Projects table -->
								<table class="table align-items-center table-flush">
									<thead class="thead-light">
										<tr>
											<th scope="col" style="border: 1px solid;" class="text-xs">Distributor Name</th>
											<th scope="col" colspan="3" style="border: 1px solid;" ><p v-if="selectedpurchasereceipts.distributor" v-html="selectedpurchasereceipts.distributor.name" class="text-xs"></p></th>
										</tr>
										<tr>
											<th scope="col" style="border: 1px solid;" class="text-xs">Receipt ID</th>
											<th scope="col" style="border: 1px solid;" ><p v-if="selectedpurchasereceipts" v-html="selectedpurchasereceipts.id" class="text-xs"></p></th>
											<th scope="col" style="border: 1px solid;" class="text-xs">Purchase Date</th>
											<th scope="col" style="border: 1px solid;" ><p v-if="selectedpurchasereceipts" v-html="selectedpurchasereceipts.date" class="text-xs"></p></th>
										</tr>
										<tr>
											<th scope="col" style="border: 1px solid;" class="text-xs">Purchase Price</th>
											<th scope="col" style="border: 1px solid;" ><p v-if="selectedpurchasereceipts" v-html="selectedpurchasereceipts.amount" class="text-xs"></p></th>
											<th scope="col" style="border: 1px solid;" class="text-xs">Discount</th>
											<th scope="col" style="border: 1px solid;" ><p v-if="selectedpurchasereceipts" v-html="selectedpurchasereceipts.discount" class="text-xs"></p></th>
										</tr>
										<tr>
											<th scope="col" style="border: 1px solid;" class="text-xs">Grand Total</th>
											<th scope="col" style="border: 1px solid;" ><p v-if="selectedpurchasereceipts" v-html="selectedpurchasereceipts.final_amount" class="text-xs"></p></th>
											<th scope="col" style="border: 1px solid;" class="text-xs">Transport Cost</th>
											<th scope="col" style="border: 1px solid;" ><p v-if="selectedpurchasereceipts" v-html="selectedpurchasereceipts.transport_cost" class="text-xs"></p></th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
						
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group">
							<label for="product_id"> Product: * </label>
								<div class="d-flex">
									<multiselect v-model="selectedproduct" :options="products" hideSelected="true" allowEmpty="false" placeholder="Type to search" track-by="name" label="name" style="width: 95%">
										<template slot="option" slot-scope="props">
											<div class="option__desc"><span class="option__title" v-html="props.option.name"></span></div>
										</template>
										<template slot="singleLabel" slot-scope="{ option }"><strong v-html="option.name"></strong> </template>
									</multiselect>
									<input type="text" name="product_id" id="product_id"  :value="selectedproduct.id" required style="opacity: 0;height: 0px;width: 0px;transform: translate(-300px, 10px);">
									<div></div>
									<i class="fas fa-plus-square fa-w-14 fa-2x"
										style="font-size: 45px;transform: translate(1px, -2px);"
										type="button" class="btn btn-sm btn-primary" data-toggle="modal"
										data-target=".product-modal"></i>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label> Quantity </label>
								<input type="number" name="quantity" class="form-control" placeholder="Ex: 1000" required>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label>Expire Date: </label>
								<div class="flatpickr form__group field" id="date1"  class="form__field">
									<input data-input type="text" value="{{ old('date') }}" name="expire_date" class="form-control" placeholder="Expire Date " required>
							  	</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label>Total Buy Price </label>
								<input type="number" name="total_buy_price" class="form-control" placeholder="">
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label>MRP: </label>
								<input type="number" name="mrp" class="form-control" placeholder="Ex: 15" required>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label>Unit Buy Price </label>
								<input type="number" name="unit_buy_price" class="form-control" placeholder="Ex: 10" required>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label>Sale Price </label>
								<input type="number" name="sale_price" class="form-control" placeholder="Ex: 12" required>
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



<!-- Create provider modal -->
<div class="modal fade product-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
	aria-hidden="true"  style="z-index: 99999999999999">
	<div class="modal-dialog modal-lg">
		<form id="store_product_with_purchaselisting_page" action="/product">
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
				<input type="hidden" value="1" name="ispurchaselisting">
				<div class="modal-footer"  style="border-top: 2px solid rgb(232 227 227);">
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
						<h5 class="modal-title">Purchase Edit</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row"  id="editmutiselect">
							<div class="col-lg-12 col-md-12 col-sm-12">
								<div class="form-group">
									<label for="distributor_id"> Select Receipt * </label>
									<multiselect  v-model="selectedpurchasereceipts" :options="purchasereceipts" hideSelected="true" allowEmpty="false" placeholder="Type To Search Distributor" track-by="name" label="name">
										<template slot="option" slot-scope="props">
											<div class="option__desc"><span class="option__title" v-html="props.option.distributor.name"></span></div>
										</template>
										<template slot="singleLabel" slot-scope="{ option }"><strong v-html="option.distributor.name"></strong> </template>
									</multiselect>
									<input type="text" name="purchasereceipt_id" id="purchasereceipt_id"  :value="selectedpurchasereceipts.id" required style="opacity: 0;height: 0px;width: 0px;transform: translate(20px, -30px);">
								</div>
							</div>
							<div class="col-12">
								<div class="table-responsive">
									<!-- Projects table -->
									<table class="table align-items-center table-flush">
										<thead class="thead-light">
											<tr>
												<th scope="col" style="border: 1px solid;" class="text-xs">Distributor Name</th>
												<th scope="col" colspan="3" style="border: 1px solid;" ><p v-if="selectedpurchasereceipts.distributor" v-html="selectedpurchasereceipts.distributor.name" class="text-xs"></p></th>
											</tr>
											<tr>
												<th scope="col" style="border: 1px solid;" class="text-xs">Receipt ID</th>
												<th scope="col" style="border: 1px solid;" ><p v-if="selectedpurchasereceipts" v-html="selectedpurchasereceipts.id" class="text-xs"></p></th>
												<th scope="col" style="border: 1px solid;" class="text-xs">Purchase Date</th>
												<th scope="col" style="border: 1px solid;" ><p v-if="selectedpurchasereceipts" v-html="selectedpurchasereceipts.date" class="text-xs"></p></th>
											</tr>
											<tr>
												<th scope="col" style="border: 1px solid;" class="text-xs">Purchase Price</th>
												<th scope="col" style="border: 1px solid;" ><p v-if="selectedpurchasereceipts" v-html="selectedpurchasereceipts.amount" class="text-xs"></p></th>
												<th scope="col" style="border: 1px solid;" class="text-xs">Discount</th>
												<th scope="col" style="border: 1px solid;" ><p v-if="selectedpurchasereceipts" v-html="selectedpurchasereceipts.discount" class="text-xs"></p></th>
											</tr>
											<tr>
												<th scope="col" style="border: 1px solid;" class="text-xs">Grand Total</th>
												<th scope="col" style="border: 1px solid;" ><p v-if="selectedpurchasereceipts" v-html="selectedpurchasereceipts.final_amount" class="text-xs"></p></th>
												<th scope="col" style="border: 1px solid;" class="text-xs">Transport Cost</th>
												<th scope="col" style="border: 1px solid;" ><p v-if="selectedpurchasereceipts" v-html="selectedpurchasereceipts.transport_cost" class="text-xs"></p></th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
							
							<div class="col-lg-12 col-md-12 col-sm-12">
								<div class="form-group">
								<label for="distributor_id"> Product </label>
									<div class="d-flex">
										<multiselect v-model="selectedproduct" :options="products" hideSelected="true" allowEmpty="false" placeholder="Type to search" track-by="name" label="name" style="width: 95%">
											<template slot="option" slot-scope="props">
												<div class="option__desc"><span class="option__title" v-html="props.option.name"></span></div>
											</template>
											<template slot="singleLabel" slot-scope="{ option }"><strong v-html="option.name"></strong> </template>
										</multiselect>
										<input type="text" name="product_id" id="product_id_edit" :value="selectedproduct.id" required style="opacity: 0;height: 0px;width: 0px;transform: translate(-300px, 10px);">
										<div></div>
										<i class="fas fa-plus-square fa-w-14 fa-2x"
											style="font-size: 45px;transform: translate(1px, -2px);"
											type="button" class="btn btn-sm btn-primary" data-toggle="modal"
											data-target=".product-modal"></i>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6 col-md-12 col-sm-12">
								<div class="form-group">
									<label> Quantity </label>
									<input type="number" name="quantity" id="quantity" class="form-control" placeholder="Ex: 1000" required>
								</div>
							</div>
							<div class="col-lg-6 col-md-12 col-sm-12">
								<div class="form-group">
									<label>Expire Date: </label>
									<div class="flatpickr form__group field" id="date"  class="form__field">
										<input data-input type="text" value="{{ old('date') }}" name="expire_date" id="" class="form-control" placeholder="Expire Date " required>
									  </div>
								</div>
							</div>
							<div class="col-lg-6 col-md-12 col-sm-12">
								<div class="form-group">
									<label>Total Buy Price </label>
									<input type="number" name="total_buy_price" id="total_buy_price" class="form-control" placeholder="">
								</div>
							</div>
							<div class="col-lg-6 col-md-12 col-sm-12">
								<div class="form-group">
									<label>MRP: </label>
									<input type="number" name="mrp" id="mrp" class="form-control" placeholder="Ex: 15" required>
								</div>
							</div>
							<div class="col-lg-6 col-md-12 col-sm-12">
								<div class="form-group">
									<label>Unit Buy Price </label>
									<input type="number" name="unit_buy_price" id="unit_buy_price" class="form-control" placeholder="Ex: 10" required>
								</div>
							</div>
							<div class="col-lg-6 col-md-12 col-sm-12">
								<div class="form-group">
									<label>Sale Price </label>
									<input type="number" name="sale_price" id="sale_price" class="form-control" placeholder="Ex: 12" required>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer" style="border-top: 2px solid rgb(232 227 227);">
						<input type="submit" class="btn btn-success" value="Update">
						<button type="reset" class="btn btn-danger"><i class="fas fa-trash-restore"></i> Reset</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
</div>



@endsection





<!-- include VueJS first -->
<script src="https://unpkg.com/vue@latest"></script>

<script src="https://unpkg.com/vue-multiselect@2.1.0"></script>
<link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">

<script type="application/javascript">

setTimeout(function(){
	Vue.component('multiselect', window.VueMultiselect.default)
	const vm = new Vue({
	  el:"#vuejscom",
	  data() {
			return {
				products:[],
				purchasereceipts:[],
				selectedproduct:[],
				selectedpurchasereceipts:[],

			};
		},
		created(){
			var self = this;
			$.ajax({
			  url     : '/get-product',
			  cash    : false,
			  dataType: 'json',
			  success : function(re)
			  {	
				self.products=re
			  }
			});
			$.ajax({
			  url     : '/get-purchasereceipt',
			  cash    : false,
			  dataType: 'json',
			  success : function(re)
			  {	
				self.purchasereceipts=re
			  }
			});
		}
	})
}, 1000)



setTimeout(function(){
	Vue.component('multiselect', window.VueMultiselect.default)
	const vm = new Vue({
	  el:"#editmutiselect",
	  data() {
			return {
				products:[],
				purchasereceipts:[],
				selectedproduct:[],
				selectedpurchasereceipts:[],

			};
		},
		created(){
			var self = this;
			$.ajax({
			  url     : '/get-product',
			  cash    : false,
			  dataType: 'json',
			  success : function(re)
			  {	
				self.products=re
			  }
			});
			$.ajax({
			  url     : '/get-purchasereceipt',
			  cash    : false,
			  dataType: 'json',
			  success : function(re)
			  {	
				self.purchasereceipts=re
			  }
			});
		}
	})
}, 1000)
</script>