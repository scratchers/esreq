<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name') }}</title>
	<link rel="icon" href="/favicon.ico" type="image/x-icon"/>

	<link rel='stylesheet' href='https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'></link>
    <link rel='stylesheet' href='//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css'></link>
	<link rel='stylesheet' href='/css/uark.css'></link>

	<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
</head>
<body>
	<div id="header-bg"></div>
	<div class="container" id="opener" role="banner">
		<a class="brand" href="http://www.uark.edu/">University of Arkansas</a>
		<span id="site-heading" class="walton-name"><a href="/">Request Enterprise Systems</a></span>
		<span class="walton-sub-name"><a href="//walton.uark.edu">The Sam M. Walton College of Business</a></span>
	</div><!-- /#opener banner -->

	<nav class="navbar navbar-default">
		<div class="container">
			<div class="navbar-header">
				<!-- Top Nav Toggle -->
				<button id='n' type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a id='site_title_brand' class='navbar-brand' href='/'></a>
			</div><!-- /.navbar-header -->

			<div id="navbar" class="collapse navbar-collapse">
				<ul id='top_navigation_menu' class='top_nav nav navbar-nav navigation-menu'>
					@if (Auth::guest())
						<li><a href="{{ url('/register') }}">Register</a></li>
					@else
						<li><a href="{{ url('/home') }}">Home</a></li>
						<li><a href="{{ url('/create') }}">Create Request</a></li>
					@endif
                    <li><a href="{{ url('/instructions') }}">Instructions</a></li>
				</ul>

				<div id='login_nav_div' class='top_nav navbar-right pull-right-md pull-left-xs'>
					<ul class="nav navbar-nav navbar-right navigation-menu">
						<!-- Authentication Links -->
						@if (Auth::guest())
							<li><a href="{{ url('/login') }}">Login</a></li>
						@else
							<li>
								<a href="{{ url('/logout') }}"
									onclick="event.preventDefault();
											document.getElementById('logout-form').submit();">
									Logout {{ Auth::user()->first_name }}
								</a>

								<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
									{{ csrf_field() }}
								</form>
							</li>
						@endif
					</ul>
				</div>
			</div><!--/#navbar.nav-collapse -->
		</div><!--/.container -->
	</nav>

	<div id="page-content-container" class='container'>

        @include('flash::message')

		@yield('content')

	</div>

	<section class="gray" id="section-footer" style="padding: 10px 0px 20px 0px;">
		<div class="container">
			<div class="row" style="padding-top: 30px;">
				<div class="col-sm-7">
					<div id='footer-walton-name'>
						<a href="http://walton.uark.edu">Sam M. Walton College of Business</a>
					</div>

					<p style="margin-bottom: 35px; padding: 20px;">
						<span style="display:inline-block;">
							<a style="color: #b7b7b7" title=”facebook” href="https://www.facebook.com/WaltonCollege">
								<i class="fa fa-3x fa-facebook-square"><!-- content --></i>
							</a>
							<a style="color: #b7b7b7" title="twitter" href="https://twitter.com/uawaltoncollege">
								<i class="fa fa-3x fa-twitter-square"><!-- content --></i>
							</a>
							<a style="color: #b7b7b7" title="Linkedin" href="https://www.linkedin.com/grp/home?gid=108950">
								<i class="fa fa-3x fa-fa fa-linkedin-square"><!-- content --></i>
							</a>
							<a style="color: #b7b7b7" title="instagram" href="https://instagram.com/uawaltoncollege/">
								<i class="fa fa-3x fa-instagram"><!-- content --></i>
							</a>
						</span>
					</p>
				</div>

				<div class="col-sm-5">
					<div class="row">
						<div class="col-md-8 hidden-xs visible-sm visible-md visible-lg">
							<a href="http://walton.uark.edu">
								<img alt="Sam M. Walton College of Business at the University of Arkansas" src="/images/WaltonLogo2.png" class="img-responsive">
							</a>
						</div>

						<div class="col-md-4 hidden-xs hidden-sm visible-md visible-lg">
							<a href="http://accredited.aacsb.edu/students">
								<img alt="AACSB Accredited" src="/images/aacsb-large.png" width="120px" class="img-responsive" style="filter: alpha(opacity=30); opacity: 0.3">
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<footer>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div id="footer-logo">
						<a href="http://uark.edu">UNIVERSITY OF ARKANSAS</a>
					</div>

					<ul id="footer-global-links" class="list-unstyled">
						<li><a href="http://www.uark.edu/admissions/index.php">Admissions</a></li>
						<li><a href="http://www.uark.edu/academics/index.php">Academics</a></li>
						<li><a href="http://www.uark.edu/campus-life/index.php">Campus Life</a></li>
						<li><a href="http://www.uark.edu/research/index.php">Research</a></li>
						<li><a href="http://www.uark.edu/athletics/index.php">Athletics</a></li>
						<li><a href="http://www.uark.edu/about/index.php">About</a></li>
					</ul>

					<ul id="social-stack" class="nav clearfix list-unstyled">
						<li>
							<a href="https://www.facebook.com/UofArkansas">
								<i class="fa fa-facebook"></i>
								<span class="sr-only">Like us on Facebook</span>
							</a>
						</li>
						<li>
							<a href="http://twitter.com/uarkansas">
								<i class="fa fa-twitter"></i>
								<span class="sr-only">Follow us on Twitter</span>
							</a>
						</li>
						<li>
							<a href="http://www.youtube.com/user/UniversityArkansas">
								<i class="fa fa-youtube"></i>
								<span class="sr-only">Watch us on YouTube</span>
							</a>
						</li>
						<li>
							<a href="http://instagram.com/uarkansas">
								<i class="fa fa-instagram"></i>
								<span class="sr-only">See us on Instagram</span>
							</a>
						</li>
						<li>
							<a href="https://plus.google.com/104159281704656057709" rel="publisher">
								<i class="fa fa-google-plus"></i>
								<span class="sr-only">Connect with us on Google+</span>
							</a>
						</li>	
						<li>
							<a href="http://pinterest.com/uofaadmissions/">
								<i class="fa fa-pinterest"></i>
								<span class="sr-only">Join us on Pinterest</span>
							</a>
						</li>
						<li>
							<a href="http://www.linkedin.com/company/university-of-arkansas">
								<i class="fa fa-linkedin"></i>
								<span class="sr-only">Connect with us on LinkedIn</span>
							</a>
						</li>
						<li>
							<a href="https://foursquare.com/uarkansas">
								<i class="fa fa-foursquare"></i>
								<span class="sr-only">Find us on FourSquare</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</footer>

	<script   src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"   integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="   crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src='https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js'></script>
		<script src='https://oss.maxcdn.com/respond/1.4.2/respond.min.js'></script>
	<![endif]-->
    <script src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>

	<script>
		window.Laravel = <?php echo json_encode([
			'csrfToken' => csrf_token(),
		]); ?>

		function auto_expand_textarea( ta ){ ta.keyup(function(e) {
			while($(this).outerHeight() < this.scrollHeight + parseFloat($(this).css('borderTopWidth')) + parseFloat($(this).css('borderBottomWidth'))) {
				$(this).height($(this).height()+1);
			};
		})}

		$(function(){
			$('textarea').each(function(){
				var ta = $(this);
				auto_expand_textarea( ta );
			});
		});

		$(".top_nav").find("a").each(function(){
			if ( $(this).attr("href") == "<?php echo $_SERVER['SCRIPT_NAME'];?>" || $(this).attr("href") == "<?php echo dirname($_SERVER['SCRIPT_NAME'])."/";?>" )
			$(this).parent().addClass("active");
		});

        $(document).ready(function(){
            $('.datatable').DataTable({
                "order": [[ 1, "desc" ]]
            });
        });
	</script>
</body>
</html>
