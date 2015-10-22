<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB directory)
 *
 * Be sure to replace all instances of 'skinsplex_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category Skinsplex
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */

if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/CMB2/init.php';
}

/**
 * Conditionally displays a field when used as a callback in the 'show_on_cb' field parameter
 *
 * @param  CMB2_Field object $field Field object
 *
 * @return bool                     True if metabox should show
 */
function skinsplex_hide_if_no_cats( $field ) {
	// Don't show this field if not in the cats category
	if ( ! has_tag( 'cats', $field->object_id ) ) {
		return false;
	}
	return true;
}

/**
 * Conditionally displays a message if the $post_id is 2
 *
 * @param  array             $field_args Array of field parameters
 * @param  CMB2_Field object $field      Field object
 */
function skinsplex_before_row_if_2( $field_args, $field ) {
	if ( 2 == $field->object_id ) {
		echo '<p>Testing <b>"before_row"</b> parameter (on $post_id 2)</p>';
	} else {
		echo '<p>Testing <b>"before_row"</b> parameter (<b>NOT</b> on $post_id 2)</p>';
	}
}

add_action( 'cmb2_init', 'skinsplex_register_index_grid_metabox' );

function skinsplex_register_index_grid_metabox() {
	$prefix = '_skinsplex_index_grid_';
	
	$cmb_custom_index_box = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Index Grid Page Options', 'cmb2' ),
		'object_types'  => array( 'page', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );

	$cmb_custom_index_box->add_field( array(
		'name'             => __( 'Media Item Type', 'cmb2' ),
		'desc'             => __( 'Choose what type of Media Items will be displayed on this page', 'cmb2' ),
		'id'               => $prefix . 'select',
		'type'             => 'select',
		'show_option_none' => false,
		'options'          => array(
			'' 						=> __( 'All', 'cmb2' ),
			'movies'  			=> __( 'Movies', 'cmb2' ),
			'documentaries'	=> __( 'Documentaries', 'cmb2' ),
			'series'     			=> __( 'Series', 'cmb2' ),
			'previews'     		=> __( 'Previews', 'cmb2' ),
		),
	) );
}

add_action( 'cmb2_init', 'skinsplex_register_media_item_metabox' );

function skinsplex_register_media_item_metabox() {
	$prefix = '_skinsplex_media_item_';
	
	$cmb_media_item_box = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Media Item Information - All fields are optional', 'cmb2' ),
		'object_types'  => array( 'media_items', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );

	$cmb_media_item_box->add_field( array(
		'name'		=> __( 'Video Link', 'cmb2' ),
		'desc' => __( 'Upload/Select a video or enter a URL', 'cmb2' ),
		'id'			=> $prefix . 'video_link',
		'type'		=> 'file',
	) );

	$cmb_media_item_box->add_field( array(
		'name'		=> __( 'Pre-Roll Video Link', 'cmb2' ),
		'desc' => __( 'Upload/Select a video or enter a URL. This video will run before the main feature (optional).', 'cmb2' ),
		'id'			=> $prefix . 'pre_video_link',
		'type'		=> 'file',
	) );

	$cmb_media_item_box->add_field( array(
		'name'		=> __( 'Post-Roll Video Link', 'cmb2' ),
		'desc' => __( 'Upload/Select a video or enter a URL. This video will show after the main feature (optional).', 'cmb2' ),
		'id'			=> $prefix . 'post_video_link',
		'type'		=> 'file',
	) );

	$cmb_media_item_box->add_field( array(
		'name'		=> __( 'Director', 'cmb2' ),
		'id'			=> $prefix . 'director',
		'type'		=> 'text',
	) );

	$cmb_media_item_box->add_field( array(
		'name'		=> __( 'Producer', 'cmb2' ),
		'id' 			=> $prefix . 'producer',
		'type'		=> 'text',
	) );

	$cmb_media_item_box->add_field( array(
		'name'		=> __( 'Writer', 'cmb2' ),
		'id' 			=> $prefix . 'writer',
		'type'		=> 'text',
	) );

	$cmb_media_item_box->add_field( array(
		'name'		=> __( 'Cast', 'cmb2' ),
		'desc'       => __( 'Enter the names of the actors here', 'cmb2' ),
		'id' 			=> $prefix . 'cast',
		'type'		=> 'textarea_small',
	) );

	$cmb_media_item_box->add_field( array(
		'name'		=> __( 'Duration', 'cmb2' ),
		'desc'       => __( 'Enter the duration in minutes', 'cmb2' ),
		'id' 			=> $prefix . 'duration',
		'type'		=> 'text_small',
	) );

	$cmb_media_item_box->add_field( array(
		'name'		=> __( 'Country', 'cmb2' ),
		'id' 			=> $prefix . 'country',
		'type'		=> 'text',
	) );

	$cmb_media_item_box->add_field( array(
		'name'		=> __( 'Age Restriction', 'cmb2' ),
		'id' 			=> $prefix . 'age_restriction',
		'type'		=> 'text_small',
	) );

	$cmb_media_item_box->add_field( array(
		'name'		=> __( 'Excerpt Position - Left', 'cmb2' ),
		'desc'       => __( 'Enter a percentage from 0-100. Controls the horizontal position of the text description on home/category pages', 'cmb2' ),
		'id' 			=> $prefix . 'exceprt_position_left',
		'type'		=> 'text_small',
	) );

	$cmb_media_item_box->add_field( array(
		'name'		=> __( 'Excerpt Position - Top', 'cmb2' ),
		'desc'       => __( 'Enter a percentage from 0-100. Controls the vertical position of the text description on home/category pages', 'cmb2' ),
		'id' 			=> $prefix . 'exceprt_position_top',
		'type'		=> 'text_small',
	) );

	$cmb_media_item_box->add_field( array(
		'name'		=> __( 'Excerpt Text Color', 'cmb2' ),
		'desc'       => __( 'Choose the color of the text that appears over the banner image. If left blank, defaults to white.', 'cmb2' ),
		'id' 			=> $prefix . 'exceprt_text_color',
		'type'		=> 'colorpicker',
	) );

	/*******************
	rgba_colorpicker field type requires CMB2_RGBa_Picker to be installed in the plugins directory. It requires a javascript file that is also located in the plugins directory. The plugin has been modified slightly to rename the folder containing the javascript file.
	
	plugin comes from: https://github.com/JayWood/CMB2_RGBa_Picker
	*/
	$cmb_media_item_box->add_field( array(
		'name'		=> __( 'Excerpt Backround Color', 'cmb2' ),
		'desc'       => __( 'Choose the color of the background field behind the title and excerpt text on banners.', 'cmb2' ),
		'id' 			=> $prefix . 'exceprt_background_color',
		'type'		=> 'rgba_colorpicker',
	) );

	$cmb_media_item_box->add_field( array(
		'name'		=> __( 'Supertitle', 'cmb2' ),
		'desc'       => __( 'Puts text above the title and excerpt on the home and category pages.', 'cmb2' ),
		'id' 			=> $prefix . 'super_title',
		'type'		=> 'text',
	) );

	$cmb_media_item_box->add_field( array(
		'name'		=> __( 'Title size', 'cmb2' ),
		'desc'       => __( 'Enter the size for your title (an integer), defaults to 56px', 'cmb2' ),
		'id' 			=> $prefix . 'title_size',
		'type'		=> 'text_small',
	) );

	$cmb_media_item_box->add_field( array(
		'name'		=> __( 'Supertitle size', 'cmb2' ),
		'desc'       => __( 'Enter the size for your supertitle (an integer), defaults to 28px', 'cmb2' ),
		'id' 			=> $prefix . 'super_title_size',
		'type'		=> 'text_small',
	) );

	$cmb_media_item_box->add_field( array(
		'name'		=> __( 'Excerpt size', 'cmb2' ),
		'desc'       => __( 'Enter the size for excerpt (an integer), defaults to 24px', 'cmb2' ),
		'id' 			=> $prefix . 'excerpt_size',
		'type'		=> 'text_small',
	) );

	$cmb_media_item_box->add_field( array(
		'name' => __( 'Override Image', 'cmb2' ),
		'desc' => __( 'Upload/Select an image or enter a URL -- used for home/category page main slider', 'cmb2' ),
		'id'   => $prefix . 'override_image',
		'type' => 'file',
	) );
}

add_action( 'cmb2_init', 'skinsplex_register_ad_space_metabox' );

function skinsplex_register_ad_space_metabox() {
	$prefix = '_skinsplex_ad_space_';
	
	$cmb_ad_space_box = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Ad Space Information', 'cmb2' ),
		'object_types'  => array( 'ad_spaces', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );

	$cmb_ad_space_box->add_field( array(
		'name'		=> __( 'Width', 'cmb2' ),
		'desc'       => __( 'Enter the pixel width of the ad space', 'cmb2' ),
		'id' 			=> $prefix . 'width',
		'type'		=> 'text_small',
	) );

	$cmb_ad_space_box->add_field( array(
		'name'		=> __( 'Height', 'cmb2' ),
		'desc'       => __( 'Enter the pixel height of the ad space', 'cmb2' ),
		'id' 			=> $prefix . 'height',
		'type'		=> 'text_small',
	) );

	$cmb_ad_space_box->add_field( array(
		'name'		=> __( 'Duration', 'cmb2' ),
		'desc'       => __( 'Enter the time that each slide will show, in seconds, before the next one fades in. Decimals are okay. Example: 5.5', 'cmb2' ),
		'id' 			=> $prefix . 'duration',
		'type'		=> 'text_small',
	) );
	
	$group_field_id = $cmb_ad_space_box->add_field( array(
		'id'          => $prefix . 'group',
		'type'        => 'group',
		'description' => __( 'Generates multiple ads in this size', 'cmb2' ),
		'options'     => array(
			'group_title'   => __( 'Ad #{#}', 'cmb2' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Ad', 'cmb2' ),
			'remove_button' => __( 'Remove Ad', 'cmb2' ),
			'sortable'      => true, // beta
		),
	) );

	$cmb_ad_space_box->add_group_field( $group_field_id, array(
		'name' => __( 'Ad Image', 'cmb2' ),
		'desc' => __( 'Upload/Select an image or enter a URL', 'cmb2' ),
		'id'   => 'image',
		'type' => 'file',
	) );

	$cmb_ad_space_box->add_group_field( $group_field_id, array(
		'name'        => __( 'Description', 'cmb2' ),
		'description' => __( 'Enter the text that appears in the ad image', 'cmb2' ),
		'id'          => 'description',
		'type'        => 'textarea_small',
	) );

	$cmb_ad_space_box->add_group_field( $group_field_id, array(
		'name'        => __( 'Link', 'cmb2' ),
		'description' => __( 'Enter the URL where clicking this ad leads', 'cmb2' ),
		'id'          => 'link',
		'type'        => 'text_url',
	) );

}


// add_action( 'cmb2_init', 'skinsplex_register_demo_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_init' hook.
 */
function skinsplex_register_demo_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_skinsplex_demo_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Test Metabox', 'cmb2' ),
		'object_types'  => array( 'page', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );

	$cmb_demo->add_field( array(
		'name'       => __( 'Test Text', 'cmb2' ),
		'desc'       => __( 'field description (optional)', 'cmb2' ),
		'id'         => $prefix . 'text',
		'type'       => 'text',
		'show_on_cb' => 'skinsplex_hide_if_no_cats', // function should return a bool value
		// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
		// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
		// 'on_front'        => false, // Optionally designate a field to wp-admin only
		// 'repeatable'      => true,
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Test Text Small', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'textsmall',
		'type' => 'text_small',
		// 'repeatable' => true,
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Test Text Medium', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'textmedium',
		'type' => 'text_medium',
		// 'repeatable' => true,
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Website URL', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'url',
		'type' => 'text_url',
		// 'protocols' => array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet'), // Array of allowed protocols
		// 'repeatable' => true,
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Test Text Email', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'email',
		'type' => 'text_email',
		// 'repeatable' => true,
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Test Time', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'time',
		'type' => 'text_time',
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Time zone', 'cmb2' ),
		'desc' => __( 'Time zone', 'cmb2' ),
		'id'   => $prefix . 'timezone',
		'type' => 'select_timezone',
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Test Date Picker', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'textdate',
		'type' => 'text_date',
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Test Date Picker (UNIX timestamp)', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'textdate_timestamp',
		'type' => 'text_date_timestamp',
		// 'timezone_meta_key' => $prefix . 'timezone', // Optionally make this field honor the timezone selected in the select_timezone specified above
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Test Date/Time Picker Combo (UNIX timestamp)', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'datetime_timestamp',
		'type' => 'text_datetime_timestamp',
	) );

	// This text_datetime_timestamp_timezone field type
	// is only compatible with PHP versions 5.3 or above.
	// Feel free to uncomment and use if your server meets the requirement
	// $cmb_demo->add_field( array(
	// 	'name' => __( 'Test Date/Time Picker/Time zone Combo (serialized DateTime object)', 'cmb2' ),
	// 	'desc' => __( 'field description (optional)', 'cmb2' ),
	// 	'id'   => $prefix . 'datetime_timestamp_timezone',
	// 	'type' => 'text_datetime_timestamp_timezone',
	// ) );

	$cmb_demo->add_field( array(
		'name' => __( 'Test Money', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'textmoney',
		'type' => 'text_money',
		// 'before_field' => '£', // override '$' symbol if needed
		// 'repeatable' => true,
	) );

	$cmb_demo->add_field( array(
		'name'    => __( 'Test Color Picker', 'cmb2' ),
		'desc'    => __( 'field description (optional)', 'cmb2' ),
		'id'      => $prefix . 'colorpicker',
		'type'    => 'colorpicker',
		'default' => '#ffffff',
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Test Text Area', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'textarea',
		'type' => 'textarea',
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Test Text Area Small', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'textareasmall',
		'type' => 'textarea_small',
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Test Text Area for Code', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'textarea_code',
		'type' => 'textarea_code',
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Test Title Weeeee', 'cmb2' ),
		'desc' => __( 'This is a title description', 'cmb2' ),
		'id'   => $prefix . 'title',
		'type' => 'title',
	) );

	$cmb_demo->add_field( array(
		'name'             => __( 'Test Select', 'cmb2' ),
		'desc'             => __( 'field description (optional)', 'cmb2' ),
		'id'               => $prefix . 'select',
		'type'             => 'select',
		'show_option_none' => true,
		'options'          => array(
			'standard' => __( 'Option One', 'cmb2' ),
			'custom'   => __( 'Option Two', 'cmb2' ),
			'none'     => __( 'Option Three', 'cmb2' ),
		),
	) );

	$cmb_demo->add_field( array(
		'name'             => __( 'Test Radio inline', 'cmb2' ),
		'desc'             => __( 'field description (optional)', 'cmb2' ),
		'id'               => $prefix . 'radio_inline',
		'type'             => 'radio_inline',
		'show_option_none' => 'No Selection',
		'options'          => array(
			'standard' => __( 'Option One', 'cmb2' ),
			'custom'   => __( 'Option Two', 'cmb2' ),
			'none'     => __( 'Option Three', 'cmb2' ),
		),
	) );

	$cmb_demo->add_field( array(
		'name'    => __( 'Test Radio', 'cmb2' ),
		'desc'    => __( 'field description (optional)', 'cmb2' ),
		'id'      => $prefix . 'radio',
		'type'    => 'radio',
		'options' => array(
			'option1' => __( 'Option One', 'cmb2' ),
			'option2' => __( 'Option Two', 'cmb2' ),
			'option3' => __( 'Option Three', 'cmb2' ),
		),
	) );

	$cmb_demo->add_field( array(
		'name'     => __( 'Test Taxonomy Radio', 'cmb2' ),
		'desc'     => __( 'field description (optional)', 'cmb2' ),
		'id'       => $prefix . 'text_taxonomy_radio',
		'type'     => 'taxonomy_radio',
		'taxonomy' => 'category', // Taxonomy Slug
		// 'inline'  => true, // Toggles display to inline
	) );

	$cmb_demo->add_field( array(
		'name'     => __( 'Test Taxonomy Select', 'cmb2' ),
		'desc'     => __( 'field description (optional)', 'cmb2' ),
		'id'       => $prefix . 'taxonomy_select',
		'type'     => 'taxonomy_select',
		'taxonomy' => 'category', // Taxonomy Slug
	) );

	$cmb_demo->add_field( array(
		'name'     => __( 'Test Taxonomy Multi Checkbox', 'cmb2' ),
		'desc'     => __( 'field description (optional)', 'cmb2' ),
		'id'       => $prefix . 'multitaxonomy',
		'type'     => 'taxonomy_multicheck',
		'taxonomy' => 'post_tag', // Taxonomy Slug
		// 'inline'  => true, // Toggles display to inline
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Test Checkbox', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'checkbox',
		'type' => 'checkbox',
	) );

	$cmb_demo->add_field( array(
		'name'    => __( 'Test Multi Checkbox', 'cmb2' ),
		'desc'    => __( 'field description (optional)', 'cmb2' ),
		'id'      => $prefix . 'multicheckbox',
		'type'    => 'multicheck',
		'options' => array(
			'check1' => __( 'Check One', 'cmb2' ),
			'check2' => __( 'Check Two', 'cmb2' ),
			'check3' => __( 'Check Three', 'cmb2' ),
		),
		// 'inline'  => true, // Toggles display to inline
	) );

	$cmb_demo->add_field( array(
		'name'    => __( 'Test wysiwyg', 'cmb2' ),
		'desc'    => __( 'field description (optional)', 'cmb2' ),
		'id'      => $prefix . 'wysiwyg',
		'type'    => 'wysiwyg',
		'options' => array( 'textarea_rows' => 5, ),
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Test Image', 'cmb2' ),
		'desc' => __( 'Upload an image or enter a URL.', 'cmb2' ),
		'id'   => $prefix . 'image',
		'type' => 'file',
	) );

	$cmb_demo->add_field( array(
		'name'         => __( 'Multiple Files', 'cmb2' ),
		'desc'         => __( 'Upload or add multiple images/attachments.', 'cmb2' ),
		'id'           => $prefix . 'file_list',
		'type'         => 'file_list',
		'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'oEmbed', 'cmb2' ),
		'desc' => __( 'Enter a youtube, twitter, or instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.', 'cmb2' ),
		'id'   => $prefix . 'embed',
		'type' => 'oembed',
	) );

	$cmb_demo->add_field( array(
		'name'         => 'Testing Field Parameters',
		'id'           => $prefix . 'parameters',
		'type'         => 'text',
		'before_row'   => 'skinsplex_before_row_if_2', // callback
		'before'       => '<p>Testing <b>"before"</b> parameter</p>',
		'before_field' => '<p>Testing <b>"before_field"</b> parameter</p>',
		'after_field'  => '<p>Testing <b>"after_field"</b> parameter</p>',
		'after'        => '<p>Testing <b>"after"</b> parameter</p>',
		'after_row'    => '<p>Testing <b>"after_row"</b> parameter</p>',
	) );

}

// add_action( 'cmb2_init', 'skinsplex_register_about_page_metabox' );
/**
 * Hook in and add a metabox that only appears on the 'About' page
 */
function skinsplex_register_about_page_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_skinsplex_about_';

	/**
	 * Metabox to be displayed on a single page ID
	 */
	$cmb_about_page = new_cmb2_box( array(
		'id'           => $prefix . 'metabox',
		'title'        => __( 'About Page Metabox', 'cmb2' ),
		'object_types' => array( 'page', ), // Post type
		'context'      => 'normal',
		'priority'     => 'high',
		'show_names'   => true, // Show field names on the left
		'show_on'      => array( 'id' => array( 2, ) ), // Specific post IDs to display this metabox
	) );

	$cmb_about_page->add_field( array(
		'name' => __( 'Test Text', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'text',
		'type' => 'text',
	) );

}

// add_action( 'cmb2_init', 'skinsplex_register_repeatable_group_field_metabox' );
/**
 * Hook in and add a metabox to demonstrate repeatable grouped fields
 */
function skinsplex_register_repeatable_group_field_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_skinsplex_group_';

	/**
	 * Repeatable Field Groups
	 */
	$cmb_group = new_cmb2_box( array(
		'id'           => $prefix . 'metabox',
		'title'        => __( 'Repeating Field Group', 'cmb2' ),
		'object_types' => array( 'page', ),
	) );

	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $cmb_group->add_field( array(
		'id'          => $prefix . 'demo',
		'type'        => 'group',
		'description' => __( 'Generates reusable form entries', 'cmb2' ),
		'options'     => array(
			'group_title'   => __( 'Entry {#}', 'cmb2' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Entry', 'cmb2' ),
			'remove_button' => __( 'Remove Entry', 'cmb2' ),
			'sortable'      => true, // beta
		),
	) );

	/**
	 * Group fields works the same, except ids only need
	 * to be unique to the group. Prefix is not needed.
	 *
	 * The parent field's id needs to be passed as the first argument.
	 */
	$cmb_group->add_group_field( $group_field_id, array(
		'name'       => __( 'Entry Title', 'cmb2' ),
		'id'         => 'title',
		'type'       => 'text',
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name'        => __( 'Description', 'cmb2' ),
		'description' => __( 'Write a short description for this entry', 'cmb2' ),
		'id'          => 'description',
		'type'        => 'textarea_small',
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name' => __( 'Entry Image', 'cmb2' ),
		'id'   => 'image',
		'type' => 'file',
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name' => __( 'Image Caption', 'cmb2' ),
		'id'   => 'image_caption',
		'type' => 'text',
	) );

}

// add_action( 'cmb2_init', 'skinsplex_register_user_profile_metabox' );
/**
 * Hook in and add a metabox to add fields to the user profile pages
 */
function skinsplex_register_user_profile_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_skinsplex_user_';

	/**
	 * Metabox for the user profile screen
	 */
	$cmb_user = new_cmb2_box( array(
		'id'               => $prefix . 'edit',
		'title'            => __( 'User Profile Metabox', 'cmb2' ),
		'object_types'     => array( 'user' ), // Tells CMB to use user_meta vs post_meta
		'show_names'       => true,
		'new_user_section' => 'add-new-user', // where form will show on new user page. 'add-existing-user' is only other valid option.
	) );

	$cmb_user->add_field( array(
		'name'     => __( 'Extra Info', 'cmb2' ),
		'desc'     => __( 'field description (optional)', 'cmb2' ),
		'id'       => $prefix . 'extra_info',
		'type'     => 'title',
		'on_front' => false,
	) );

	$cmb_user->add_field( array(
		'name'    => __( 'Avatar', 'cmb2' ),
		'desc'    => __( 'field description (optional)', 'cmb2' ),
		'id'      => $prefix . 'avatar',
		'type'    => 'file',
	) );

	$cmb_user->add_field( array(
		'name' => __( 'Facebook URL', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'facebookurl',
		'type' => 'text_url',
	) );

	$cmb_user->add_field( array(
		'name' => __( 'Twitter URL', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'twitterurl',
		'type' => 'text_url',
	) );

	$cmb_user->add_field( array(
		'name' => __( 'Google+ URL', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'googleplusurl',
		'type' => 'text_url',
	) );

	$cmb_user->add_field( array(
		'name' => __( 'Linkedin URL', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'linkedinurl',
		'type' => 'text_url',
	) );

	$cmb_user->add_field( array(
		'name' => __( 'User Field', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'user_text_field',
		'type' => 'text',
	) );

}

// add_action( 'cmb2_init', 'skinsplex_register_theme_options_metabox' );
/**
 * Hook in and register a metabox to handle a theme options page
 */
function skinsplex_register_theme_options_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$option_key = '_skinsplex_theme_options';

	/**
	 * Metabox for an options page. Will not be added automatically, but needs to be called with
	 * the `cmb2_metabox_form` helper function. See wiki for more info.
	 */
	$cmb_options = new_cmb2_box( array(
		'id'      => $option_key . 'page',
		'title'   => __( 'Theme Options Metabox', 'cmb2' ),
		'hookup'  => false, // Do not need the normal user/post hookup
		'show_on' => array(
			// These are important, don't remove
			'key'   => 'options-page',
			'value' => array( $option_key )
		),
	) );

	/**
	 * Options fields ids only need
	 * to be unique within this option group.
	 * Prefix is not needed.
	 */
	$cmb_options->add_field( array(
		'name'    => __( 'Site Background Color', 'cmb2' ),
		'desc'    => __( 'field description (optional)', 'cmb2' ),
		'id'      => 'bg_color',
		'type'    => 'colorpicker',
		'default' => '#ffffff',
	) );

}
