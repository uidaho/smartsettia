@extends('layouts.home')

@section('title', 'About')

@section('content')
	<div class="team-boxed">
		<div class="container">
			<div class="intro">
				<h2 class="text-center">Team Smartsettia</h2>
				<p class="text-center">SmartSettia provides remote control and monitoring for the commercial production of poinsettias and other greenhouse plants using a web connected device. The system strategically controls timed covering and uncovering of poinsettias to control exposure to light, and allows for monitoring of other ambient properties.</p>
			</div>
			<div class="row people">
				<div class="col-md-4 col-sm-6 item">
					<div class="box"><img class="img-circle" src="{{ asset('img/robert-320.jpg') }}">
						<h3 class="name">Robert Breckenridge</h3>
						<p class="title">COMPUTER SCIENCE</p>
						<p class="description">I'm a senior Computer Science student at the University of Idaho. My main focus and interests are cyber security and databases. In my free time I like to work on side projects ranging from mobile app development to video game development.</p>
						<div class="social">
							<a href="#"><i class="fa fa-facebook-official"></i></a>
							<a href="#"><i class="fa fa-twitter"></i></a>
							<a href="#"><i class="fa fa-instagram"></i></a>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-6 item">
					<div class="box"><img class="img-circle" src="{{ asset('img/brandon-320.jpg') }}">
						<h3 class="name">Brandon Jank</h3>
						<p class="title">COMPUTER SCIENCE</p>
						<p class="description">I'm a senior Computer Science student at the University of Idaho in beautiful Moscow, Idaho. I have a passion for everything electronic. From the capacitor to the cloud, I have been designing and coding things for the web for over
							a decade. I enjoy volunteering my computer experience for local non-profits, tinkering with emerging technologies, mountain biking, snowmobiling, writing, and traveling.</p>
						<div class="social">
							<a href="#"><i class="fa fa-facebook-official"></i></a>
							<a href="#"><i class="fa fa-twitter"></i></a>
							<a href="#"><i class="fa fa-instagram"></i></a>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-6 item">
					<div class="box"><img class="img-circle" src="{{ asset('img/nick-320.jpg') }}">
						<h3 class="name">Nick Krenowicz</h3>
						<p class="title">COMPUTER ENGINEERING</p>
						<p class="description">I’m a senior Computer Engineer student at the University of Idaho. I love creating systems through embedded microprocessors revolving around robotics, home automation and other gadgits. My latest hobbies involve robotics, 3d printing, and creating custom home automation devices. When I have the chance, I like to go, hiking, and mountain biking through mountain trails.</p>
						<div class="social">
							<a href="#"><i class="fa fa-facebook-official"></i></a>
							<a href="#"><i class="fa fa-twitter"></i></a>
							<a href="#"><i class="fa fa-instagram"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="photo-gallery">
		<div class="container">
			<div class="intro">
				<h2 class="text-center">Project Gallery</h2>
				<p class="text-center">Controlling poinsettia photo-period is essential in preparing them for a specific market date and final height. The Sixth Street Greenhouse has streetlights as well as internal lighting that invades the room where the poinsettias are stored. To mitigate the effect of this stray light, the students of the Plant & Soils Science Club have an automated poinsettia covering system (created in 2016) that opens at 8am and closes at 5pm. The problem is there is no feedback for if system is open or closed other than physically going on site and verify the unit is operating as it should. The covering system's schedule is hard coded so the system can't be used on other plants that have different photo-periods. Lastly the system can't be remotely controlled in case of an emergency.</p>
			</div>
			<div class="row photos">
				<div class="col-lg-3 col-md-4 col-sm-6 item">
					<a href="{{ asset('img/team.jpg') }}" data-lightbox="photos"><img class="img-responsive" src="{{ asset('img/team.jpg') }}"></a>
				</div>
				<div class="col-lg-3 col-md-4 col-sm-6 item">
					<a href="{{ asset('img/nick.jpg') }}" data-lightbox="photos"><img class="img-responsive" src="{{ asset('img/nick.jpg') }}"></a>
				</div>
				<div class="col-lg-3 col-md-4 col-sm-6 item">
					<a href="{{ asset('img/robert.jpg') }}" data-lightbox="photos"><img class="img-responsive" src="{{ asset('img/robert.jpg') }}"></a>
				</div>
				<div class="col-lg-3 col-md-4 col-sm-6 item">
					<a href="{{ asset('img/system-drawing.png') }}" data-lightbox="photos"><img class="img-responsive" src="{{ asset('img/system-drawing.png') }}"></a>
				</div>
				<div class="col-lg-3 col-md-4 col-sm-6 item">
					<a href="{{ asset('img/system.png') }}" data-lightbox="photos"><img class="img-responsive" src="{{ asset('img/system.png') }}"></a>
				</div>
				<div class="col-lg-3 col-md-4 col-sm-6 item">
					<a href="{{ asset('img/poinsettias.jpg') }}" data-lightbox="photos"><img class="img-responsive" src="{{ asset('img/poinsettias.jpg') }}"></a>
				</div>
			</div>
		</div>
	</div>
@endsection
