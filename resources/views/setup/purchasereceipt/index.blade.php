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
						<h3 class="mb-0">Purchase Receipt List</h3>
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
							<th scope="col">Distributor</th>
							<th scope="col">purchasereceipt Amount</th>
							<th scope="col">Transport Cost</th>
							<th scope="col">Final Amount</th>
							<th scope="col">Total Paid</th>
							<th scope="col">Receipt Status</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($datas as $key => $data)
						<tr>
							<td scope="row">{{ $key+1 }}</td>
							<td style="">{{$data->distributor->name}}</td>
							<td style="">{{$data->amount}}</td>
							<td style="">{{$data->transport_cost}}</td>
							<td style="">{{$data->final_amount}}</td>
							<td style="">{{$data->total_paid}}</td>
							<td style="">@if(empty($data->payment_amount)) {{ "Unpaid" }} @else {{ "Paid" }} @endif</td>
							<td style="display: -webkit-inline-box;">
								<button type="button" class="btn btn-sm btn-success" data-toggle="modal"
									data-target=".bd-update-lg" onclick="find_purchasereceipt({{$data->id}})">Edit</button>
								<form action="{{ route('purchasereceipt.destroy',$data->id) }}" method="POST">
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
		<form method="POST" action="/purchasereceipt" id="store">
			{{ csrf_field() }}
			<div class="modal-content">
				<div class="modal-header" style="border-bottom: 2px solid rgb(232 227 227);">
					<h5 class="modal-title">purchasereceipt Entry</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="distributor_id"> Distributor: * </label>
								<div class="form-control p-0">
									<select type="text" name="distributor_id" id="distributor_id"  class="p-0" style="height:100%;width:90%;" required>
										<option value="">Select a distributor</option>
										@foreach ($distributor as $value)
										<option value="{{$value->id}}">{{$value->name}}</option>
										@endforeach
									</select>
									<i class="fas fa-plus-square fa-w-14 fa-2x"
										style="font-size: 52px;transform: translate(5px, -4px);position: absolute;"
										type="button" class="btn btn-sm btn-primary" data-toggle="modal"
										data-target=".distributor-modal"></i>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label> purchasereceipt Amount * </label>
								<input type="number" name="amount" id="amount"  oninput="totalAmount()" class="form-control" placeholder="Ex: 1000" required>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label>Transport Cost </label>
								<input type="number" name="transport_cost" id="transport_cost" oninput="totalAmount()" class="form-control" placeholder="Ex: 100">
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label>Discount </label>
								<input type="number" name="discount" id="discount" oninput="totalAmount()" class="form-control" placeholder="Ex: 5">
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label>Final Amount </label>
								<input disabled type="number" name="final_amount" id="final_amount" class="form-control" placeholder="Ex: 999" required>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label>Date </label>
								<div class="flatpickr form__group field" id="date2"  class="form__field">
									<input data-input type="text" value="{{ old('date') }}" name="date1" class="form-control" placeholder="Date ">
							  	</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="mode">Payment Mode *</label>
								<select type="text" name="mode" id="mode" class="form-control" onchange="showDiv(this.value)">
									<option value="">Select Mode</option> 
									<option value="1">Cash</option> 
									<option value="2">Cheque</option> 
									<option value="3">Card</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label>Payment Amount </label>
								<input type="number" name="payment_amount" class="form-control" placeholder="Ex: 1000" required>
							</div>
						</div>
					</div>
					<div class="row bg-info p-1 m-2" id="cheque" style="display: none">
						<div class="col-lg-4 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="bank">Bank</label>
								<select type="text" value="{{ old('bank') }}" name="bank" class="form-control">
									<option value="">Select a bank</option> 
									@foreach ($bank as $value)
										<option value="{{ $value->id }}">{{ $value->name }}</option> 
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-lg-4 col-md-12 col-sm-12">
							<div class="form-group">
								<label>Cheque </label>
								<input type="text" value="{{ old('cheque_no') }}" name="cheque_no" class="form-control" placeholder="Cheque No ">
							</div>
						</div>
						<div class="col-lg-4 col-md-12 col-sm-12">
							<div class="form-group">
								<label>Date </label>
								<div class="flatpickr form__group field" id="date"  class="form__field">
									<input data-input type="text" value="{{ old('date') }}" name="date" class="form-control" placeholder="Date ">
							  	</div>
							</div>
						</div>
					</div>
					<div class="row bg-info p-1 m-2" id="card" style="display: none">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="card">Bank</label>
								<select type="text" value="{{ old('card') }}" name="card" class="form-control" >
									<option value="">Select a bank</option> 
									@foreach ($card as $value)
										<option value="{{ $value->id }}">{{ $value->name }}</option> 
									@endforeach
								</select>
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
<div class="modal fade distributor-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
	aria-hidden="true"  style="z-index: 99999999999999">
	<div class="modal-dialog modal-lg">
		<form id="store_distributor_with_purchasereceipt_page" action="/distributor">
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
				<input type="hidden" value="1" name="ispurchasereceipt">
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
					<h5 class="modal-title">purchasereceipt Edit</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="distributor_id"> Distributor: * </label>
								<div class="form-control p-0">
									<select type="text" name="distributor_id" id="distributor_id_edit"  class="p-0" style="height:100%;width:90%;" required>
										<option value="">Select a distributor</option>
										@foreach ($distributor as $value)
										<option value="{{$value->id}}">{{$value->name}}</option>
										@endforeach
									</select>
									<i class="fas fa-plus-square fa-w-14 fa-2x"
										style="font-size: 52px;transform: translate(5px, -4px);position: absolute;"
										type="button" class="btn btn-sm btn-primary" data-toggle="modal"
										data-target=".distributor-modal"></i>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label> purchasereceipt Amount * </label>
								<input type="number" name="amount" id="amount_edit"  oninput="totalAmountEdit()" class="form-control" placeholder="Ex: 1000" required>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label>Transport Cost </label>
								<input type="number" name="transport_cost" id="transport_cost_edit" oninput="totalAmountEdit()" class="form-control" placeholder="Ex: 100">
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label>Discount </label>
								<input type="number" name="discount" id="discount_edit" oninput="totalAmountEdit()" class="form-control" placeholder="Ex: 5">
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label>Final Amount </label>
								<input disabled type="number" name="final_amount" id="final_amount_edit" class="form-control" placeholder="Ex: 999" required>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label>Date </label>
								<div class="flatpickr form__group field" id="date3"  class="form__field">
									<input data-input type="text" value="{{ old('date') }}" name="date1" id="date1_edit" class="form-control" placeholder="Date ">
							  	</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="mode">Payment Mode *</label>
								<select type="text" name="mode" id="mode_edit" class="form-control" onchange="showDivEdit(this.value)">
									<option value="">Select Mode</option> 
									<option value="1">Cash</option> 
									<option value="2">Cheque</option> 
									<option value="3">Card</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="form-group">
								<label>Payment Amount </label>
								<input type="number" name="payment_amount" id="payment_amount" class="form-control" placeholder="Ex: 1000" required>
							</div>
						</div>
					</div>
					<div class="row bg-info p-1 m-2" id="cheque_edit" style="display: none">
						<div class="col-lg-4 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="bank">Bank</label>
								<select type="text" value="{{ old('bank') }}" name="bank" id="bank_edit"  class="form-control">
									<option value="">Select a bank</option> 
									@foreach ($bank as $value)
										<option value="{{ $value->id }}">{{ $value->name }}</option> 
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-lg-4 col-md-12 col-sm-12">
							<div class="form-group">
								<label>Cheque </label>
								<input type="text" value="{{ old('cheque_no') }}" name="cheque_no" id="cheque_no_edit" class="form-control" placeholder="Cheque No ">
							</div>
						</div>
						<div class="col-lg-4 col-md-12 col-sm-12">
							<div class="form-group">
								<label>Date </label>
								<div class="flatpickr form__group field" id="date1"  class="form__field">
									<input data-input type="text" value="{{ old('date') }}" name="date" id="date_edit" class="form-control" placeholder="Date ">
							  	</div>
							</div>
						</div>
					</div>
					<div class="row bg-info p-1 m-2" id="card_edit1" style="display: none">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="card">Bank</label>
								<select type="text" value="{{ old('card') }}" name="card" id="card_edit" class="form-control" >
									<option value="">Select a bank</option> 
									@foreach ($card as $value)
										<option value="{{ $value->id }}">{{ $value->name }}</option> 
									@endforeach
								</select>
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


@endsection


