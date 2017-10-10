@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
	<section class="testimonials" style="margin-bottom: 0">
		<div class="text-center">
			<h2 style="display: inline-block" id="header_site">{{ $active_device[2]->name }}</h2>
			<div style="display: inline-block">
				<div class="btn-group">
					<button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" id="btn_change_site">
						Change <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" id="site_change">
						@foreach($sites as $site)
							<li class="empty site" value="{{ $site->id }}"><a>{{ $site->name }}</a></li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
		<blockquote style="margin-bottom: 0">
			<p style="display: inline-block" id="header_location"><b>Location: </b>{{ $active_device[1]->name }}</p>
			<div class="btn-group" style="display: inline-block">
				<button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" id="btn_change_loc">
					Change <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" id="location_change">
					@foreach($locations as $location)
						<li class="empty location" value="{{ $location->id }}"><a>{{ $location->name }}</a></li>
					@endforeach
				</ul>
			</div>
		</blockquote>
	</section>
	<div class="container">
		<div class="row" style="display: flex; align-items: center; position: relative;">
			<div class="col-md-4 col-md-offset-4">

			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<h3 id="header_device">{{ $active_device[0]->name }}</h3>
				<p><span class="trialing-space" id="span_open_time"><b>Open Time: </b>{{ $active_device[0]->open_time }}</span> <span class="trialing-space" id="span_close_time"><b>Close Time: </b>{{ $active_device[0]->close_time }}</span></p>
				<i class="fa fa-thermometer-empty"></i> Temperature <span class="badge trialing-space" id="temperature">{{ $active_device[0]->temperature }}C</span>
				<i class="glyphicon glyphicon-tint"></i> Humidity <span class="badge trialing-space" id="humidity">{{ $active_device[0]->humidity }}%</span>
				<i class="glyphicon glyphicon-adjust"></i> Light <span class="badge trialing-space" id="light">{{ $active_device[0]->light_in }}%</span>
				<i class="fa fa-empire" aria-hidden="true"></i> CPU Temp <span class="badge trialing-space" id="cpu_temp">{{ $active_device[0]->cpu_temp }}C</span>
				<hr>
			</div>
		</div>
		<div class="row product">
			<div class="col-md-6 text-center relative">
				<div class="alert alert-warning alert-dismissible alert-image-stale" role="alert" id="alert_image" hidden>
					<button type="button" class="close" aria-label="Close" onclick="hideImageAlert()"><span aria-hidden="true">&times;</span></button>
					<strong>Warning!</strong> Image is over 10 mins old.
				</div>
				<!-- Triggers the Image Modal -->
				<input class="border-simple img-responsive" type="image" src="{{ URL('image/device') . '/' . $active_device[0]->id }}" alt="Device Image" id="deviceImage" data-toggle="modal" data-target="#image_modal"/>
				<br>
				<a class="no-style-link" href="{{ URL('image/device') . '/' . $active_device[0]->id }}" download="custom_name.jpg" id="download_image_link">
					<button class="btn btn-primary">Download Image</button>
				</a>
			</div>
			<div class="col-md-6">
				<div class="table-bordered" style="max-height: 400px; overflow:auto;">
					<table class="table table-striped table-responsive" style="margin-bottom: 0;" id="device_table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Controls</th>
							</tr>
						</thead>
						<tbody>
						@foreach ($devices as $device)
							<tr id="tr_{{ $device->id }}">
								<td>{{ $device->name }}</td>
								<td>
									<div class="btn-group btn-group-sm" role="group" style="display: block">
										<button class="btn btn-primary" type="button" onclick="changeDevice(this);" id="btn_view_{{ $device->id }}"><i class="fa fa-video-camera"></i> View</button>
										<button class="btn btn-primary" type="button"><i class='glyphicon glyphicon-resize-small'></i> Close</button>
										<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#graph_row_{{ $device->id }}" disabled><i class="fa fa-line-chart"></i> Graphs</button>
										<button class="btn btn-primary" type="button" onclick="updateDeviceCommand(this);" id="btn_lock_{{ $device->id }}" value="3"><i class="fa fa-lock" aria-hidden="true"></i> Lock</button>
										<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#editDeviceModal" onclick="updateDeviceModal(this);" id="btn_edit_{{ $device->id }}"><i class="glyphicon glyphicon-edit"></i> Edit</button>
									</div>
								</td>
							</tr>
							<tr class="collapse" id="graph_row_{{ $device->id }}">
								<td colspan="2">
									<div>
										<ul class="nav nav-tabs">
											<li class="active"><a href="#tab_1_{{ $device->id }}" role="tab" data-toggle="tab"><i class="fa fa-thermometer-empty"></i> Temp <span class="badge">{{ $device->temperture }}C</span></a></li>
											<li><a href="#tab_2_{{ $device->id }}" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-tint"></i> RH <span class="badge">{{ $device->humidity }}%</span></a></li>
											<li><a href="#tab_3_{{ $device->id }}" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-adjust"></i> Light <span class="badge">{{ $device->light_in }}%</span></a></li>
										</ul>
										<div class="tab-content">
											<div class="tab-pane active" role="tabpanel" id="tab_1_{{ $device->id }}">
												<p><img class="img-responsive" src="{{ asset('img/temp-graph.png') }}"></p>
											</div>
											<div class="tab-pane" role="tabpanel" id="tab_2_{{ $device->id }}">
												<p><img class="img-responsive" src="{{ asset('img/humidity-graph.png') }}"></p>
											</div>
											<div class="tab-pane" role="tabpanel" id="tab_3_{{ $device->id }}">
												<p><img class="img-responsive" src="{{ asset('img/light-graph.png') }}"></p>
											</div>
										</div>
									</div>
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>


	<!-- Hidden buttons -->
	<button class="hidden" value="{{ $active_device[2]->id }}" id="active_site_id"></button>
	<button class="hidden" value="{{ $active_device[1]->id }}" id="active_location_id"></button>
	<button class="hidden" value="{{ $active_device[0]->id }}" id="active_device_id"></button>
	<button class="hidden" value="{{ url('/') }}" id="website_base_url"></button>

	@include('dashboard.edit_modal')
	@include('dashboard.image_modal')
@endsection

@section('scripts')
	<script src="{{ asset('js/dashboard/update_page.js') }}"></script>
	<script src="{{ asset('js/dashboard/update_image.js') }}"></script>
	<script src="{{ asset('js/dashboard/update_sensors.js') }}"></script>
	<script src="{{ asset('js/dashboard/change_active_device.js') }}"></script>
	<script src="{{ asset('js/dashboard/change_site_loc.js') }}"></script>
	<script src="{{ asset('js/dashboard/change_modal_edit.js') }}"></script>
	<script src="{{ asset('js/dashboard/change_modal_edit.js') }}"></script>
	<script src="{{ asset('js/dashboard/control_device.js') }}"></script>
	<script src="{{ asset('js/device_edit.js') }}"></script>
@endsection
