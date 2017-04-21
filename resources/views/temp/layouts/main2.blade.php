<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Your poinsettia management system.">
		<!-- -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lora">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
			  integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
			  crossorigin="anonymous">
		<!-- Custom CSS -->
		<link rel="stylesheet" href="/css/Article-Dual-Column.css">
		<link rel="stylesheet" href="/css/Article-List.css">
		<link rel="stylesheet" href="/css/header.css">
		<link rel="stylesheet" href="/css/user.css">
		<link rel="stylesheet" href="/css/Lightbox-Gallery.css">
		<link rel="stylesheet" href="/css/register.css">
		<link rel="stylesheet" href="/css/Team-Boxed.css">
		<!-- jQuery Library Ajax -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"
				integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7"
				crossorigin="anonymous"></script>
		<!-- Bootstrap Javascript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
				integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
				crossorigin="anonymous"></script>

		@yield('head')
	</head>

	<body>
		<header>
			<!-- Navbar -->
			@include('temp.layouts.nav.main2')

		</header>

		<main>

			<!-- CONTENT -->
			@yield('mainBody')

		</main>

		<footer>

			@yield('footer')

		</footer>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script>
	</body>
</html>
