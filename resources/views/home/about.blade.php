@extends('layouts.home')

@section('title', '{{ $view_name }}')

@section('content')
	<div class="team-boxed">
		<div class="container">
			<div class="intro">
				<h2 class="text-center">Team Smartsettia</h2>
				<p class="text-center">Nunc luctus in metus eget fringilla. Aliquam sed justo ligula. Vestibulum nibh erat, pellentesque ut laoreet vitae.</p>
			</div>
			<div class="row people">
				<div class="col-md-4 col-sm-6 item">
					<div class="box"><img class="img-circle" src="{{ asset('img/robert-320.jpg') }}">
						<h3 class="name">Robert Breckenridge</h3>
						<p class="title">COMPUTER SCIENCE</p>
						<p class="description">Aenean tortor est, vulputate quis leo in, vehicula rhoncus lacus. Praesent aliquam in tellus eu gravida. Aliquam varius finibus est, et interdum justo suscipit id. Etiam dictum feugiat tellus, a semper massa. </p>
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
						<p class="description">Aenean tortor est, vulputate quis leo in, vehicula rhoncus lacus. Praesent aliquam in tellus eu gravida. Aliquam varius finibus est, et interdum justo suscipit id. Etiam dictum feugiat tellus, a semper massa. </p>
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
				<p class="text-center">Nunc luctus in metus eget fringilla. Aliquam sed justo ligula. Vestibulum nibh erat, pellentesque ut laoreet vitae. </p>
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
