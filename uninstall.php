<?php
/**
 *
 * Confirm Cookies Info 0.1 Uninstall script.
 */

if( defined( 'ABSPATH') && defined('WP_UNINSTALL_PLUGIN') ) {
 	//Remove the plugin's settings
 	delete_option( 'as_cci_options');
 	
// 	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

}
?>