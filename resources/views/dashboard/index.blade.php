@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
	<section class="testimonials" style="margin-bottom: 0">
		<h2 class="text-center">Sixth Street Greenhouse</h2>
		<blockquote style="margin-bottom: 0">
			<p><b>Location: </b>Green House #1</p>
			<footer><b>Description: </b>Made up of 18 compartments covering 20,000 square feet.</footer>
		</blockquote>
	</section>
	<div class="container">
		<h3>Unit List Boxed</h3>
		<hr>
		<p>A list of all the units in a boxed view.</p>
		<div class="row product">
			<div class="col-md-6 text-center">
				<video id="video1" width=100%" height="auto">
					<source src="{{ asset('video/cover.mp4') }}" type="video/mp4">
					Your browser does not support HTML5 video.
				</video>
			</div>
			<div class="col-md-6">
				<h2 style="padding-top: 0; margin-top: 0;">Unit Alpha</h2>
				<p><i class="fa fa-id-card-o"></i> uid-1001 <i class="fa fa-address-card-o"></i> 66.123.129.12 <i class="fa fa-clock-o"></i> 2/27/2017 2:09 PM <i class="fa fa-thermometer-empty"></i> 47 C </p>
				<div>
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-1" role="tab" data-toggle="tab"><i class="fa fa-thermometer-empty"></i> Temperature <span class="badge">42 C</span></a></li>
						<li><a href="#tab-2" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-tint"></i> Humidity <span class="badge">42 %</span></a></li>
						<li><a href="#tab-3" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-adjust"></i> Light <span class="badge">42 cd</span></a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" role="tabpanel" id="tab-1">
							<p><img class="img-responsive" src="{{ asset('img/temp-graph.png') }}"></p>
						</div>
						<div class="tab-pane" role="tabpanel" id="tab-2">
							<p><img class="img-responsive" src="{{ asset('img/humidity-graph.png') }}"></p>
						</div>
						<div class="tab-pane" role="tabpanel" id="tab-3">
							<p><img class="img-responsive" src="{{ asset('img/light-graph.png') }}"></p>
						</div>
					</div>
				</div>
				<div class="btn-group" role="group">
					<button class="btn btn-primary btn-info" style="width: 80px !important;" type="button" id="mainButton" onclick="playPause()"><i class='glyphicon glyphicon-resize-small'></i> Close</button>
					<button class="btn btn-primary" type="button"><i class="glyphicon glyphicon-eye-open"></i> Screenshot</button>
					<button class="btn btn-primary" type="button"><i class="glyphicon glyphicon-user"></i> Permissions</button>
					<button class="btn btn-primary btn-warning" type="button"><i class="glyphicon glyphicon-lock"></i> Disable/Lock</button>
					<button class="btn btn-primary btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i> Delete</button>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="page-header">
			<h3>Unit List</h3>
		</div>
		<p>A list of all the units regardless of status. Possibly add filters and pagination.</p>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Status</th>
						<th>Controls</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>1 </td>
						<td><a href="{{ route('unit') }}">Alpha</a></td>
						<td><i class="glyphicon glyphicon-collapse-up"></i> OPEN</td>
						<td>
							<div class="btn-group" role="group">
								<button class="btn btn-primary btn-info" style="width: 80px !important;" type="button" id="secondaryButton" onclick="playPause()"><i class='glyphicon glyphicon-resize-small'></i> Close</button>
								<button class="btn btn-primary" type="button"><i class="glyphicon glyphicon-eye-open"></i> Screenshot</button>
								<button class="btn btn-primary" type="button"><i class="glyphicon glyphicon-lock"></i> Disable/Lock</button>
								<button class="btn btn-primary" type="button"><i class="glyphicon glyphicon-user"></i> Permissions</button>
								<button class="btn btn-primary" type="button"><i class="glyphicon glyphicon-remove"></i> Delete</button>
							</div>
						</td>
					</tr>
					<tr>
						<td>2</td>
						<td>Bravo</td>
						<td><i class="glyphicon glyphicon-collapse-down"></i> CLOSED</td>
						<td>
							<div class="btn-group" role="group">
								<button class="btn btn-primary btn-info" type="button"><i class="glyphicon glyphicon-resize-full"></i> </button>
								<button class="btn btn-primary btn-info" type="button"><i class="glyphicon glyphicon-resize-small"></i> </button>
								<button class="btn btn-primary" type="button"><i class="glyphicon glyphicon-eye-open"></i> </button>
								<button class="btn btn-primary" type="button"><i class="glyphicon glyphicon-user"></i> </button>
								<button class="btn btn-primary btn-warning" type="button"><i class="glyphicon glyphicon-lock"></i> </button>
								<button class="btn btn-primary btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i> </button>
							</div>
						</td>
					</tr>
					<tr>
						<td>3</td>
						<td>Charlie</td>
						<td><i class="glyphicon glyphicon-question-sign"></i> OFFLINE</td>
						<td></td>
					</tr>
					<tr>
						<td>4</td>
						<td>Delta</td>
						<td><i class="glyphicon glyphicon-ban-circle"></i> DISABLED</td>
						<td></td>
					</tr>
					<tr>
						<td>5</td>
						<td>Echo</td>
						<td><i class="glyphicon glyphicon-fire"></i> ERROR</td>
						<td></td>
					</tr>
					<tr>
						<td>6</td>
						<td>NEED SETUP</td>
						<td><i class="glyphicon glyphicon-cog"></i> SETUP</td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>



	<div class="container">
		<div class="page-header">
			<h3>Hybrid List</h3>
		</div>
		<p>A list of all the units regardless of status. Possibly add filters and pagination.</p>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Status</th>
						<th>Controls</th>
					</tr>
				</thead>
				<tbody>
					{{-- @foreach ($units as $unit) --}}
						<tr data-toggle="collapse" href="#collapse-1" aria-expanded="false" aria-controls="collapse-1">
							<td>1</td>
							<td><a href="{{ route('unit') }}">name</a></td>
							<td>status</td>
							<td>
								<div class="btn-group" role="group">
									<button class="btn btn-primary" type="button" data-toggle="collapse" href="#collapse-1" aria-expanded="false" aria-controls="collapse-1"><i class="glyphicon glyphicon-resize-small"></i></button>
									<button class="btn btn-primary btn-info" style="width: 80px !important;" type="button" id="secondaryButton" onclick="playPause()"><i class='glyphicon glyphicon-resize-small'></i> Close</button>
									<button class="btn btn-primary" type="button"><i class="glyphicon glyphicon-eye-open"></i> Screenshot</button>
									<button class="btn btn-primary" type="button"><i class="glyphicon glyphicon-lock"></i> Disable/Lock</button>
									<button class="btn btn-primary" type="button"><i class="glyphicon glyphicon-user"></i> Permissions</button>
									<button class="btn btn-primary" type="button"><i class="glyphicon glyphicon-remove"></i> Delete</button>
								</div>
							</td>
						</tr>
						<tr class="collapse" id="collapse-1">
							<td colspan="4">
								<div class="row product">
									<div class="col-md-6">
										<video id="video1" width=100%" height="auto">
											<source src="{{ asset('video/cover.mp4') }}" type="video/mp4">
											Your browser does not support HTML5 video.
										</video>
									</div>
									<div class="col-md-6">
										<h2>Unit Alpha</h2>
										<p><i class="fa fa-id-card-o"></i> uid-1001 <i class="fa fa-address-card-o"></i> 66.123.129.12 <i class="fa fa-clock-o"></i> 2/27/2017 2:09 PM <i class="fa fa-thermometer-empty"></i> 47 C </p>
										<div>
											<ul class="nav nav-tabs">
												<li class="active"><a href="#tab-1" role="tab" data-toggle="tab"><i class="fa fa-thermometer-empty"></i> Temperature <span class="badge">42 C</span></a></li>
												<li><a href="#tab-2" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-tint"></i> Humidity <span class="badge">42 %</span></a></li>
												<li><a href="#tab-3" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-adjust"></i> Light <span class="badge">42 cd</span></a></li>
											</ul>
											<div class="tab-content">
												<div class="tab-pane active" role="tabpanel" id="tab-1">
													<p><img class="img-responsive" src="{{ asset('img/temp-graph.png') }}"></p>
												</div>
												<div class="tab-pane" role="tabpanel" id="tab-2">
													<p><img class="img-responsive" src="{{ asset('img/humidity-graph.png') }}"></p>
												</div>
												<div class="tab-pane" role="tabpanel" id="tab-3">
													<p><img class="img-responsive" src="{{ asset('img/light-graph.png') }}"></p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</td>
						</tr>
					{{-- @endforeach --}}
				</tbody>
			</table>
		</div>
	</div>

	<div class="container">
		<h3>Unit 1</h3>
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
						{{-- @foreach ($units as $unit) --}}
						<tr>
							<td>Unit 1</td>
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
						{{-- @endforeach --}}
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection
