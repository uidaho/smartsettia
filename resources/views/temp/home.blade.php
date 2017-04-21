@extends('temp.layouts.main')

@section('head')
	<title>Home</title>
@endsection

@section('mainBody')
	<div class="jumbotron hero">
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-md-push-7 phone-preview">
					<div class="iphone-mockup"><img src="/img/iphone.svg" class="device">
						<div class="screen"></div>
					</div>
				</div>
				<div class="col-md-6 col-md-pull-3 get-it">
					<h1>Your Poinsettia Management System</h1>
					<p>SmartSettia is a poinsettia life-cycle management system that couples the flexibility of IoT
						devices with the power of the cloud. Control units can be securely installed and controlled
						anywhere with an internet connection.
					</p>
					<p>
						<a class="btn btn-primary btn-lg" role="button" href="#">
							<i class="fa fa-apple"></i>
							Available on the App Store
						</a>
						<a class="btn btn-success btn-lg" role="button" href="#">
							<i class="fa fa-google"></i> Available on Google Play
						</a>
					</p>
				</div>
			</div>
		</div>
	</div>
	<section class="testimonials">
		<h2 class="text-center">Plant People Love It!</h2>
		<blockquote>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
			<footer>Famous plant-human hybrid</footer>
		</blockquote>
	</section>
	<section class="features">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2>Fantastic Features</h2>
					<p>SmartSettia has all the features you would expect from a greenhouse management system and more.
						The interface focuses on keeping operatiors and administrators informed and in controllof all
						units in the greenhouse.
					</p>
				</div>
				<div class="col-md-6">
					<div class="row icon-features">
						<div class="col-xs-4 icon-feature"><i class="glyphicon glyphicon-edit"></i>
							<p>Web Interface </p>
						</div>
						<div class="col-xs-4 icon-feature"><i class="glyphicon glyphicon-tower"></i>
							<p>Access Control</p>
						</div>
						<div class="col-xs-4 icon-feature"><i class="glyphicon glyphicon-cloud"></i>
							<p>Cloud Enabled </p>
						</div>
						<div class="col-xs-4 icon-feature"><i class="glyphicon glyphicon-dashboard"></i>
							<p>Live Dashboard </p>
						</div>
						<div class="col-xs-4 icon-feature"><i class="glyphicon glyphicon-facetime-video"></i>
							<p>Live Video</p>
						</div>
						<div class="col-xs-4 icon-feature"><i class="glyphicon glyphicon-refresh"></i>
							<p>Manual Control</p>
						</div>
						<div class="col-xs-4 icon-feature"><i class="glyphicon glyphicon-globe"></i>
							<p>Global Control</p>
						</div>
						<div class="col-xs-4 icon-feature"><i class="glyphicon glyphicon-time"></i>
							<p>Automatic Control</p>
						</div>
						<div class="col-xs-4 icon-feature"><i class="glyphicon glyphicon-phone"></i>
							<p>Mobile Support</p>
						</div>
						<div class="col-xs-4 icon-feature"><i class="glyphicon glyphicon-leaf"></i>
							<p>Life-cycle Stattistics</p>
						</div>
						<div class="col-xs-4 icon-feature"><i class="glyphicon glyphicon-floppy-disk"></i>
							<p>Export Your Data</p>
						</div>
						<div class="col-xs-4 icon-feature"><i class="glyphicon glyphicon-comment"></i>
							<p>Text Messaging</p>
						</div>
						<div class="col-xs-4 icon-feature"><i class="glyphicon glyphicon-list"></i>
							<p>Complete Logging</p>
						</div>
						<div class="col-xs-4 icon-feature"><i class="glyphicon glyphicon-bell"></i>
							<p>Fault Notifications</p>
						</div>
						<div class="col-xs-4 icon-feature"><i class="glyphicon glyphicon-calendar"></i>
							<p>Custom Scheduling</p>
						</div>
						<div class="col-xs-4 icon-feature"><i class="glyphicon glyphicon-tint"></i>
							<p>Moisture Sensors</p>
						</div>
						<div class="col-xs-4 icon-feature"><i class="glyphicon glyphicon-adjust"></i>
							<p>Light Sensors</p>
						</div>
						<div class="col-xs-4 icon-feature"><i class="glyphicon glyphicon-scale"></i>
							<p>Teperature Sensors</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
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
					<a href="/temp/dashboard"><i class="fa fa-instagram" href="/dashboard.html"></i></a>
				</div>
			</div>
		</div>
	</div>
@endsection
