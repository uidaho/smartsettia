@extends('temp.layouts.main')

@section('head')
	<title>Landing Page</title>
@endsection

@section('mainBody')
	<div class="team-boxed">
		<div class="container">
			<div class="intro">
				<h2 class="text-center">Team Smartsettia</h2>
				<p class="text-center">Nunc luctus in metus eget fringilla. Aliquam sed justo ligula. Vestibulum nibh erat, pellentesque ut laoreet vitae.</p>
			</div>
			<div class="row people">
				<div class="col-md-4 col-sm-6 item">
					<div class="box"><img class="img-circle" src="/img/robert-320.jpg">
						<h3 class="name">Robert Breckenridge</h3>
						<p class="title">COMPUTER SCIENCE</p>
						<p class="description">Aenean tortor est, vulputate quis leo in, vehicula rhoncus lacus. Praesent aliquam in tellus eu gravida. Aliquam varius finibus est, et interdum justo suscipit id. Etiam dictum feugiat tellus, a semper massa. </p>
						<div class="social"><a href="#"><i class="fa fa-facebook-official"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-instagram"></i></a></div>
					</div>
				</div>
				<div class="col-md-4 col-sm-6 item">
					<div class="box"><img class="img-circle" src="/img/brandon-320.jpg">
						<h3 class="name">Brandon Jank</h3>
						<p class="title">COMPUTER SCIENCE</p>
						<p class="description">I'm a senior Computer Science student at the University of Idaho in beautiful Moscow, Idaho. I have a passion for everything electronic. From the capacitor to the cloud, I have been designing and coding things for the web for over
							a decade. I enjoy volunteering my computer experience for local non-profits, tinkering with emerging technologies, mountain biking, snowmobiling, writing, and traveling.</p>
						<div class="social"><a href="#"><i class="fa fa-facebook-official"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-instagram"></i></a></div>
					</div>
				</div>
				<div class="col-md-4 col-sm-6 item">
					<div class="box"><img class="img-circle" src="/img/nick-320.jpg">
						<h3 class="name">Nick Krenowicz</h3>
						<p class="title">COMPUTER ENGINEERING</p>
						<p class="description">Aenean tortor est, vulputate quis leo in, vehicula rhoncus lacus. Praesent aliquam in tellus eu gravida. Aliquam varius finibus est, et interdum justo suscipit id. Etiam dictum feugiat tellus, a semper massa. </p>
						<div class="social"><a href="#"><i class="fa fa-facebook-official"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-instagram"></i></a></div>
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
					<a href="assets/img/desk.jpg" data-lightbox="photos"><img class="img-responsive" src="/img/team.jpg"></a>
				</div>
				<div class="col-lg-3 col-md-4 col-sm-6 item">
					<a href="building.jpg" data-lightbox="photos"><img class="img-responsive" src="/img/nick.jpg"></a>
				</div>
				<div class="col-lg-3 col-md-4 col-sm-6 item">
					<a href="loft.jpg" data-lightbox="photos"><img class="img-responsive" src="/img/robert.jpg"></a>
				</div>
				<div class="col-lg-3 col-md-4 col-sm-6 item">
					<a href="building.jpg" data-lightbox="photos"><img class="img-responsive" src="/img/system-drawing.png"></a>
				</div>
				<div class="col-lg-3 col-md-4 col-sm-6 item">
					<a href="loft.jpg" data-lightbox="photos"><img class="img-responsive" src="/img/system.png"></a>
				</div>
				<div class="col-lg-3 col-md-4 col-sm-6 item">
					<a href="assets/img/desk.jpg" data-lightbox="photos"><img class="img-responsive" src="/img/poinsettias.jpg"></a>
				</div>
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
					<a href="/temp/dashboard"><i class="fa fa-instagram" href="/dashboard.html"></i></a>
				</div>
			</div>
		</div>
	</div>
@endsection
