@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
	<section class="testimonials" style="margin-bottom: 0">
		<div class="text-center">
			<h2 style="display: inline-block" id="header_site">{{ $default_device->site_name }}</h2>
			<div style="display: inline-block">
				<div class="btn-group">
					<button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Change <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" id="site_change">
						@foreach($sites as $site)
							<li value="{{ $site->id }}"><a>{{ $site->name }}</a></li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
		<blockquote style="margin-bottom: 0">
			<p style="display: inline-block" id="header_location"><b>Location: </b>{{ $default_device->location_name }}</p>
			<div class="btn-group" style="display: inline-block">
				<button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Change <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" id="location_change">
					@foreach($locations as $location)
						<li value="{{ $location->id }}"><a>{{ $location->name }}</a></li>
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
			<h3 id="header_device">{{ $default_device->name }}</h3>
			<i class="fa fa-thermometer-empty"></i> Temperature <span class="badge trialing-space" id="temperature">{{ $default_device->temperature }}C</span>
			<i class="glyphicon glyphicon-tint"></i> Humidity <span class="badge trialing-space" id="humidity">{{ $default_device->humidity }}%</span>
			<i class="glyphicon glyphicon-adjust"></i> Light <span class="badge trialing-space" id="light">{{ $default_device->light_in }}%</span>
			<hr>
		</div>
		<div class="row product">
			<div class="col-md-6 text-center">
				<img class="border-simple img-responsive" src="{{ URL('image/device') . '/' . $default_device->id }}" alt="Device Image" id="deviceImage">
				<br>
				<a class="no-style-link" href="{{ URL('image/device/1') }}" download="custom_name.jpg">
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
									<div class="btn-group" role="group">
										<button class="btn btn-primary" type="button" onclick="changeDevice(this);" id="btn_view_{{ $device->id }}"><i class="fa fa-video-camera"></i> View</button>
										<button class="btn btn-primary btn-info" type="button"><i class='glyphicon glyphicon-resize-small'></i> Close</button>
										<button class="btn btn-success" type="button" data-toggle="collapse" data-target="#graph_row_{{ $device->id }}"><i class="fa fa-line-chart"></i> Graphs</button>
										<button class="btn btn-warning" type="button"><i class="glyphicon glyphicon-lock"></i> Disable</button>
										<button class="btn btn-danger" type="button" data-toggle="modal" data-target="#editDeviceModal" onclick="updateDeviceModal(this);" id="btn_edit_{{ $device->id }}"><i class="glyphicon glyphicon-edit"></i> Edit</button>
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

	@include('dashboard.edit_modal')
@endsection

@section('scripts')
	<script src="{{ asset('js/dash_image.js') }}"></script>
	<script src="{{ asset('js/dash.js') }}"></script>
@endsection
