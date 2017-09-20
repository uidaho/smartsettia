@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
	<section class="testimonials" style="margin-bottom: 0">
		<h2 class="text-center">Sixth Street Greenhouse</h2>
		<select class="form-control" name="site" id="site">
			<option value="-1">Change Site</option>
			@foreach($sites as $site)
				<option value="{{ $site->id }}">{{ $site->name }}</option>
			@endforeach
		</select>
		<blockquote style="margin-bottom: 0">
			<p><b>Location: </b>Green House #1</p>
			<select class="form-control" name="location" id="location">
				<option value="">Change Location</option>
				@foreach($locations as $location)
					<option value="{{ $location->id }}">{{ $location->name }}</option>
				@endforeach
			</select>
			<footer><b>Description: </b>Made up of 18 compartments covering 20,000 square feet.</footer>
		</blockquote>
	</section>

	<div class="container">
		<h3>{{ $default_device->name }}</h3>
		<i class="fa fa-thermometer-empty"></i> Temperature <span class="badge trialing-space">42 C</span>
		<i class="glyphicon glyphicon-tint"></i> Humidity <span class="badge trialing-space">42 %</span>
		<i class="glyphicon glyphicon-adjust"></i> Light <span class="badge trialing-space">42 cd</span>
		<hr>
		<div class="row product">
			<div class="col-md-6 text-center">
				<img class="border-simple img-responsive" src="{{ URL('image/device/1') }}" alt="Device Image" id="deviceImage">
				<br>
				<a class="no-style-link" href="{{ URL('image/device/1') }}" download="custom_name.jpg">
					<button class="btn btn-primary">Download Image</button>
				</a>
			</div>
			<div class="col-md-6">
				<div class="table-bordered">
					<table class="table table-striped table-responsive" style="margin-bottom: 0;">
						<tr>
							<th>Name</th>
							<th>Controls</th>
						</tr>
						@foreach ($devices as $device)
							<tr>
								<td>{{ $device->name }}</td>
								<td>
									<div class="btn-group" role="group">
										<button class="btn btn-primary btn-info" style="width: 80px !important;" type="button" id="secondaryButton" onclick="playPause()"><i class='glyphicon glyphicon-resize-small'></i> Close</button>
										<button class="btn btn-primary" type="button"><i class="glyphicon glyphicon-lock"></i> Disable/Lock</button>
										<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#demo1"><i class="fa fa-line-chart" aria-hidden="true"></i> Graphs</button>
									</div>
								</td>
							</tr>
							<tr class="collapse" id="demo1">
								<td colspan="2">
									<div>
										<ul class="nav nav-tabs">
											<li class="active"><a href="#tab-11" role="tab" data-toggle="tab"><i class="fa fa-thermometer-empty"></i> Temp <span class="badge">42 C</span></a></li>
											<li><a href="#tab-22" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-tint"></i> RH <span class="badge">42 %</span></a></li>
											<li><a href="#tab-33" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-adjust"></i> Light <span class="badge">42 cd</span></a></li>
										</ul>
										<div class="tab-content">
											<div class="tab-pane active" role="tabpanel" id="tab-11">
												<p><img class="img-responsive" src="{{ asset('img/temp-graph.png') }}"></p>
											</div>
											<div class="tab-pane" role="tabpanel" id="tab-22">
												<p><img class="img-responsive" src="{{ asset('img/humidity-graph.png') }}"></p>
											</div>
											<div class="tab-pane" role="tabpanel" id="tab-33">
												<p><img class="img-responsive" src="{{ asset('img/light-graph.png') }}"></p>
											</div>
										</div>
									</div>
								</td>
							</tr>
						@endforeach
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="{{ asset('js/dash_image.js') }}"></script>
	<script src="{{ asset('js/dash.js') }}"></script>
@endsection
