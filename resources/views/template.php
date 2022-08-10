<!doctype html>
<html>
	<head>
		<!-- 
			Oh. Well hello there. Welcome, friendly peruser of HTML. Stay a while. Look around. If you get stuck, feel free
			to contact me, the web developer who wrote this code, and I'll see what I can do to help you. My name is 
			Chris Silich. My website is http://www.chrissilich.com and my email address is cs@chrissilich.com			
	 	-->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta charset="utf-8">
		
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		<link rel="icon" type="image/png" href="<?php echo url("assets/img/favicon.png");?>" />

		<title>
			<?php if (isset($titles) && is_array($titles)): ?>
				<?php foreach ($titles as $t): ?>
					<?php echo $t;?> - 	
				<?php endforeach; ?>
			<?php elseif (isset($titles) && is_string($titles)): ?>
				<?php echo $title;?> - 
			<?php endif; ?>
			Ringmaster
		</title>


		<?php

			function controllerMatch($str) {
				$contollerAndAction = request()->route()->getAction();
				$contollerAndAction = explode('\\', $contollerAndAction['controller'] );
				$contollerAndAction = end($contollerAndAction);
				if ($contollerAndAction == $str) return true;
				return false;
			}
			function echoActiveClass($str) {
				if (controllerMatch($str)) echo 'active';
			}

			
			if (Request::segment(1)) {
				$controller_name = Request::segment(1);
			} else {
				$controller_name = "dashboard";
			}
		?>

		<meta name="csrf-token" content="<?php echo csrf_token();?>" />


		<!-- Bootstrap and Bootstrap Plugins -->
		<link href="<?php echo url("node_modules/bootstrap/dist/css/bootstrap.min.css");?>" rel="stylesheet">
		<link href="<?php echo url("node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css");?>" rel="stylesheet">
		<link href="<?php echo url("node_modules/bootstrap-timepicker/css/bootstrap-timepicker.css");?>" rel="stylesheet">

		<!-- CSS for other plugins -->
		<link rel="stylesheet" href="<?php echo url("node_modules/dropzone/dist/min/dropzone.min.css");?>">

		<link rel="stylesheet" href="<?php echo url("assets/css/template.css");?>">
		
		<link rel="stylesheet" href="<?php echo url("assets/css/".$controller_name.".css");?>">
		
		<!-- jQuery -->
		<script src="<?php echo url("node_modules/jquery/dist/jquery.min.js");?>"></script>

		<!-- jQuery Plugins -->
		<script src="<?php echo url("node_modules/jquery.cookie/jquery.cookie.js");?>"></script>
		
		<!-- File upload Dropzone plugin -->
		<script src="<?php echo url("node_modules/dropzone/dist/min/dropzone.min.js");?>"></script>
		
		<!-- Bootstrap -->
		<script src="<?php echo url("node_modules/bootstrap/dist/js/bootstrap.min.js");?>"></script>
		<script src="<?php echo url("node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js");?>"></script>
		<script src="<?php echo url("node_modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js");?>"></script>

		<!-- Ringmaster scripts -->
		<script src="<?php echo url("assets/js/utilities.js");?>"></script>
		<script src="<?php echo url("assets/js/template.js");?>"></script>
		<script src="<?php echo url("assets/js/".$controller_name.".js");?>"></script>
	</head>
	<body>
			

		<div id="navigation" class="navbar navbar-default navbar-fixed-top" unclass="navbar-fixed-top" role="navigation">
			<div id="nav" class="container-fluid">

				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo action('HomeController@index'); ?>">
						<img src="<?php echo url("assets/img/circus-ball.png");?>">
						Ringmaster <small><?php echo Config::get('ringmaster.version');?></small>
					</a>
				</div>

				<ul class="nav navbar-nav navbar-collapse collapse">
		            		        	
		        	<?php if (Auth::user() && Auth::user()->validated): ?>

		        		
						
						<li class="<?php echoActiveClass('HomeController@index'); ?>">
							<a href="<?php echo action('HomeController@index');?>">Dashboard</a>
						</li>
						

						<li>
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Classes <span class="caret"></span></a>
							<ul class="dropdown-menu">

								<?php 
								$classesImIn = array();
								$classesIRun = array();
								foreach (Auth::user()->classrooms as $c) {
									//echo $c;
									if ($c->is_admin()) {
										array_push($classesIRun, $c);
									} else {
										array_push($classesImIn, $c);
									}
								} ?>
								
								<li>&nbsp; <b>Classes I'm In</b></li>

								<?php 
									global $hidden_classes_in_nav;
									$hidden_classes_in_nav = 0;
									foreach ($classesImIn as $c) {
										if ($c->pivot->role == "member") {
											if (Carbon::parse($c->start_date)->lt(Carbon::now()) && Carbon::parse($c->end_date)->gt(Carbon::now()) ): ?>
												<li class="<?php echo (controllerMatch('ClassroomController@show') && Route::current()->parameters['class'] == $c->id)?"active":""; ?>">
													<a href="<?php echo action('ClassroomController@show', $c->id);?>">
														<?php echo $c->name;?>
													</a>
												</li>
											<?php else: 
												global $hidden_classes_in_nav;
												$hidden_classes_in_nav++;
											endif;
										}
									};
									if ($hidden_classes_in_nav):?>
										<li>
											<a href="<?php echo action('ClassroomController@index');?>">
												<em class="text-muted"><?php echo $hidden_classes_in_nav;?> classes hidden</em>
											</a>
										</li>
									<?php endif;
								?>
							

								
									
								<li class="divider"></li>

								<li>&nbsp; <b>Classes I'm Teaching</b></li>

								<?php 
									global $hidden_classes_in_nav;
									$hidden_classes_in_nav = 0;
									foreach ($classesIRun as $c) {
										if ($c->pivot->role == "creator" || $c->pivot->role == "admin") {
											if (Carbon::parse($c->start_date)->lt(Carbon::now()) && Carbon::parse($c->end_date)->gt(Carbon::now()) ): ?>
												<li class="<?php echo (controllerMatch('ClassroomController@show') && Route::current()->parameters['class'] == $c->id)?"active":""; ?>">
													<a href="<?php echo action('ClassroomController@show', $c->id);?>">
														<?php echo $c->name;?>
													</a>
												</li>
											<?php else: 
												global $hidden_classes_in_nav;
												$hidden_classes_in_nav++;
											endif;
										}
									};
									if ($hidden_classes_in_nav):?>
										<li>
											<a href="<?php echo action('ClassroomController@index');?>">
												<em class="text-muted"><?php echo $hidden_classes_in_nav;?> classes hidden</em>
											</a>
										</li>
									<?php endif;
								?>





								<li class="divider"></li>

								<?php if (Auth::user()->god()): ?>
									<li class="<?php echoActiveClass('ClassroomController@all'); ?>">
										<a href="<?php echo action('ClassroomController@all');?>">
											<span class="glyphicon glyphicon-fire"></span>
											All Classes (God Mode)
										</a>
									</li>

									
									<li class="divider"></li>
								<?php endif; ?>
								

								<li class="<?php echoActiveClass('ClassroomController@create'); ?>">
									<a class="ajax-modal" href="<?php echo action('ClassroomController@create');?>">
										<span class="glyphicon glyphicon-plus"></span>
										Create Class
									</a>
								</li>


								<li class="<?php echoActiveClass('ClassroomController@join'); ?>">
									<a class="ajax-modal" href="<?php echo action('ClassroomController@join');?>">
										<span class="glyphicon glyphicon-ok"></span>
										Join Class
									</a>
								</li>
							</ul>
						</li>



						<?php if (Auth::user()->god()): ?>
							<li>
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin <span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li class="<?php echoActiveClass('UserController@index'); ?>">
										<a href="<?php echo action('UserController@index');?>">
											Users
										</a>
									</li>
								</ul>
							</li>
						<?php endif; ?>
							
						
					<?php else: // end of logged in user ?>

						<?php // no links for logged out users? ?>

					<?php endif;?>

				</ul><!--/.navbar-collapse -->


				<ul class="nav navbar-nav navbar-right navbar-collapse collapse">

					<?php if (Auth::user()): ?>
						<li class="navbar-link navbar-right">
							<a href="<?php echo action('UserController@logout');?>">Logout</a>
						</li>
						<li class="navbar-link navbar-right">
							<a href="<?php echo action('UserController@show', Auth::user()->id);?>">Hello, <?php echo Auth::user()->prettyName();?></a>
						</li>
					<?php elseif (!isset($hide_login) || !$hide_login): ?>
						<?php echo View::make("user.login_header"); ?>
					<?php endif;?>

				</ul><!--/.navbar-collapse (right aligned one) -->
			</div>
			<?php if (false && isset($breadcrumbs)) {?>
				<div id="breadcrumbs" class="container-fluid">
					<?php echo $breadcrumbs;?>
				</div>
			<?php }?>
		</div>

		<?php echo $content;?>

		<div id="ajax-modals"></div>

		<script>
			var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
			(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
			g.src='//www.google-analytics.com/ga.js';
			s.parentNode.insertBefore(g,s)}(document,'script'));
		</script>


		<!--
		Current Route Name: <?php echo Route::currentRouteName();?>
		-->
	</body>
</html>