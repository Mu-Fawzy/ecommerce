@extends('layouts.dashboard.master')
@section('css')
<!-- Internal Select2 css -->
<link href="{{URL::asset('dashboard/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!---Internal Fileupload css-->
<link href="{{URL::asset('dashboard/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css"/>
<!--Internal  Datetimepicker-slider css -->
<link href="{{URL::asset('dashboard/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css')}}" rel="stylesheet">
<link href="{{URL::asset('dashboard/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css')}}" rel="stylesheet">
<link href="{{URL::asset('dashboard/plugins/pickerjs/picker.min.css')}}" rel="stylesheet">
<!-- Internal Spectrum-colorpicker css -->
<link href="{{URL::asset('dashboard/plugins/spectrum-colorpicker/spectrum.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">@lang('site.products')</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ $product->product_name }}</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				@include('dashboard.alerts._errors')
				<!-- row -->
				<div class="row row-sm">
					<div class="col-md-12 col-sm-12">
						<div class="card  box-shadow-0">
							<div class="card-header">
								<h4 class="card-title mb-2">@lang('site.edit') {{ $product->product_name }}</h4>
							</div>
							<div class="card-body pt-0">

								<form class="form-horizontal" action="{{ route('products.update' , $product->id) }}" method="POST" enctype="multipart/form-data">
									@csrf
									@method('PUT')

									@isset($categories)
										<div class="form-group">
											<select class="form-control select2" name="category_id">
												<option label="Choose one"></option>
												@foreach ($categories as $category)
													<option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
												@endforeach
											</select>
										</div>
									@endisset

									@foreach (config('translatable.locales') as $i=>$locale)
									<div class="form-group">
										<input type="text" class="form-control" name="{{ $locale }}[product_name]" placeholder="@lang('site.'.$locale.'.prduct name')" value="{{ $product->translate($locale)->product_name }}">
									</div>
									
									<div class="form-group">
										<textarea class="form-control" name="{{ $locale }}[description]" rows="3" placeholder="@lang('site.'.$locale.'.description')">{{ $product->translate($locale)->description }}</textarea>
									</div>
									@endforeach
									<div class="form-group">
										<div class="row mb-4">
											<div class="col-sm-12 col-md-12 mg-t-10 mg-sm-t-0">
												<input type="file" class="dropify" name="photo" data-default-file="{{URL::asset($product->file_path)}}" data-height="200" />
											</div>
										</div>
									</div>
									<div class="form-group">
										<input type="number" step="0.01" class="form-control" name="purchase_price" placeholder="@lang('site.purchase price')" value="{{ $product->purchase_price }}">
									</div>
									<div class="form-group">
										<input type="number" step="0.01" class="form-control" name="sale_price" placeholder="@lang('site.sale price')" value="{{ $product->sale_price }}">
									</div>
									<div class="form-group">
										<input type="number" class="form-control" name="stock" placeholder="@lang('site.stock')" value="{{ $product->stock }}">
									</div>
									
									<div class="form-group mb-0 mt-3 justify-content-end">
										<div>
											<button type="submit" class="btn btn-primary">@lang('site.update') @lang('site.product')</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- row -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Datepicker js -->
<script src="{{URL::asset('dashboard/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!--Internal  jquery.maskedinput js -->
<script src="{{URL::asset('dashboard/plugins/jquery.maskedinput/jquery.maskedinput.js')}}"></script>
<!--Internal  spectrum-colorpicker js -->
<script src="{{URL::asset('dashboard/plugins/spectrum-colorpicker/spectrum.js')}}"></script>
<!-- Internal Select2.min js -->
<script src="{{URL::asset('dashboard/plugins/select2/js/select2.min.js')}}"></script>
<!--Internal Ion.rangeSlider.min js -->
<script src="{{URL::asset('dashboard/plugins/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>
<!--Internal  jquery-simple-datetimepicker js -->
<script src="{{URL::asset('dashboard/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js')}}"></script>
<!-- Ionicons js -->
<script src="{{URL::asset('dashboard/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js')}}"></script>
<!--Internal  pickerjs js -->
<script src="{{URL::asset('dashboard/plugins/pickerjs/picker.min.js')}}"></script>
<!--Internal Fileuploads js-->
<script>
	$lang_click = "@lang('site.Drag and drop a file here or click')";
	$lang_replace = "@lang('site.Drag and drop or click to replace')";
	$lang_remove = "@lang('site.Remove')";
	$lang_appended = "@lang('site.Ooops, something wrong appended.')";
	$lang_size = "@lang('site.The file size is too big (2M max).')";
</script>
<script src="{{URL::asset('dashboard/plugins/fileuploads/js/fileupload.js')}}"></script>
<script src="{{URL::asset('dashboard/plugins/fileuploads/js/file-upload.js')}}"></script>
<!-- Internal form-elements js -->
<script src="{{URL::asset('dashboard/js/form-elements.js')}}"></script>
@endsection