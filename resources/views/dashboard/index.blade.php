@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<section class="testimonials">
	<h2 class="text-center">Dashboard</h2>
	<blockquote>
		<p>Graphs and cool eye candy for the overal status of the system here.</p>
		<footer>TODO</footer>
	</blockquote>
</section>
<div class="container">
	<div class="page-header">
		<h3>Unit List Boxed</h3>
	</div>
	<p>A list of all the units in a boxed view.</p>
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
							</div>
						</td>
					</tr>
				{{-- @endforeach --}}
			</tbody>
		</table>
	</div>
</div>
@endsection

@section('footer')
<script type="text/javascript">
	var myVideo = document.getElementById("video1");
	var mainButton = document.getElementById("mainButton");
	var secondaryButton = document.getElementById("secondaryButton");
	var currentType = "Close";
	var lastType = "Open";

	//Detect time of video
	var interval = setInterval(checkTime, 100);
	function checkTime()
	{
		if(Math.floor(myVideo.currentTime) == 18){
			//clearInterval(interval);
			myVideo.pause();
			myVideo.currentTime = 19;
			var temp = currentType;
			currentType = lastType;
			lastType = temp;
			mainButton.innerHTML = "<i class='glyphicon glyphicon-resize-full'></i> " + currentType;
			secondaryButton.innerHTML = "<i class='glyphicon glyphicon-resize-full'></i> " + currentType;
		}
		else if(Math.floor(myVideo.currentTime) == 37){
			//clearInterval(interval);
			myVideo.pause();
			myVideo.currentTime = 0;
			var temp = currentType;
			currentType = lastType;
			lastType = temp;
			mainButton.innerHTML = "<i class='glyphicon glyphicon-resize-full'></i> " + currentType;
			secondaryButton.innerHTML = "<i class='glyphicon glyphicon-resize-full'></i> " + currentType;
		}
	}

	// Detect video finished
	//document.getElementById('video1').addEventListener('ended', openFinished, false);
	function openFinished(e)
	{
		mainButton.innerHTML = "<i class='glyphicon glyphicon-resize-full'></i> " + currentType;
	}

	//Play and pause commands
	function playPause()
	{
		if (myVideo.paused)
		{
			myVideo.play();
			mainButton.innerHTML = "<i class='glyphicon glyphicon glyphicon-stop'></i> Stop";
			secondaryButton.innerHTML = "<i class='glyphicon glyphicon glyphicon-stop'></i> Stop";
		}
		else
		{
			myVideo.pause();
			mainButton.innerHTML = "<i class='glyphicon glyphicon-resize-small'></i> " + currentType;
			secondaryButton.innerHTML = "<i class='glyphicon glyphicon-resize-small'></i> " + currentType;
		}
	}
</script>
@endsection
