@extends('temp.layouts.main2')

@section('head')
	<title>Landing Page</title>

	<nav class="navbar navbar-default">
		<div class="container">
			<div class="navbar-header"><a class="navbar-brand navbar-link" href="/"><i class="glyphicon glyphicon-grain"></i>SmartSettia</a>
				<button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
			</div>
			<div class="collapse navbar-collapse" id="navcol-1">
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="#"> <img src="/img/avatar.jpg" class="dropdown-image">jvandal<span class="caret"></span></a>
						<ul class="dropdown-menu dropdown-menu-right" role="menu">
							<li role="presentation"><a href="/user-settings">Settings </a></li>
							<li role="presentation"><a href="/user-notifications">Notifications </a></li>
							<li role="presentation" class="active"><a href="/">Logout (jvandal) </a></li>
						</ul>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="active" role="presentation"><a href="/dashboard">Dashboard </a></li>
					<li role="presentation"><a href="/help">Help </a></li>
					<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="/">Admin <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li role="presentation"><a href="#">Manage Users </a></li>
							<li role="presentation"><a href="#">Manage Groups </a></li>
							<li role="presentation"><a href="#">Manage Units </a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</nav>
@endsection

@section('mainBody')
	<ol class="breadcrumb">
		<li><a><span>Dashboard </span></a></li>
		<li><a><span>Unit </span></a></li>
		<li><a><span>Alpha (uid-1001)</span></a></li>
	</ol>
	<section class="testimonials">
		<h2 class="text-center">Unit View</h2>
		<blockquote>
			<p>This view shows all information about a particular unit.</p>
			<footer>TODO </footer>
		</blockquote>
	</section>
	<div class="container">
		<div class="row product">
			<div class="col-md-6">

				<video id="video1" width=100%" height="auto">
					<source src="/video/cover.mp4" type="video/mp4">
					Your browser does not support HTML5 video.
				</video>

			</div>
			<div class="col-md-6">
				<h2>Unit Alpha</h2>
				<p><i class="fa fa-id-card-o"></i> uid-1001 <i class="fa fa-address-card-o"></i> 66.123.129.12 <i class="fa fa-clock-o"></i> 2/27/2017 2:09 PM <i class="fa fa-thermometer-empty"></i> 47 C </p>
                <textarea rows="5" style="width:100%" placeholder="Type your notes about this unit here..."
						  name="unit_notes"></textarea>
				<h3>Temp: 30 C</h3>
				<div class="btn-group" role="group">
					<button class="btn btn-primary btn-info" style="width: 80px !important;" type="button" id="mainButton" onclick="playPause()"><i class='glyphicon glyphicon-resize-small'></i> Close</button>
					<button class="btn btn-primary" type="button"><i class="glyphicon glyphicon-eye-open"></i> Screenshot</button>
					<button class="btn btn-primary" type="button"><i class="glyphicon glyphicon-lock"></i> Disable/Lock</button>
					<button class="btn btn-primary" type="button"><i class="glyphicon glyphicon-user"></i> Permissions</button>
					<button class="btn btn-primary" type="button"><i class="glyphicon glyphicon-remove"></i> Delete</button>
				</div>
			</div>
		</div>
		<div class="page-header">
			<h3>Unit Details</h3></div>
		<p>Sed mollis, urna eu tempus facilisis, diam tellus aliquam tortor, et vestibulum ante quam non justo. Nullam luctus rutrum mattis. Maecenas in pharetra mi, vel mollis odio. Morbi non mauris massa. </p>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
				<tr>
					<th>ID </th>
					<th>Sensor </th>
					<th>Min</th>
					<th>Max </th>
					<th>Average </th>
					<th>Current </th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td>1 </td>
					<td>Temperature </td>
					<td>10 C</td>
					<td>50 C</td>
					<td>30 C</td>
					<td>30 C</td>
				</tr>
				<tr>
					<td>2 </td>
					<td>Humidity </td>
					<td>20% </td>
					<td>100% </td>
					<td>50% </td>
					<td>50% </td>
				</tr>
				<tr>
					<td>3 </td>
					<td>Soil Moisture </td>
					<td>0% </td>
					<td>50% </td>
					<td>15% </td>
					<td>15% </td>
				</tr>
				<tr>
					<td>4 </td>
					<td>Light </td>
					<td>0 cd/m2</td>
					<td>10 cd/m2</td>
					<td>10 cd/m2</td>
					<td>10 cd/m2</td>
				</tr>
				</tbody>
			</table>
		</div>
		<div class="page-header">
			<h3>Notes </h3></div>
		<div class="media">
			<div class="media-body">
				<h4>Temperature looks high!</h4>
				<p><span class="reviewer-name"><strong>John Doe</strong></span><span class="review-date">7 Oct 2017</span></p>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis maximus nisl ac diam feugiat, non vestibulum libero posuere. Vivamus pharetra leo non nulla egestas, nec malesuada orci finibus. </p>
			</div>
		</div>
		<div class="media">
			<div class="media-body">
				<h4>New install.</h4>
				<p><span class="reviewer-name"><strong>Jane Doe</strong></span><span class="review-date">7 Oct 2015</span></p>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis maximus nisl ac diam feugiat, non vestibulum libero posuere. Vivamus pharetra leo non nulla egestas, nec malesuada orci finibus. </p>
				<form>
					<div class="form-group">
						<input class="form-control" type="text" placeholder="Subject">
						<textarea class="form-control" placeholder="Type your message in here." rows="5"></textarea>
					</div>
				</form>
				<button class="btn btn-primary write-review" type="button">Write a note</button>
			</div>
		</div>
	</div>
@endsection

@section('footer')
	<div class="site-footer">
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<h5>SmartSettia © 2017</h5></div>
				<div class="col-sm-6 social-icons">
					<a href="#"><i class="fa fa-facebook"></i></a>
					<a href="#"><i class="fa fa-twitter"></i></a>
					<a href="/dashboard"><i class="fa fa-instagram" href="/dashboard.html"></i></a>
				</div>
			</div>
		</div>
	</div>

	<script>
		var myVideo = document.getElementById("video1");
		var myButton = document.getElementById("mainButton");
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
				myButton.innerHTML = "<i class='glyphicon glyphicon-resize-full'></i> " + currentType;
			}
			else if(Math.floor(myVideo.currentTime) == 37){
				//clearInterval(interval);
				myVideo.pause();
				myVideo.currentTime = 0;
				var temp = currentType;
				currentType = lastType;
				lastType = temp;
				myButton.innerHTML = "<i class='glyphicon glyphicon-resize-full'></i> " + currentType;
			}
		}

		//Detect video finished
		/*document.getElementById('video1').addEventListener('ended', openFinished, false);
		 function openFinished(e)
		 {
		 myButton.innerHTML = "<i class='glyphicon glyphicon-resize-full'></i> " + currentType;
		 }*/

		//Play and pause commands
		function playPause()
		{
			if (myVideo.paused)
			{
				myVideo.play();
				myButton.innerHTML = "<i class='glyphicon glyphicon glyphicon-stop'></i> Stop";
			}
			else
			{
				myVideo.pause();
				myButton.innerHTML = "<i class='glyphicon glyphicon-resize-small'></i> " + currentType;
			}
		}
	</script>
@endsection
