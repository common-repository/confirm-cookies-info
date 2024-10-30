<?php
/*
 Plugin Name: Confirm Cookies Info
 Plugin URI: http://www.wp-art.pl/plugins/confirm_cookies_info.php
 Description: Confirm Cookies Info - small plugin for all who on his blog have / should put the text on the use of cookies technology.
 Version: 0.1.3
 Author: Artur Szula
 Author URI: http://www.wp-art.pl
 License: GPLv2
 Text Domain: confirm-cookies-info
 Domain Path: /languages/
*/

define('CCI_VERSION', '0.1.3');
define('CCI_PLUGIN_URL', plugin_dir_url( __FILE__ ));
define('CCI_PLUGIN_PATH', plugin_dir_path( __FILE__ ));

/**
 * Load plugin textdomain.
 */
function loadTextDomain() {
	load_plugin_textdomain( 'confirm-cookies-info', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action( 'plugins_loaded', 'loadTextDomain' );

if( !class_exists('as_cci_main_class') ) {
	include_once dirname(__FILE__) .'/includes/as_cci_main_class.php';
}

if( class_exists('as_cci_main_class') ) { 
	// Installation and uninstallation hooks 
	//if( $installed_ver != defined('CCI_VERSION') ) {
	register_activation_hook(__FILE__, array('as_cci_main_class', 'activate'));
	//} 
	register_deactivation_hook(__FILE__, array('as_cci_main_class', 'deactivate')); 

	// instantiate the plugin class 
	$as_cci_instance = new as_cci_main_class(); 

}
?>