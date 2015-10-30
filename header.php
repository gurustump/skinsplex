<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7 skinsplex"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 skinsplex"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 skinsplex"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js skinsplex"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<?php // force Internet Explorer to use the latest rendering engine available ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<title><?php wp_title(''); ?></title>

		<?php // mobile meta (hooray!) ?>
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1"/>

		<?php // icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) ?>
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-touch-icon.png">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->
		<?php // or, set /favicon.ico for IE10 win ?>
		<meta name="msapplication-TileColor" content="#f01d4f">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">
            <meta name="theme-color" content="#121212">

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<?php // wordpress head functions ?>
		<?php wp_head(); ?>
		<?php // end of wordpress head ?>

		<?php // Google Analytics ?>
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-69443986-1', 'auto');
			ga('send', 'pageview');

		</script>
		<?php // end analytics ?>

	</head>
	
	
	<?php 
		$extraClasses = '';
		if (is_user_logged_in()) {
			$currentUser = wp_get_current_user();
			/*echo '<pre style="padding-top:65px;">';
			print_r($currentUser->roles[0]);
			echo '</pre>';*/
			$extraClasses .= $currentUser->roles[0] == 'subscriber' ? 'hide-admin-bar' : '';
		} 
	?>
	<body <?php body_class($extraClasses); ?> itemscope itemtype="http://schema.org/WebPage">

		<div id="container">

			<header class="header full-wrap" role="banner" itemscope itemtype="http://schema.org/WPHeader">

				<div id="inner-header" class="wrap cf">

					<?php // to use a image just replace the bloginfo('name') with your img src and remove the surrounding <p> ?>
					<p id="logo" class="h1" itemscope itemtype="http://schema.org/Organization"><a href="<?php echo home_url(); ?>" rel="nofollow"><?php bloginfo('name'); ?><span class="subhead"><?php bloginfo('description'); ?></span></a></p>
					<a href="#" class="trigger-nav TRIGGER_NAV">
						<span class="ic">
							<span class="bar-1"></span>
							<span class="bar-2"></span>
							<span class="bar-3"></span>
						</span>
					</a>
					<?php // if you'd like to use the site description you can un-comment it below ?>
					<?php // bloginfo('description'); ?>


					<nav role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement" class="MAIN_NAV main-nav">
						<?php 
						/*$mainMenuId = null;
						$menus = get_terms('nav_menu');
						foreach($menus as $menu) {
							if ($menu->slug == 'main-menu') {
								$mainMenuId = $menu->term_id;
								break;
							}
						};*/
						wp_nav_menu(array(
							'container' => false,                           // remove nav container
							'container_class' => 'menu',                 // class of container (should you choose to use it)
							'menu' => __( 'The Main Menu', 'bonestheme' ),  // nav name
							'menu_class' => 'nav top-nav',               // adding custom nav class
							'theme_location' => 'main-nav',                 // where it's located in the theme
							'before' => '',                                 // before the menu
							'after' => '',                                  // after the menu
							'link_before' => '',                            // before each link
							'link_after' => '',                             // after each link
							'depth' => 0,                                   // limit the depth of the nav
							'fallback_cb' => ''                             // fallback function (if there is one)
						)); 
						?>

					</nav>
					<form class="login-form top-nav-hidden-form TOP_NAV_LOGIN_FORM OV" id="login" action="login" method="post">
						<h2>Sign in to <?php bloginfo('name'); ?></h2>
						<p class="status"></p>
						<input id="username" type="text" name="username" placeholder="Username">
						<input id="password" type="password" name="password" placeholder="Password">
						<div class="alt-links">
							<a class="forgotten-password" href="<?php echo wp_lostpassword_url(); ?>"><span>Forgot your password?</span></a>
							<?php if (get_option('users_can_register')) { ?>
							<span>- or -</span>
							<a class="register-new" href="<?php bloginfo('wpurl'); ?>/wp-login.php?action=register"><span>Register for a new account</span></a>
						<?php } ?>
						</div>
						<button class="submit_button btn" type="submit" name="submit">Login</button>
						<a class="btn-close OV_CLOSE" href="">Close</a>
						<?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
					</form>
					<div class="top-nav-hidden-form TOP_NAV_LOGOUT_FORM OV">
						<div class="section">
							<h2>My Account</h2>
							<a class="btn" href="<?php bloginfo('wpurl'); ?>/wp-admin/profile.php">Edit my Profile</a>
						</div>
						<form class="logout-form" id="logout" action="logout" method="post">
							<p class="status"></p>
							<button class="submit_button btn" type="submit" name="submit">Logout</button>
							<a class="btn-close OV_CLOSE" href="">Cancel</a>
						</form>
					</div>
					<?php get_search_form(true); ?>
				</div>

			</header>
