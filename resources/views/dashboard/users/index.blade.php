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
							<h4 class="content-title mb-0 my-auto">@lang('site.all users')</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ @lang('site.users lists')</span>
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
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									<h4 class="card-title mg-b-0 mb-2">@lang('site.users lists')</h4>
									<i class="mdi mdi-dots-horizontal text-gray"></i>
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive border-top userlist-table">
									<table class="table card-table table-striped table-vcenter text-nowrap mb-0">
										<thead>
											<tr>
												<th class="wd-lg-8p"><span>@lang('site.user')</span></th>
												<th class="wd-lg-20p"><span></span></th>
												<th class="wd-lg-20p"><span>@lang('site.email')</span></th>
												<th class="wd-lg-20p"><span>@lang('site.created')</span></th>
												<th class="wd-lg-20p"><span>@lang('site.role')</span></th>
												<th class="wd-lg-20p">@lang('site.actions')</th>
											</tr>
										</thead>
										<tbody>
											@isset($users)
												@foreach ($users as $user)
													<tr>
														<td>
															<img alt="avatar" class="rounded-circle avatar-md mr-2" src="{{URL::asset($user->path_photo)}}">
														</td>
														<td>{{ $user->full_name }}</td>
														<td><a href="#">{{ $user->email }}</a></td>
														<td>{{ $user->created_at }}</td>
														<td> @foreach ($user->roles as $role) {{ $role->description }} @endforeach </td>
														<td>
															<a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-info">
																<i class="las la-pen"></i>
															</a>
															<a href="{{ route('users.destroy',$user->id) }}" data-userid="{{ $user->id }}" class="btn btn-sm btn-danger delete_user">
																<i class="las la-trash"></i>
															</a>
															<form class="edit_user_{{ $user->id }}" action="{{ route('users.destroy',$user->id) }}" method="post">
																@csrf
																@method('DELETE')
															</form>
														</td>
													</tr>
												@endforeach
											@endisset
										</tbody>
									</table>
									{{ $users->links() }}
								</div>
								<ul class="pagination mt-4 mb-0 float-left">
									<li class="page-item page-prev disabled">
										<a class="page-link" href="#" tabindex="-1">Prev</a>
									</li>
									<li class="page-item active"><a class="page-link" href="#">1</a></li>
									<li class="page-item"><a class="page-link" href="#">2</a></li>
									<li class="page-item"><a class="page-link" href="#">3</a></li>
									<li class="page-item"><a class="page-link" href="#">4</a></li>
									<li class="page-item"><a class="page-link" href="#">5</a></li>
									<li class="page-item page-next">
										<a class="page-link" href="#">Next</a>
									</li>
								</ul>
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
	$('.delete_user').on('click', function(e){
		e.preventDefault();
		var dataID = $(this).data('userid');
		$('form.edit_user_'+dataID).submit();
	});
</script>
@include('dashboard\alerts\_success')
@endsection