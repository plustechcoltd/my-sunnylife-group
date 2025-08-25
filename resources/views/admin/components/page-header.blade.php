<!-- Page header -->
<div class="page-header page-header-light shadow">
	<div class="page-header-content d-lg-flex">
		<div class="d-flex">
			<h4 class="page-title mb-0">
				{{$title}} - <span class="fw-normal">{{$subtitle}}</span>
			</h4>
		</div>
		{{ $button ?? '' }}
	</div>

	<div class="page-header-content d-lg-flex border-top">
		<div class="d-flex">
			<div class="breadcrumb py-2">
				<a href="{{ route('admin.dashboard') }}" class="breadcrumb-item"><i class="ph-house"></i></a>
				<a href="{{$subtitle_route ?? ''}}" class="breadcrumb-item">{{$subtitle}}</a>
				@if(empty($hide_title_breadcrumb))
					<span class="breadcrumb-item active">{{$title}}</span>
				@endif
			</div>
		</div>
	</div>

</div>
<!-- /page header -->
