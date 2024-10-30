<?php
class as_cci_main_class{
	/** 
	 * Construct the plugin object 
	 **/ 
	public function __construct() { 
		// register actions 
		add_action( 'admin_menu', array(&$this, 'add_menu') ); 
		add_action( 'wp_dashboard_setup', array(&$this, 'as_cci_dashboard_widget') );
		add_action( 'wp_enqueue_scripts', array(&$this, 'as_cci_insert_scripts_styles') );
		add_action( 'admin_enqueue_scripts', array(&$this, 'as_cci_adminpage_scripts_styles') );
		add_action( 'wp_footer', array(&$this, 'as_cci_injection_script') );
	} // END public function __construct 
	
	/** 
	 * Activate the plugin 
	 **/ 
	public static function activate() { 
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		
		$as_cci_options = array(
			'cci_version' 			=> defined('CCI_VERSION') ? CCI_VERSION : '0.1',
			'cci_display' 			=> 1,
			'cci_valign' 			=> 'top',
			'cci_halign' 			=> 'center',
			'cci_boxwidth' 			=> '1000',
			'cci_boxlrpadding' 		=> '20',
			'cci_boxtbpadding' 		=> '20',
			'cci_boxbackground-color' => '#ededed',
			'cci_info_font-size' 	=> '80', //percentage base site font size or pixels
			'cci_info_font-size_type' => '%', //or pixels
			'cci_info_font-color' 	=> '#000000',
			'cci_info_font-family' 	=> 'Helvetica', // or others defaults and used on website
			'cci_info' 				=> 'W ramach naszej strony internetowej wykorzystujemy technologię cookies w celu świadczenia Państwu usług na najwyższym poziomie, w tym w sposób dostosowany do indywidualnych potrzeb. Korzystanie z witryny bez zmiany ustawień dotyczących ciasteczek oznacza, że będą one zamieszczane w Państwa urządzeniu końcowym. W każdym momencie możesz określić warunki przechowywania i dostępu do plików cookies w Twojej przeglądarce.',
			'cci_btn_accept_label' 	=> 'Zgadzam się!',
			'cci_btn_accept-color' 	=> '#666666',
			'cci_btn_accept-hover' 	=> '#999999',
			'cci_btn_more_label' 	=> 'Czytaj więcej',
			'cci_btn_morelink'		=> 'http://',
			'cci_btn_morelink-color'=> '#adadad',
			'cci_btn_morelink-hover'=> '#9c9c9c',
			'cci_confirmedtime'		=> '1'
		);
		
		update_option( 'as_cci_options', $as_cci_options );
		
	} // END public static function activate 

	/** 
	 * add a menu 
	 **/ 
	public function add_menu() { 
		//create custom option-level menu
		add_options_page(	'Confirm Cookies Info - general settings', 
							'Confirm Cookies Info',
							'manage_options', 
							__FILE__, 
							array(&$this, 'as_cci_settings_page'),
							CCI_PLUGIN_URL .'images/as_cci_16ico.png' 
		);
		
	} // END public function add_menu() 
	/** 
	 * Menu Callback 
	 **/ 
	public function as_cci_settings_page() { 
		if( !current_user_can('manage_options') ) { 
			wp_die(__('You do not have sufficient permissions to access this page.', 'confirm-cookies-info')); 
		} // Render the settings template 
		
		include( CCI_PLUGIN_PATH ."templates/settings.php"); 
		
		$setting_page = new settings();
		
		echo $setting_page->full_content();
	} // END public function plugin_settings_page() 
	
	function as_cci_dashboard_widget() {
		//create a custom dashboard widget
		wp_add_dashboard_widget( 'dashboard_custom_feed', 'Confirm Cookies Info - '. __('Informacje', 'confirm-cookies-info'), 
								array(&$this, 'as_cci_dashboard_display') );
	}
		
	function as_cci_dashboard_display() {
		echo '<p>'. __("Thank you for using my plugin. I hope you liked it.", 'confirm-cookies-info') ."<br>". 
				__("Look at plugins ", 'confirm-cookies-info') .' <a href="http://www.wp-art.pl/plugins/confirm_cookies_info.php">'. __('webpage', 'confirm-cookies-info') 
				.'</a><br>'. __('Buy me a cup of coffee, because I work best at night.', 'confirm-cookies-info') 
				.'<div style="width:40%;float:left;"><form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" style="text-align:center;margin: 0 auto;">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="hosted_button_id" value="T8S6GU3365NYS">
					<input type="image" src="https://www.paypalobjects.com/pl_PL/PL/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - Płać wygodnie i bezpiecznie">
					<img alt="" border="0" src="https://www.paypalobjects.com/pl_PL/i/scr/pixel.gif" width="1" height="1">
				</form></div>
				<div style="width:40%;float:left;"><form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank" style="text-align:center;margin: 0 auto;">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="hosted_button_id" value="LYSEHH85FBKPW">
					<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
					<img alt="" border="0" src="https://www.paypalobjects.com/pl_PL/i/scr/pixel.gif" width="1" height="1">
				</form></div>
				<div style="clear:both;"><br><a href="'. admin_url() .'options-general.php?page=confirm-cookies-info/includes/as_cci_main_class.php">'. __('Settings page', 'confirm-cookies-info') .'</a></div>
			</p>';
	}
	
	function as_cci_insert_scripts_styles() {
		wp_enqueue_style( 'as_cci_frontend_style', CCI_PLUGIN_URL ."css/as_cci_style.css" );
		wp_enqueue_script( 'as_cci_frontend_scripts', CCI_PLUGIN_URL ."js/as_cci_script.js", array( 'jquery' ) );
	}
	
	function as_cci_adminpage_scripts_styles() {
		wp_enqueue_style( 'as_cci_adminpage_style', CCI_PLUGIN_URL ."css/as_cci_style.css" );
		wp_register_script( 'cci-admin-scripts', CCI_PLUGIN_URL ."js/as_cci_admin_page_scripts.js" );
		// Now we can localize the script with our data.
		$translation_array = array( 'string_on' => __( 'Plugin switched ON', 'confirm-cookies-info'), 'string_off' => __('Plugin switched OFF', 'confirm-cookies-info') );
		wp_localize_script( 'cci-admin-scripts', 'cci_object', $translation_array );
		wp_enqueue_script( 'cci-admin-scripts' );
	}
	
	function as_cci_injection_script() {
		$options = get_option('as_cci_options');
		
		if( intval($options['cci_display']) == 1 ) {
			$html = $this->as_cci_displaying_box_on_page(true);
			$breaks = array("\r\n", "\n", "\r");
			$html = str_replace($breaks, '', $html);
			?>
				<script type="text/javascript">
					//<![CDATA[
					jQuery(document).ready(function() {
						var o = '<?php echo $this->as_cci_get_json_options() ?>';
						var h = '<?php echo $html; ?>';
						as_cci_show_cookieinfobox(h,o);
					});
					//]]>
				</script>
				
				<?php
			}
	}
	
	private function as_cci_displaying_box_on_page( $on_page ) {
		$options = get_option('as_cci_options');
		$ret = '';
		if( $on_page ) {
			if( intval($options['cci_display']) == 1 ) {
				$ret = '<div id="cci-infobox-contener" class="cci-infobox-contener"><div id="cci-infobox" class="cci-infobox" style="padding:'. $options['cci_boxlrpadding'].'px '. $options['cci_boxtbpadding'] .'px;">
				<p id="cci-textinfo" class="cci-textinfo">'. addslashes($options['cci_info']) .'</p>
				<p id="cci-btn" class="cci-btn">
					<a id="cci-accept-btn" class="cci-accept-btn" onClick="as_cci_close_cookieinfobox('. addslashes($options['cci_confirmedtime']) .')">'. ($options['cci_btn_accept_label']) .'</a>&nbsp;&nbsp;<a id="cci-more-btn" class="cci-more-btn" href="'. ($options['cci_btn_more_link']) .'">'. ($options['cci_btn_more_label']) .'</a>
				</p>
				</div></div>';
					
				$ret = addslashes( stripslashes($ret) );
			}
		} 
		return $ret;
	}
	
	private function as_cci_get_json_options() {
		$options = get_option('as_cci_options');
		
		$nice_opt = array(
			'cci_valign' 			=> $options['cci_valign'],
			'cci_halign' 			=> $options['cci_halign'],
			'cci_boxwidth' 			=> $options['cci_boxwidth'],
			'cci_boxlrpadding' 		=> $options['cci_boxlrpadding'],
			'cci_boxtbpadding' 		=> $options['cci_boxtbpadding'],
			'cci_boxbackground_color' 	=> $options['cci_boxbackground-color'],
			'cci_info_font_size' 		=> $options['cci_info_font-size'],
			'cci_info_font_size_type' 	=> $options['cci_info_font-size_type'],
			'cci_info_font_color' 		=> $options['cci_info_font-color'],
			'cci_info_font_family' 		=> $options['cci_info_font-family'],
			'cci_confirmedtime'		=> $options['cci_confirmedtime']
		);
		$str = json_encode( $nice_opt );
		
		return $str;
	}
	
	/** 
	 * Deactivate the plugin 
	 **/ 
	public static function deactivate() { 
		delete_option( 'as_cci_options');	
	} // END public static function deactivate
}
?>