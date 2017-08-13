@extends('temp.layouts.main')

@section('head')
	<title>Login</title>

	<nav class="navbar navbar-default">
		<div class="container">
			<div class="navbar-header"><a class="navbar-brand navbar-link" href="/"><i
							class="glyphicon glyphicon-grain"></i>SmartSettia</a>
				<button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span
							class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span
							class="icon-bar"></span><span class="icon-bar"></span></button>
			</div>
			<div class="collapse navbar-collapse" id="navcol-1">
				<ul class="nav navbar-nav navbar-right">
					<li role="presentation"><a href="/">Home </a></li>
					<li role="presentation"><a href="/about">About </a></li>
					<li role="presentation"><a href="/help">Help </a></li>
					<li class="active" role="presentation"><a href="/login1">Log In</a></li>
				</ul>
			</div>
		</div>
	</nav>
@endsection

@section('mainBody')
	<div class="register-photo">
		<div class="form-container">
			<div class="image-holder"></div>
			<form method="post">
				<h2 class="text-center">Log in</h2>
				<div class="form-group">
					<input class="form-control" type="text" placeholder="Username or Email" name="username">
				</div>
				<div class="form-group">
					<input class="form-control" type="password" name="password" placeholder="Password">
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label">
							<input type="checkbox">Remember me on this computer</label>
					</div>
				</div>
				<div class="form-group">
					<button class="btn btn-primary btn-block" type="submit">Log In</button>
				</div><a href="/register1" class="already">Dont have an account? Click here.</a></form>
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
@endsection
