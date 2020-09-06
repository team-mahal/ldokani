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
						<a href="{{ url('/admin/productCreate') }}" class="btn btn-sm btn-primary">Create New</a>
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
							<th scope="col">Shop</th>
							<th scope="col">Buy Price</th>
							<th scope="col">Sale Price</th>
							<th scope="col">Tag Line</th>
							<th scope="col">Type</th>
							<th scope="col">Logo</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($datas as $key => $data)
						<tr>
							<td scope="row">{{ $key+1 }}</td>
							<td style="">{{$data->name}}</td>
							<td style="">@if ($data->is_shop == 0) {{"Not Shop"}}
								@else {{"Shop"}}
								@endif
							</td>
							<td style="">{{$data->buy_price}}</td>
							<td style="">{{$data->sale_price}}</td>
							<td style="">{{$data->tag_line}}</td>
							<td style="">@if ($data->type == 0) {{"Type-1"}}
								@else {{"Type-2"}}
								@endif
							</td>
							<td style=""><img src="{{ asset('product/' . $data->logo) }}" alt="Oops"
									style="max-height: 50px; max-width:100px"> </td>
							<td style="display: -webkit-inline-box;">
								<a href="{{ route('productEdit',[$data->id]) }}" class="btn btn-success btn-sm">Edit</a>
								<!-- <a href="productDelete/{{ $data->id }}" class="btn btn-danger btn-sm">Delete</a> -->
								<form method="get" action="{{ route('productDelete',[$data->id]) }}">
									{{ csrf_field() }}
									{{ method_field('get') }}
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


    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush