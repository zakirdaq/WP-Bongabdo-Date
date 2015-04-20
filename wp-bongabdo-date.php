<?php
	/*
	Plugin Name: WP Bongabdo Date
	Plugin URI: http://webnitpark.com/
	Description: Converts Date to Bongabdo Date. Once you activate the plugin, automatically date and time will be changed to Bongabdo date for all posts and comments. You can show it in both english and bangla language.
	Author: Zakir Hossain
	Version: 13.0
	Author URI: http://facebook.com/ZakirDakua
	*/

	include "wp-bongabdo-date-functions.php";

	$wpbd_options = get_option("wpbd_options");
	if (!is_array($wpbd_options)) {
		$wpbd_options = array(
			'months_in_bangla' => '0',
			'digits_in_bangla' => '0'
		);
	}
	 
	add_filter('get_comment_date', 'wp_bongabdo_date_comment',0,2);
	add_filter('get_the_date', 'wp_bongabdo_date_post',0,4);
	
	if($wpbd_options['months_in_bangla'] == "1") {
		add_filter('date_i18n', 'months_to_bn');
		add_filter('get_the_date', 'months_to_bn');
		add_filter('get_comment_date', 'months_to_bn');
		add_filter('number_format_i18n', 'months_to_bn');
	}
	
	if($wpbd_options['digits_in_bangla'] == "1") {
		add_filter('date_i18n', 'digits_to_bn');
		add_filter('get_the_date', 'digits_to_bn');
		add_filter('get_the_time', 'digits_to_bn');
		add_filter('get_comment_date', 'digits_to_bn');
		add_filter('get_comment_time', 'digits_to_bn');	
		add_filter('number_format_i18n', 'digits_to_bn');
		add_filter('comments_number', 'digits_to_bn');
		add_filter('get_comment_count', 'digits_to_bn');
		add_filter('get_archives_link', 'digits_to_bn');
		add_filter('wp_list_categories', 'digits_to_bn');
	}
	
    if(is_admin())
		include 'wp-bongabdo-date-settings.php';
		
	function wpbd_settings_links($links) {
		$links[] = '<a href="' . get_admin_url(null, 'options-general.php?page=wp-bongabdo-date') . '">Settings</a>';
		return $links;
	}

	add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'wpbd_settings_links');
?>
