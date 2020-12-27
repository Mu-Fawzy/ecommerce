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
							<h4 class="content-title mb-0 my-auto">@lang('site.users')</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ @lang('site.all users')</span>
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
								<h4 class="card-title mb-1">@lang('site.create') @lang('site.new user')</h4>
								<p class="mb-2">@lang('site.create') @lang('site.new user')</p>
							</div>
							<div class="card-body pt-0">
								<form class="form-horizontal" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
									@csrf
									<div class="form-group">
										<input type="text" class="form-control" name="first_name" placeholder="@lang('site.first name')" value="{{ old('first_name') }}">
									</div>
									<div class="form-group">
										<input type="text" class="form-control" name="last_name" placeholder="@lang('site.last name')" value="{{ old('last_name') }}">
									</div>
									<div class="form-group">
										<input type="email" class="form-control" name="email" placeholder="@lang('site.email')" value="{{ old('email') }}">
									</div>
									<div class="form-group">
										<input type="password" class="form-control" name="password" placeholder="@lang('site.password')">
									</div>
									<div class="form-group">
										<input type="password" class="form-control" name="password_confirmation" placeholder="@lang('site.password confirm')">
									</div>
									<div class="form-group">
										<div class="row mb-4">
											<div class="col-sm-12 col-md-12 mg-t-10 mg-sm-t-0">
												<input type="file" class="dropify" name="photo" data-height="200"  />
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="panel panel-primary tabs-style-1">
											<div class=" tab-menu-heading">
												<div class="tabs-menu1">
													@php
														$models = ['users','categories','products'];
														$permissions = ['create','read','update','delete'];
													@endphp
													<ul class="nav panel-tabs main-nav-line">
														@foreach ($models as $i=>$model)
															<li class="nav-item"><a href="#{{ $model }}" class="nav-link {{ $i == 0 ? 'active' : '' }}" data-toggle="tab">@lang('site.'.$model)</a></li>
														@endforeach
													</ul>
												</div>
											</div>
											<div class="panel-body tabs-menu-body main-content-body-right border-top-0 border">
												<div class="tab-content">
													@foreach ($models as $i=>$model)
													<div class="tab-pane {{ $i == 0 ? 'active' : '' }}" id="{{ $model }}">
														<div class="parsley-checkbox">
															@foreach ($permissions as $permission)
																<label class="ckbox mg-b-5">
																	<input name="permissions[]" type="checkbox" value="{{ $permission }}_{{ $model }}">
																	<span>@lang('site.'.$permission)</span>
																</label>
															@endforeach
															
														</div>
													</div>
													@endforeach
												</div>
											</div>
										</div>
									</div>
									<div class="form-group mb-0 mt-3 justify-content-end">
										<div>
											<button type="submit" class="btn btn-primary">@lang('site.create') @lang('site.new user')</button>
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