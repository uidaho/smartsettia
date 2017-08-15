@extends('layouts.home')

@section('title', 'Help')

@section('content')
	<div class="article-list">
		<div class="container">
			<div class="intro">
				<h2 class="text-center">Help Articles</h2>
				<p class="text-center">Nunc luctus in metus eget fringilla. Aliquam sed justo ligula. Vestibulum nibh erat, pellentesque ut laoreet vitae. </p>
			</div>
			<div class="row articles">
				<div class="col-md-4 col-sm-6 item">
					<a href="#"><img class="img-responsive" src="{{ asset('img/desk.jpg') }}"></a>
					<h3 class="name">Article Title</h3>
					<p class="description">Aenean tortor est, vulputate quis leo in, vehicula rhoncus lacus. Praesent aliquam in tellus eu gravida. Aliquam varius finibus est, interdum justo suscipit id.</p><a href="#" class="action"><i class="glyphicon glyphicon-circle-arrow-right"></i></a></div>
				<div
						class="col-md-4 col-sm-6 item">
					<a href="#"><img class="img-responsive" src="{{ asset('img/desk.jpg') }}"></a>
					<h3 class="name">Article Title</h3>
					<p class="description">Aenean tortor est, vulputate quis leo in, vehicula rhoncus lacus. Praesent aliquam in tellus eu gravida. Aliquam varius finibus est, interdum justo suscipit id.</p><a href="#" class="action"><i class="glyphicon glyphicon-circle-arrow-right"></i></a></div>
				<div
						class="col-md-4 col-sm-6 item">
					<a href="#"><img class="img-responsive" src="{{ asset('img/desk.jpg') }}"></a>
					<h3 class="name">Article Title</h3>
					<p class="description">Aenean tortor est, vulputate quis leo in, vehicula rhoncus lacus. Praesent aliquam in tellus eu gravida. Aliquam varius finibus est, interdum justo suscipit id.</p><a href="#" class="action"><i class="glyphicon glyphicon-circle-arrow-right"></i></a></div>
			</div>
		</div>
	</div>
@endsection
