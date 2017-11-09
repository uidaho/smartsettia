@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<!-- Alert Success -->
				<div class="alert alert-success alert-dismissible" role="alert" id="alert_success_bar" hidden>
					<button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<div id="success_bar_text"></div>
				</div>
				<!-- Alert Failure -->
				<div class="alert alert-danger alert-dismissible" role="alert" id="alert_failure_bar" hidden>
					<button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<div id="failure_bar_text"></div>
				</div>
				<section class="testimonials" style="margin-bottom: 0; margin-top: 10px">
					<div class="text-center">
						<h2 style="display: inline-block" id="header_site">{{ $active_data['site']->name ?? 'No Sites' }}</h2>
						<div style="display: inline-block">
							<div class="btn-group">
								<button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" id="btn_change_site" @if($sites->count() <= 1) style="display: none;" @endif>
									Change <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" id="site_change">
									@foreach($sites as $site)
										<li data-site-id="{{ $site->id }}"><a>{{ $site->name }}</a></li>
									@endforeach
								</ul>
							</div>
						</div>
					</div>
					<blockquote style="margin-bottom: 0">
						<p style="display: inline-block" id="header_location"><b>Location: </b>{{ $active_data['location']->name ?? 'No Locations' }}</p>
						<div class="btn-group" style="display: inline-block">
							<button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" id="btn_change_loc" @if($locations->count() <= 1) style="display: none;" @endif>
								Change <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" id="location_change">
								@foreach($locations as $location)
									<li data-location-id="{{ $location->id }}"><a>{{ $location->name }}</a></li>
								@endforeach
							</ul>
						</div>
					</blockquote>
				</section>
			</div>
		</div>
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<h3 id="header_device">{{ $active_data['device']->name ?? 'No Devices' }}</h3>
				<p>
					<span class="trialing-space" id="span_open_time"><b>Open Time: </b>{{ $active_data['device']->open_time ?? '8:00am' }}</span>
					<span class="trialing-space" id="span_close_time"><b>Close Time: </b>{{ $active_data['device']->close_time ?? '5:00pm' }}</span>
				</p>
				<hr>
			</div>
		</div>
		<div class="row">
			<div class="col-md-5 col-md-offset-1 text-center relative">
				<!-- Image alert bar -->
				<div class="alert alert-warning alert-dismissible alert-image-stale" role="alert" id="alert_stale_image_bar" hidden>
					<button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<div id="image_stale_bar_text"></div>
				</div>
				<!-- Triggers the Image Modal -->
				<input class="border-simple img-responsive center-block" type="image" src="{{ URL('image/device') . '/' . ($active_data['device']->id ?? 0) }}" alt="Device Image" id="deviceImage" data-toggle="modal" data-target="#image_modal"/>
				<br>
				<a class="no-style-link" href="{{ URL('image/device') . '/' . ($active_data['device']->id ?? '-1') }}" download="custom_name.jpg" id="download_image_link">
					<button class="btn btn-primary">Download Image</button>
				</a>
			</div>
			<div class="col-md-5" id="device_table_holder">
				@include('dashboard.device_list')
			</div>
		</div>
	</div>

	<!-- Hidden buttons -->
	<button class="hidden" value="{{ $active_data['site']->id ?? 0 }}" id="active_site_id"></button>
	<button class="hidden" value="{{ $active_data['location']->id ?? 0 }}" id="active_location_id"></button>
	<button class="hidden" value="{{ $active_data['device']->id ?? 0 }}" id="active_device_id"></button>
	<button class="hidden" value="{{ $devices->currentPage() ?? 0 }}" id="active_device_table_page"></button>

	@include('dashboard.edit_modal')
	@include('dashboard.image_modal')
@endsection

@section('scripts')
	<script src="{{ asset('js/dashboard/update_page.js') }}"></script>
	<script src="{{ asset('js/dashboard/update_image.js') }}"></script>
	<script src="{{ asset('js/dashboard/update_sensors.js') }}"></script>
	<script src="{{ asset('js/dashboard/change_modal_edit.js') }}"></script>
	<script src="{{ asset('js/dashboard/control_device.js') }}"></script>
	<script src="{{ asset('js/device_edit.js') }}"></script>
@endsection
