<!-- Page header -->
<div class="page-header page-header-shadow">
	<div class="page-header-content d-flex {{ getContainerClass($settings) }}">
		<div class="page-title">
			<div class="d-inline-flex align-items-center">
				<h5 class="mb-0">{{ $title }}</h5>
			</div>
			<span class="page-subtitle d-inline-block align-text-bottom text-muted">{{ $subtitle }}</span>
		</div>

		{{ $button ?? '' }}
	</div>
</div>
<!-- /page header -->