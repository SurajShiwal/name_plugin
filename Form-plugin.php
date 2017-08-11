<?php
/*
Plugin Name: Form Plugin

Description: Basic WordPress Plugin Header Comment
Version:     0.1
Author:      Suraj
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wporg
License:     GPL2

*/
add_action('add_meta_boxes', 'cd_meta_box_add');

function cd_meta_box_add()
	{
	add_meta_box('my-meta-box-id', 'My First Meta Box', 'cd_meta_box_cb', 'post', 'normal', 'high');
	}

function cd_meta_box_cb()
	{
	echo plugin_dir_url(__FILE__);
?>
	<form>
	<label for="name">Name: </label>
	<input type="text" name="name" id="name" />
	<input name="save" type="submit" onclick="" class="button button-primary button-large"  id="ss-save" value="Save">
	</form>
	<?php
	}

function register_script()
	{
	wp_enqueue_script('wp_name_save', plugin_dir_url(__FILE__) . '/js/upload.js');
	}

add_action('admin_enqueue_scripts', __NAMESPACE__ . '\register_script');
register_activation_hook(__FILE__, 'my_plugin_create_db');
global $wpdb;
$charset_collate = $wpdb->get_charset_collate();
$table_name = $wpdb->prefix . 'my_analysis';
$sql = "CREATE TABLE $table_name (

	id mediumint(9) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		name text not null,
		UNIQUE KEY id (id)
	) $charset_collate;";
require_once (ABSPATH . 'wp-admin/includes/upgrade.php');

dbDelta($sql);

// create custom plugin settings menu

add_action('admin_menu', 'plugincreate_menu');

function plugincreate_menu()
{

	// create new top-level menu

	add_menu_page('Plugin for shortcode', 'Form Plugin', 'administrator', __FILE__, 'ss_info_recieve');

	// call register settings function

	add_action('admin_init', 'register_pluginsettings');
	}

function register_pluginsettings()
	{

	// register our settings

	register_setting('ss-settings-group', 'name');
	}

function ss_info_recieve()
	{
?>
<div class="wrap">
<h1>Enter Your Name to Generate its shortcode</h1>

<form method="post" action="options.php">
	<?php
	settings_fields('ss-settings-group'); ?>
	<?php
	do_settings_sections('-settings-group'); ?>
	<table class="form-table">
			   
		<tr valign="top">
		<th scope="row">Name</th>
		<td><input type="text" name="name" value="<?php
	echo esc_attr(get_option('name')); ?>" /></td>
		</tr>
	</table>
	
	<?php
	$name = esc_attr(get_option('name'));
	$todays_date=date("l jS Y");
	printf(
    /* translators: 1:name 2:date*/
    __( 'Hello %1$s Today is %2$s','textdomain'),
    $name,$todays_date);
	echo "<br >";
	submit_button();
	_e(" this is the shortcode you have to use -> [my_name]",'my_shortcode_domain');
?>
</form>
</div>
<?php
	}
function add_my_shortcode()
	{
	$name = esc_attr(get_option('name'));
	$date = date("l jS, Y");
	printf(
    /* translators: 1:name 2:date*/
    __( 'Hello %1$s Today is %2$s','textdomain'),
    $name,$todays_date);
	}

add_shortcode('my_name', 'add_my_shortcode');




 // init process for registering our button
 add_action('init', 'ss_shortcode_button_init');
 function ss_shortcode_button_init() {

      //Abort early if the user will never see TinyMCE
      if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') && get_user_option('rich_editing') == 'true')
           return;

      //Add a callback to regiser our tinymce plugin   
      add_filter("mce_external_plugins", "ss_register_tinymce_plugin"); 

      // Add a callback to add our button to the TinyMCE toolbar
      add_filter('mce_buttons', 'ss_add_tinymce_button');
}


//This callback registers our plug-in
function ss_register_tinymce_plugin($plugin_array) {
    $plugin_array['ss_button'] = plugin_dir_url(__FILE__) . 'js/shortcode.js';
    return $plugin_array;
}

//This callback adds our button to the toolbar
function ss_add_tinymce_button($buttons) {
            //Add the button ID to the $button array
    $buttons[] = "ss_button";
    return $buttons;
}


?>
