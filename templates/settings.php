<?php 
class settings {
	public function __construct() {
	}	
	public function full_content() {
		$msg = "";
		$errors = array();
		$options = get_option( 'as_cci_options' );
		if( count($_POST) > 0 ) {
			switch( $_POST['action'] ) {
				case 'update_admin_settings':{
					foreach( $options as $key => $value ) {
						if( isset($_POST[$key]) ) {
							$options[$key] = is_numeric($_POST[$key]) ? intval($_POST[$key]) : addslashes($_POST[$key]) ;
						} else {
							if( !in_array('cci_display', $_POST) ) {
								$options['cci_display'] = 0;
							}
						}
					}
					update_option('as_cci_options', $options);
					$this->update_styles( $options );
					$msg = __('Settings updated.', 'confirm-cookies-info');
					break;
				}
			}
		}
 		$content = file_get_contents( CCI_PLUGIN_PATH ."templates/html/settings.html" );
 		$s = array(
 				'{{page_title}}',
 				'{{flash_msg}}',
 				'{{donation}}',
 				'{{settings_form}}',
 				'{{box_preview}}',
 				'{{bug_info}}'
 		);
 		$c = array(
 				$this->site_header(), 
 				$this->get_flash_msg($msg, count($errors) > 0),
 				$this->donation_button(), 
 				$this->settings_form(), 
 				$this->box_preview(), 
 				$this->bug_info()
 		);
 		$content = str_replace( $s, 
 								$c, 
 								$content);
 		return $content;
	}
	
	private function site_header() {
		return "Confirm Cookies Info - " . __("General Settings", 'confirm-cookies-info');
	}
	
	private function get_flash_msg($msg, $err) {
		return $msg != '' ? '<div id="message" class="'. ($err ? "error" : "updated") .'" style="padding:7px;">'. $msg .'</div>' : '';
	}
	
	private function donation_button() {
		if( defined('WPLANG') && WPLANG == 'pl_PL' ) {
			$content = file_get_contents( CCI_PLUGIN_PATH ."templates/html/donation_btn_pl.html" );
		} else {
			$content = file_get_contents( CCI_PLUGIN_PATH ."templates/html/donation_btn_en.html" );
		}
		return $content;
	}
	
	private function settings_form(){
		require_once( CCI_PLUGIN_PATH ."includes/as_cci_form_creator.php" );
		$form = new as_cci_form_creator();
 		return $form->get_form();
	}
	
	private function box_preview() {
		$options = get_option('as_cci_options');
		$ret = '';
		if( $options['cci_halign'] == 'center' )
			$align = 'margin:0 auto;';
		elseif ( $options['cci_halign'] == 'left' )
		$align = 'float:left;';
		else
			$align = 'float:right;';
		$ret = '<div><div class="cci-infobox" style="'. $align .' width:'. intval($options['cci_boxwidth']) .'px;background-color:'. $options['cci_boxbackground-color'] .';padding:'. $options['cci_boxlrpadding'].'px '. $options['cci_boxtbpadding'] .'px;">
			<p id="cci-textinfo" style="font-family:'. $options['cci_info_font-family'] .';font-size:'. $options['cci_info_font-size'] . $options['cci_info_font-size_type'] .';color:'. $options['cci_info_font-color'] .'">'. addslashes($options['cci_info']) .'</p>
			<p id="cci-btn">
				<a id="cci-accept-btn">'. ($options['cci_btn_accept_label']) .'</a>&nbsp;&nbsp;<a id="cci-more-btn" href="'. ($options['cci_btn_more_link']) .'">'. ($options['cci_btn_more_label']) .'</a>
			</p>
			</div></div>';
		
		return '<h3>'. __('Preview', 'confirm-cookies-info') .'</h3>'. $ret;
	}
	
	private function bug_info() {
		$ret = __('If you see a bug in this plugin report it ', 'confirm-cookies-info') . ' <a href="http://mantis.wp-art.pl/login_page.php" target="_blank">'. __('here', 'confirm-cookies-info') .'</a><br>
 			Login: <span style="font-weight:bold;">cci_guest</span><br>
 			Password: <span style="font-weight:bold;">guest123*</span>';
		return '<h3>'. __('Report a bug', 'confirm-cookies-info') .'</h3>'. $ret;
	}
	
	private function update_styles( $options ) {
		$content = file_get_contents( CCI_PLUGIN_PATH ."css/as_cci_style_temp.css" );
		$btm_color = $this->get_new_color( $options['cci_btn_accept-color'], 0.8 );
		$btmh_color = $this->get_new_color($options['cci_btn_accept-hover'], 0.8);
		$border_color = $this->get_new_color( $options['cci_btn_accept-color'], 0.7 );
		$borderh_color = $this->get_new_color($options['cci_btn_accept-hover'], 0.7);
		$s = array(
				'[[font_family]]',
				'[[top_color]]',
				'[[btm_color]]',
				'[[border_color]]',
				'[[toph_color]]',
				'[[btmh_color]]',
				'[[borderh_color]]',
				'[[more_btn_color]]',
				'[[more_btn_hover]]'
		);
		$r = array(
				$options['cci_info_font-family'] .',',
				$options['cci_btn_accept-color'],
				$btm_color,
				$border_color,
				$options['cci_btn_accept-hover'],
				$btmh_color,
				$borderh_color,
				$options['cci_btn_morelink-color'],
				$options['cci_btn_morelink-hover']
		);
		file_put_contents(CCI_PLUGIN_PATH ."css/as_cci_style.css", str_replace($s, $r, $content)) ;
	}
	
	private function get_new_color( $cl, $prc ) {
		$cl = str_replace("#", "", $cl);
		$r = intval( hexdec( substr($cl, 0, 2) ) * $prc);
		$g = intval( hexdec( substr($cl, 2, 2) ) * $prc);
		$b = intval( hexdec( substr($cl, 4, 2) ) * $prc);
		$r = $r > 255 ? 255 : $r;
		$g = $g > 255 ? 255 : $g;
		$b = $b > 255 ? 255 : $b;
		return "#". (strlen( dechex($r) ) == 1 ? "0".dechex($r) : dechex($r)) . 
					(strlen( dechex($g) ) == 1 ? "0".dechex($g) : dechex($g)) . 
					(strlen( dechex($b) ) == 1 ? "0".dechex($b) : dechex($b));
	}
}
?>