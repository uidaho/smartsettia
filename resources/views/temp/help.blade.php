@extends('temp.layouts.main')

@section('head')
	<title>Landing Page</title>
@endsection

@section('mainBody')
	<div class="article-list">
		<div class="container">
			<div class="intro">
				<h2 class="text-center">Help Articles</h2>
				<p class="text-center">Nunc luctus in metus eget fringilla. Aliquam sed justo ligula. Vestibulum nibh erat, pellentesque ut laoreet vitae. </p>
			</div>
			<div class="row articles">
				<div class="col-md-4 col-sm-6 item">
					<a href="#"><img class="img-responsive" src="/img/desk.jpg"></a>
					<h3 class="name">Article Title</h3>
					<p class="description">Aenean tortor est, vulputate quis leo in, vehicula rhoncus lacus. Praesent aliquam in tellus eu gravida. Aliquam varius finibus est, interdum justo suscipit id.</p><a href="#" class="action"><i class="glyphicon glyphicon-circle-arrow-right"></i></a></div>
				<div
						class="col-md-4 col-sm-6 item">
					<a href="#"><img class="img-responsive" src="/img/desk.jpg"></a>
					<h3 class="name">Article Title</h3>
					<p class="description">Aenean tortor est, vulputate quis leo in, vehicula rhoncus lacus. Praesent aliquam in tellus eu gravida. Aliquam varius finibus est, interdum justo suscipit id.</p><a href="#" class="action"><i class="glyphicon glyphicon-circle-arrow-right"></i></a></div>
				<div
						class="col-md-4 col-sm-6 item">
					<a href="#"><img class="img-responsive" src="/img/desk.jpg"></a>
					<h3 class="name">Article Title</h3>
					<p class="description">Aenean tortor est, vulputate quis leo in, vehicula rhoncus lacus. Praesent aliquam in tellus eu gravida. Aliquam varius finibus est, interdum justo suscipit id.</p><a href="#" class="action"><i class="glyphicon glyphicon-circle-arrow-right"></i></a></div>
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
