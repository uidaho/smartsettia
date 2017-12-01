@extends('layouts.home')

@section('title', 'Help')

@section('content')
	<div class="article-list">
		<div class="container">
			<div class="intro">
				<h2 class="text-center">Help Guides</h2>
			</div>
			<div class="row articles">
				<div class="col-md-4 col-sm-6 item">
					<a href="https://github.com/uidaho/smartsettia/wiki/Website:-User's-Guide"><img class="img-responsive" src="{{ asset('img/help1.jpg') }}"></a>
					<h3 class="name">User's Guide</h3>
					<p class="description">
						If you just plan on using the system to monitor the greenhouse, you'll want to check out the User's Guide for helpful website usage information.
					</p><a href="https://github.com/uidaho/smartsettia/wiki/Website:-User's-Guide" class="action"><i class="glyphicon glyphicon-circle-arrow-right"></i></a>
				</div>
				<div class="col-md-4 col-sm-6 item">
					<a href="https://github.com/uidaho/smartsettia/wiki/Website:-Manager's-Guide"><img class="img-responsive" src="{{ asset('img/help2.jpg') }}"></a>
					<h3 class="name">Manager's Guide</h3>
					<p class="description">
						If you are a manager and would like to know more about managing users, devices, and their data, see the Manager's Guide.
					</p><a href="https://github.com/uidaho/smartsettia/wiki/Website:-Manager's-Guide" class="action"><i class="glyphicon glyphicon-circle-arrow-right"></i></a></div>
				<div class="col-md-4 col-sm-6 item">
					<a href="https://github.com/uidaho/smartsettia/wiki"><img class="img-responsive" src="{{ asset('img/help3.jpg') }}"></a>
					<h3 class="name">More Help</h3>
					<p class="description">
						Find guides and articles ranging from installation, error handling, API, and more on our wiki page located on github.
					</p><a href="https://github.com/uidaho/smartsettia/wiki" class="action"><i class="glyphicon glyphicon-circle-arrow-right"></i></a>
				</div>
			</div>
		</div>
	</div>
@endsection
