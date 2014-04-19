<?php
header("Content-Type: text/html; charset=utf-8");
session_start();
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
   	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>MarkdownPages</title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width">

		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-responsive.min.css">
		<link rel="stylesheet" href="css/main.css">

		<script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
	</head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

		<div class="container">
			<div class="header">
				<h3 class="text-muted">MarkdownPages</h3>
			</div>

			<div class="row">
				<div class="col-md-12">
					<hr/>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<form class="form-signin">
						<h2 class="form-signin-heading">Login</h2>
						<input type="password" id='password' name="password" class="form-control" placeholder="Password" required autofocus>
						<p>Password: demo</p>
						<button class="btn btn-lg btn-primary btn-block" type="submit" data-bind="click: doLogin">
							OK
						</button>
						<p class="text-center">
							<span data-bind="text: info, css: {'text-success': statusCode() > 0, 'text-danger': statusCode() < 0}"></span>
						</p>
					</form>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<hr/>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<span>&copy; unicate.ch</span>
				</div>
			</div>

		</div>
		<!-- /container -->

		<script src='js/vendor/knockout-3.0.0.js'></script>
		
   		<script src="js/vendor/jquery-1.9.1.min.js"></script>

		<script src="js/vendor/bootstrap.min.js"></script>

		<script src="js/login.js"></script>
    </body>
</html>
