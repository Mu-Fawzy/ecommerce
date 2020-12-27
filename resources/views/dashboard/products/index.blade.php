@extends('layouts.dashboard.master')
@section('css')
<!--Internal   Notify -->
<link href="{{URL::asset('dashboard/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">@lang('site.all products')</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ @lang('site.products') ({{ $products->total() }})</span>
						</div>
					</div>
					<div class="d-flex my-xl-auto right-content">
						<div class="mb-3 mb-xl-0">
							<div class="btn-group dropdown">
								<button type="button" class="btn btn-primary">14 Aug 2019</button>
								<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuDate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="sr-only">Toggle Dropdown</span>
								</button>
								<div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuDate" data-x-placement="bottom-end">
									<a class="dropdown-item" href="#">2015</a>
									<a class="dropdown-item" href="#">2016</a>
									<a class="dropdown-item" href="#">2017</a>
									<a class="dropdown-item" href="#">2018</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!--Row-->
				<div class="row row-sm">
					<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 grid-margin">
						<div class="card"> 
							<div class="card-body p-2"> 
								
								<form action="{{ route('products.index') }}" method="GET">
									<div class="input-group"> 
										<input type="text" name="s" class="form-control" placeholder="@lang('site.search in products')" value="{{ request()->s }}"> 
										<span class="input-group-append"> 
											<button class="btn btn-primary" type="button">@lang('site.Search')</button> 
										</span>
									</div>  
								</form>
								
							</div> 
						</div>

						<div class="card">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									<h4 class="card-title mg-b-0 mb-2">@lang('site.products')</h4>
									<i class="mdi mdi-dots-horizontal text-gray"></i>
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive border-top userlist-table">
									<table class="table card-table table-striped table-vcenter text-nowrap mb-0">
										<thead>
											<tr>
												<th class="wd-lg-8p"><span>#</span></th>
												<th class="wd-lg-8p"><span>@lang('site.product')</span></th>
												<th class="wd-lg-20p"><span></span></th>
												<th class="wd-lg-20p"><span>@lang('site.'.app()->getLocale().'.description')</span></th>
												<th class="wd-lg-20p"><span>@lang('site.category')</span></th>
												<th class="wd-lg-20p"><span>@lang('site.purchase price')</span></th>
												<th class="wd-lg-20p"><span>@lang('site.sale price')</span></th>
												<th class="wd-lg-20p"><span>@lang('site.profit percent')</span></th>
												<th class="wd-lg-20p"><span>@lang('site.stock')</span></th>
												<th class="wd-lg-20p">@lang('site.actions')</th>
											</tr>
										</thead>
										<tbody>
											@isset($products)
												@foreach ($products as $i=>$product)
													<tr>
														<td>{{ ++$i }}</td>
														<td><img class="rounded-circle avatar-md mr-2" src="{{ URL::asset($product->file_path) }}" alt=""></td>
														<td>{{ $product->product_name }}</td>
														<td>{{ $product->description }}</td>
														<td>{{ $product->category->name }}</td>
														<td>{{ $product->purchase_price }}</td>
														<td>{{ $product->sale_price }}</td>
														<td>{{ $product->profit_percent }}</td>
														<td>{{ $product->stock }}</td>
														<td>
															@if (auth()->user()->hasPermission('update_products'))
																<a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-info">
																	<i class="las la-pen"></i>
																</a>
															@else
																<a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-info disabled">
																	<i class="las la-pen"></i>
																</a>
															@endif

															@if (auth()->user()->hasPermission('delete_products'))
																<a href="{{ route('products.destroy',$product->id) }}" data-productid="{{ $product->id }}" class="btn btn-sm btn-danger delete_product">
																	<i class="las la-trash"></i>
																</a>
																<form class="edit_product_{{ $product->id }}" action="{{ route('products.destroy',$product->id) }}" method="post">
																	@csrf
																	@method('DELETE')
																</form>
															@else
																<a href="{{ route('products.destroy',$product->id) }}" data-productid="{{ $product->id }}" class="btn btn-sm btn-danger delete_product disabled">
																	<i class="las la-trash"></i>
																</a>
															@endif
														</td>
													</tr>
												@endforeach
											@endisset
										</tbody>
									</table>
									
								</div>
								{{ $products->appends(request()->query())->links('dashboard.pagination.limit_links') }}
							</div>
						</div>
					</div><!-- COL END -->
				</div>
				<!-- row closed  -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Datepicker js -->
<script src="{{URL::asset('dashboard/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!-- Internal Select2 js-->
<script src="{{URL::asset('dashboard/plugins/select2/js/select2.min.js')}}"></script>
<!--Internal  Notify js -->
<script src="{{URL::asset('dashboard/plugins/notify/js/notifIt.js')}}"></script>
<script>
	$('.delete_product').on('click', function(e){
		e.preventDefault();
		var dataID = $(this).data('productid');
		$('form.edit_product_'+dataID).submit();
	});
</script>
@include('dashboard\alerts\_success')
@endsection