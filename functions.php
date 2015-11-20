<?php
/*
Author: Eddie Machado
URL: http://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

// LOAD BONES CORE (if you remove this, the theme will break)
require_once( 'library/bones.php' );

// CUSTOMIZE THE WORDPRESS ADMIN (off by default)
require_once( 'library/admin.php' );

if (!is_admin()) {
	wp_register_style( 'owl-stylesheet', get_stylesheet_directory_uri() . '/library/css/owl.carousel.css', array(), '', 'all' );
	wp_register_script( 'owl-carousel', get_stylesheet_directory_uri() . '/library/js/libs/owl.carousel.js', array('jquery'), '2.0', false );
	wp_register_style( 'video-js-stylesheet', get_stylesheet_directory_uri() . '/library/css/video-js.min.css', array(), '', 'all' );
	wp_register_script( 'video-js', get_stylesheet_directory_uri() . '/library/js/libs/video.js', array('jquery'), '4.2', false );
	//wp_register_script( 'froogaloop', get_stylesheet_directory_uri() . '/library/js/libs/froogaloop.min.js', array('jquery'), '2', false ); // apparently this is already included in wordpress and I don't have to have it in our library
	wp_enqueue_style( 'owl-stylesheet' );
	wp_enqueue_script( 'owl-carousel' );
	wp_enqueue_style( 'video-js-stylesheet' );
	wp_enqueue_script( 'video-js' );
	wp_enqueue_script( 'froogaloop' );
}

/*********************
LAUNCH BONES
Let's get everything up and running.
*********************/

function bones_ahoy() {

  //Allow editor style.
  add_editor_style( get_stylesheet_directory_uri() . '/library/css/editor-style.css' );

  // let's get language support going, if you need it
  load_theme_textdomain( 'bonestheme', get_template_directory() . '/library/translation' );

  // USE THIS TEMPLATE TO CREATE CUSTOM POST TYPES EASILY
  require_once( 'library/custom-post-type.php' );

  // launching operation cleanup
  add_action( 'init', 'bones_head_cleanup' );
  // A better title
  add_filter( 'wp_title', 'rw_title', 10, 3 );
  // remove WP version from RSS
  add_filter( 'the_generator', 'bones_rss_version' );
  // remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'bones_remove_wp_widget_recent_comments_style', 1 );
  // clean up comment styles in the head
  add_action( 'wp_head', 'bones_remove_recent_comments_style', 1 );
  // clean up gallery output in wp
  add_filter( 'gallery_style', 'bones_gallery_style' );

  // enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'bones_scripts_and_styles', 999 );
  // ie conditional wrapper

  // launching this stuff after theme setup
  bones_theme_support();

  // adding sidebars to Wordpress (these are created in functions.php)
  add_action( 'widgets_init', 'bones_register_sidebars' );

  // cleaning up random code around images
  add_filter( 'the_content', 'bones_filter_ptags_on_images' );
  // cleaning up excerpt
  add_filter( 'excerpt_more', 'bones_excerpt_more' );

} /* end bones ahoy */

// let's get this party started
add_action( 'after_setup_theme', 'bones_ahoy' );


/************* OEMBED SIZE OPTIONS *************/

if ( ! isset( $content_width ) ) {
	$content_width = 640;
}

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'index-thumb', 160, 90, true );
add_image_size( 'index-banner', 1280, 512, true );
add_image_size( 'media-item-thumb', 320, 180, true );

/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 100 sized image,
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 150 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

add_filter( 'image_size_names_choose', 'bones_custom_image_sizes' );

function bones_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'index-thumb' => __('160px by 90px'),
        'index-banner' => __('1280px by 512px'),
        'media-item-thumb' => __('320px by 180px'),
    ) );
}

/*
The function above adds the ability to use the dropdown menu to select
the new images sizes you have just created from within the media manager
when you add media to your content blocks. If you add more image sizes,
duplicate one of the lines in the array and name it according to your
new image size.
*/

/************* THEME CUSTOMIZE *********************/

/* 
  A good tutorial for creating your own Sections, Controls and Settings:
  http://code.tutsplus.com/series/a-guide-to-the-wordpress-theme-customizer--wp-33722
  
  Good articles on modifying the default options:
  http://natko.com/changing-default-wordpress-theme-customization-api-sections/
  http://code.tutsplus.com/tutorials/digging-into-the-theme-customizer-components--wp-27162
  
  To do:
  - Create a js for the postmessage transport method
  - Create some sanitize functions to sanitize inputs
  - Create some boilerplate Sections, Controls and Settings
*/

function bones_theme_customizer($wp_customize) {
  // $wp_customize calls go here.
  //
  // Uncomment the below lines to remove the default customize sections 

  // $wp_customize->remove_section('title_tagline');
  // $wp_customize->remove_section('colors');
  // $wp_customize->remove_section('background_image');
  // $wp_customize->remove_section('static_front_page');
  // $wp_customize->remove_section('nav');

  // Uncomment the below lines to remove the default controls
  // $wp_customize->remove_control('blogdescription');
  
  // Uncomment the following to change the default section titles
  // $wp_customize->get_section('colors')->title = __( 'Theme Colors' );
  // $wp_customize->get_section('background_image')->title = __( 'Images' );
}

add_action( 'customize_register', 'bones_theme_customizer' );

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar1',
		'name' => __( 'Sidebar 1', 'bonestheme' ),
		'description' => __( 'The first (primary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	/*
	to add more sidebars or widgetized areas, just copy
	and edit the above sidebar code. In order to call
	your new sidebar just use the following code:

	Just change the name to whatever your new
	sidebar's id is, for example:

	register_sidebar(array(
		'id' => 'sidebar2',
		'name' => __( 'Sidebar 2', 'bonestheme' ),
		'description' => __( 'The second (secondary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	To call the sidebar in your template, you can just copy
	the sidebar.php file and rename it to your sidebar's name.
	So using the above example, it would be:
	sidebar-sidebar2.php

	*/
} // don't remove this bracket!


/************* COMMENT LAYOUT *********************/

// Comment Layout
function bones_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
  <div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
    <article  class="cf">
      <header class="comment-author vcard">
        <?php
        /*
          this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
          echo get_avatar($comment,$size='32',$default='<path_to_url>' );
        */
        ?>
        <?php // custom gravatar call ?>
        <?php
          // create variable
          $bgauthemail = get_comment_author_email();
        ?>
        <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=40" class="load-gravatar avatar avatar-48 photo" height="40" width="40" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
        <?php // end custom gravatar call ?>
        <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'bonestheme' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'bonestheme' ),'  ','') ) ?>
        <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'bonestheme' )); ?> </a></time>

      </header>
      <?php if ($comment->comment_approved == '0') : ?>
        <div class="alert alert-info">
          <p><?php _e( 'Your comment is awaiting moderation.', 'bonestheme' ) ?></p>
        </div>
      <?php endif; ?>
      <section class="comment_content cf">
        <?php comment_text() ?>
      </section>
      <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </article>
  <?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!


/*
This is a modification of a function found in the
twentythirteen theme where we can declare some
external fonts. If you're using Google Fonts, you
can replace these fonts, change it in your scss files
and be up and running in seconds.
*/
function bones_fonts() {
	wp_enqueue_style('googleFonts', 'http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic');
}

add_action('wp_enqueue_scripts', 'bones_fonts');

// Enable support for HTML5 markup.
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form'
	) );

require_once( 'cmb-functions.php' );


add_filter('wp_nav_menu_items','add_items_to_main_menu', 10, 2);
function add_items_to_main_menu( $nav, $args ) {
	if ( $args->theme_location == 'main-nav' ) {
		return $nav. '<li class="menu-item-search"><a href="#" class="TRIGGER_SEARCH">Search</a></li><li class="menu-item-logout'.(is_user_logged_in() ? '':' inactive').'"><a href="#" class="TRIGGER_LOGOUT">Logout</a></li><li class="menu-item-login'.(is_user_logged_in() ? ' inactive':'').'"><a href="'.get_site_url().'/login" class="TRIGGER_LOGIN">Login</a></li>';
	}
	return $nav;
}

// Ajax login: http://natko.com/wordpress-ajax-login-without-a-plugin-the-right-way/
function ajax_login_init(){
    // Enable the user with no privileges to run ajax_login() in AJAX
    add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
}
function ajax_logout_init(){
    // Enable the user with no privileges to run ajax_login() in AJAX
	add_action('wp_ajax_ajaxlogout','ajax_logout');
}

// Execute the action only if the user isn't logged in
if (is_user_logged_in()) {
    add_action('init', 'ajax_logout_init');
} else {
    add_action('init', 'ajax_login_init');
}

function ajax_login(){
    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-login-nonce', 'security' );

    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon( $info, false );
    if ( is_wp_error($user_signon) ){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.')));
    } else {
        echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful')));
    }

    die();
}

function ajax_logout() {
	check_ajax_referer( 'ajax-logout-nonce', 'security' );
	wp_clear_auth_cookie();
	wp_logout();
	ob_clean(); // probably overkill for this, but good habit
	echo json_encode(array('loggedout'=>true, 'message'=>__('Logout successful')));
	wp_die();
}

// Add Password, Repeat Password and Are You Human fields to WordPress registration form
// http://wp.me/p1Ehkq-gn

add_action( 'register_form', 'extra_registration_fields' );
function extra_registration_fields(){
?>
	<p>
		<label for="password">Password<br/>
		<input id="password" class="input" type="password" size="25" value="" name="password" />
		</label>
	</p>
	<p>
		<label for="repeat_password">Repeat password<br/>
		<input id="repeat_password" class="input" type="password" size="25" value="" name="repeat_password" />
		</label>
	</p>
	<?php /*<p>
		<label for="are_you_human" style="font-size:11px">Sorry, but we must check if you are human. What is the name of website you are registering for?<br/>
		<input id="are_you_human" class="input" type="text" tabindex="40" size="25" value="" name="are_you_human" />
		</label>
	</p>*/ ?>
<?php
}

// Check the form for errors
add_action( 'register_post', 'validate_extra_registration_fields', 10, 3 );
function validate_extra_registration_fields($login, $email, $errors) {
	if ( $_POST['password'] !== $_POST['repeat_password'] ) {
		$errors->add( 'passwords_not_matched', "<strong>ERROR</strong>: Passwords must match" );
	}
	if ( strlen( $_POST['password'] ) < 6 ) {
		$errors->add( 'password_too_short', "<strong>ERROR</strong>: Passwords must be at least six characters long" );
	}
	/*
	if ( $_POST['are_you_human'] !== get_bloginfo( 'name' ) ) {
		$errors->add( 'not_human', "<strong>ERROR</strong>: Your name is Bot? James Bot? Check bellow the form, there's a Back to [sitename] link." );
	}
	*/
}

// automatically login new registrants and drop them on the home page
function auto_login_new_user( $user_id ) {
	$userdata = array();
	$userdata['ID'] = $user_id;
	if ( $_POST['password'] !== '' ) {
		$userdata['user_pass'] = $_POST['password'];
	}
	$new_user_id = wp_update_user( $userdata );
	
	$user = get_user_by('id', $user_id);
	if ($user) {
		wp_set_current_user($user_id);
		wp_set_auth_cookie($user_id);
		do_action('wp_signon', $user->user_login);
	}
	// You can change home_url() to the specific URL,such as 
	//wp_redirect( 'http://www.wpcoke.com' );
	wp_redirect( home_url() );
	exit;
}
add_action( 'user_register', 'auto_login_new_user' );

add_filter( 'wp_login_errors', 'forgot_password_confirm_text_filter', 10, 2 );
function forgot_password_confirm_text_filter( $errors, $redirect_to )
{
   if( isset( $errors->errors['confirm'] ) )
   {
     // Use the magic __get method to retrieve the errors array:
     $tmp = $errors->errors;   

     // What text to modify:
     $old_confirm = 'Check your e-mail for the confirmation link.';
     $new_confirm = 'Check your e-mail for the confirmation link. It may take a few minutes to be delivered. If you cannot find it in your inbox, be sure to check your junkmail/spam folder.';

     // Loop through the errors messages and modify the corresponding message:
     foreach( $tmp['confirm'] as $index => $msg )
     {
       if( $msg === $old_confirm )
           $tmp['confirm'][$index] = $new_confirm;        
     }
     // Use the magic __set method to override the errors property:
     $errors->errors = $tmp;

     // Cleanup:
     unset( $tmp );
   }  
   return $errors;
}

// adding favicon to admin and login pages
function add_favicon_admin() {
	echo '<link rel="shortcut icon" href="' . get_stylesheet_directory_uri().'/favicon.png' . '" />';
}
add_action('login_head', 'add_favicon_admin');
add_action('admin_head', 'add_favicon_admin');

/**** NO LONGER NEEDED -- NOW USING WP MAIL SMTP plugin
// changing default name and email address for system generated emails (like password recovery)
add_filter( 'wp_mail_from_name', function( $name ) {
	return 'Skinsplex Webmaster';
});
add_filter( 'wp_mail_from', function( $email ) {
	return 'contact@skinsplex.com';
});*/

// SHORTCODES
// Overriding default video shortcode

$vidShortcodeIncrement = 0;
function override_default_video_shortcode($html,$atts) {
	global $vidShortcodeIncrement;
	$args = shortcode_atts( array(
		'src' => '',
		'poster' => '',
		'loop' => '',
		'autoplay' => '',
		'preload' => '',
		'mp4' => '',
		'm4v' => '',
		'webm' => '',
		'ogv' => '',
		'webm' => '',
		'wmv' => '',
		'flv' => '',
		'class' => '',
		'width' => '',
		'height' => ''
	), $atts);
	
	global $post;
	$videoplayer = '<div class="vid-container '.$args['class'].'">';
	$videoplayer .= '<video id="vidPlayer_'.$vidShortcodeIncrement.'" class="video-js vjs-default-skin vjs-skinsplex-skin VID_PLAYER" controls'.($args['autoplay'] != '' ? ' autoplay' : '').($args['loop'] != '' ? ' loop' : '').($args['width'] != '' ? ' width="'.$args['width'].'"' : '').($args['height'] != '' ? ' height="'.$args['height'].'"' : '').'>';
	$videoplayer .= '<source src="'.$args['mp4'].'" type="video/mp4">';
	if ($args['ogv'] != '') {
		$videoplayer .= '<source src="'.$args['ogv'].'" type="video/ogg">';
	}
	if ($args['webm'] != '') {
		$videoplayer .= '<source src="'.$args['webm'].'" type="video/webm">';
	}
	$videoplayer.= '</video>';
	$videoplayer .= '</div>';
	$html.=$videoplayer;
	foreach($args as $key => $attr) {
	$html.='<pre>'.$key.': '.$attr.'</pre>';
	}
	
	$vidShortcodeIncrement ++;
	return $videoplayer;
}
add_filter('wp_video_shortcode_override','override_default_video_shortcode',10,2);
/*
function video_player_shortcode($atts) {
	global $vidShortcodeIncrement;
	extract( shortcode_atts( array(
		'mp4' => '',
		'ogv' => '',
		'webm' => '',
		'class' => '',
		'width' => '',
		'height' => ''
	), $atts) );
	global $post;
	$videoplayer = '<div id="VID_PLAYER_OV_'.$vidShortcodeIncrement.'" class="vid-container '.$class.'">';
	$videoplayer .= '<video id="vidPlayer_'.$vidShortcodeIncrement.'" class="video-js vjs-default-skin vjs-skinsplex-skin VID_PLAYER" controls'.($width != '' ? ' width="'.$width.'"' : '').($height != '' ? ' height="'.$height.'"' : '').'>';
	$videoplayer .= '<source src="'.$mp4.'" type="video/mp4">';
	if ($ogg != '') {
		$videoplayer .= '<source src="'.$ogg.'" type="video/ogg">';
	}
	if ($webm != '') {
		$videoplayer .= '<source src="'.$webm.'" type="video/webm">';
	}
	$videoplayer.= '</video>';
	$videoplayer .= '</div>';
	$vidShortcodeIncrement ++;
	return $videoplayer;
}
add_shortcode('video-player', 'video_player_shortcode');
*/

function ad_space_shortcode($atts) {
	$a = shortcode_atts( array(
		'slug' => '',
		'wrap' => "true",
		'class' => ''
	), $atts);
	$wrap = $a['wrap'] == 'true';
	
	$ad_object = get_posts(array('post_type'=>'ad_spaces','name'=>$a['slug']));
	$ads = get_post_meta($ad_object[0]->ID, '_skinsplex_ad_space_group', true);
	if (!isset($ads[0])) {
		return;
	}
	
	if ($wrap) { $html = '<div class="advspwrap skpladv-'.$a['class'].'">'; }
	$html .= '<ul id="skpladv_'.$ad_object[0]->ID.'" class="advspcnt r-'.get_post_meta($ad_object[0]->ID, '_skinsplex_ad_space_width', true).'x'.get_post_meta($ad_object[0]->ID, '_skinsplex_ad_space_height', true).' ADVSPCNT">';
	foreach( (array) $ads as $key => $ad) {
		if ($ad[type] == 'image') {
			$html .= '<li class="skpladv-'.$ad[image_id].($key==0 ? ' active':'').'">';
			$html .= '<a target="_blank" href="'.$ad[link].'">';
			$html .= '<img src="'.$ad[image].'" alt="'.$ad[description].'" />';
			$html .= '</a>';
			$html .= '</li>';
		} else if ($ad[type] == 'code') {
			$html .= '<li class="skpladv'.($key==0 ? ' active':'').'">';
			$html .= $ad[code];
			$html .= '</li>';
		}
	}
	$html .= '</ul>';
	$html .= '<input id="skpladv_dur_'.$ad_object[0]->ID.'" type="hidden" class="DURATION" value="'.get_post_meta($ad_object[0]->ID, '_skinsplex_ad_space_duration', true).'" />';
	if ($wrap) { $html .= '</div>'; }
	
	return $html;
}
add_shortcode('ad-space','ad_space_shortcode');

/* DON'T DELETE THIS CLOSING TAG */ ?>
