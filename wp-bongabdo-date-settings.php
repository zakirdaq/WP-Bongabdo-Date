<?php
function wpbd_options_page() {
	?>
    <div class="wrap">
    <h2>WP Bongabdo Date Settings</h2>
    <br/>
    <form method="post" action="options.php">    
		<?php
		settings_fields( 'wpbd-settings-group' );
		$wpbd_options = get_option("wpbd_options");
		if (!is_array($wpbd_options)) {
			$wpbd_options = array(
				'months_in_bangla' => '0',
				'digits_in_bangla' => '0'
			);
		}
?>
	<div class="postbox">
		<h3 class="hndle" style="padding: 10px; margin: 0;"><span>Options</span></h3>
		<div class="inside">
			<table class="form-table">
			<tbody>
				<tr>
				<th scope="row"><label for="wpbd_options[months_in_bangla]">Monthname in Bangla:</label></th>
				<td><input id="wpbd_options[months_in_bangla]" type="checkbox" name="wpbd_options[months_in_bangla]" value="1" <?php if($wpbd_options['months_in_bangla']==1) echo('checked="checked"'); ?>/></td>
				</tr>
				<tr>
				<th scope="row"><label for="wpbd_options[digits_in_bangla]">All Digits in Bangla:</label></th>
				<td><input id="wpbd_options[digits_in_bangla]" type="checkbox" name="wpbd_options[digits_in_bangla]" value="1" <?php if($wpbd_options['digits_in_bangla']==1) echo('checked="checked"'); ?>/></td>
				</tr>
			   </tbody>
			</table>
		</div>
	</div>
    <?php submit_button(); ?>
	</form>
<?php
}

function wpbd_admin() {	
	global $wpbd_hook;
	$wpbd_hook = add_options_page('WP Bongabdo Date Settings', 'WP Bongabdo Date', 8, 'wp-bongabdo-date', 'wpbd_options_page');
}
	
function register_wpbd_settings() {
	register_setting( 'wpbd-settings-group', 'wpbd_options' );
}

add_action('admin_menu', 'wpbd_admin');
add_action('admin_init', 'register_wpbd_settings');
?>
