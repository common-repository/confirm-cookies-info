<?php
class as_cci_form_creator{
	public function get_form(){
		$content = file_get_contents( CCI_PLUGIN_PATH ."templates/html/setting_form.html" );
		$s = array(
			'{{formtable_row}}',
			'{{formbtn_value}}'
		);
		$c = array(
			$this->get_formtable_row(),
			__('Update Settings', 'confirm-cookies-info')
		);
		$content = str_replace( $s, 
 								$c, 
 								$content);
 		return $content;
	}
	
	private function get_formfield() {
		$options = get_option( 'as_cci_options' );
		return array(
				'section_general' 		=> array( '<h3 id="section_general" class="title">'. __('General Settings', 'confirm-cookies-info') .'</h3>', ''),
				'cci_display' 			=> array( __('Turn plugin ON/OFF', 'confirm-cookies-info'), $this->get_checkboxfield('cci_display', 1, intval($options['cci_display']), true) ),
				'cci_confirmedtime' 	=> array( __('When confirmation expires', 'confirm-cookies-info') ,$this->get_selectfield('cci_confirmedtime', $options['cci_confirmedtime']) ),
				'section_info' 			=> array( '<h3 id="section_info" class="title">'. __('Info Box Settings', 'confirm-cookies-info') .'</h3>', ''),
				'cci_info' 				=> array( __('Cookie Information', 'confirm-cookies-info'), $this->get_textareafield('cci_info', $options['cci_info'], 6) ),
				'cci_valign' 			=> array( __('Vertical align of info box', 'confirm-cookies-info'), $this->get_radiofield( 'cci_valign', array('top' => __('Top', 'confirm-cookies-info'), 'bottom' => __('Bottom', 'confirm-cookies-info')), $options['cci_valign'] )),
				'cci_halign' 			=> array( __('Horizontal align of info box', 'confirm-cookies-info'), $this->get_radiofield( 'cci_halign', array('left' => __('Left', 'confirm-cookies-info'), 'center' => __('Center', 'confirm-cookies-info'), 'right' => __('Right', 'confirm-cookies-info')), $options['cci_halign'] ) ),
				'cci_boxwidth' 			=> array( __('Infobox width', 'confirm-cookies-info'), $this->get_numberfield('cci_boxwidth', $options['cci_boxwidth'])),
				'cci_boxlrpadding' 		=> array( __('Padding left-right', 'confirm-cookies-info'), $this->get_numberfield('cci_boxlrpadding', $options['cci_boxlrpadding'])),
				'cci_boxtbpadding' 		=> array( __('Padding bottom-padding', 'confirm-cookies-info'), $this->get_numberfield('cci_boxtbpadding', $options['cci_boxtbpadding'])),
				'cci_boxbackground-color' => array( __('Infobox background color', 'confirm-cookies-info'), $this->get_colorfield('cci_boxbackground-color', $options['cci_boxbackground-color'])),
				'section_font' 			=> array( '<h3 id="section_font" class="title">'. __('Font Settings', 'confirm-cookies-info') .'</h3>', ''),
				'cci_info_font-size_type' => array( __('Set font size in', 'confirm-cookies-info'), $this->get_radiofield( 'cci_info_font-size_type', array('%' => __('Percents', 'confirm-cookies-info'), 'px' => __('Pixels', 'confirm-cookies-info')), $options['cci_info_font-size_type'] )),
				'cci_info_font-size' 	=> array( __('Font size', 'confirm-cookies-info'), $this->get_numberfield('cci_info_font-size', $options['cci_info_font-size'])),
				'cci_info_font-color' 	=> array( __('Font color', 'confirm-cookies-info'), $this->get_colorfield('cci_info_font-color', $options['cci_info_font-color'])),
				'cci_info_font-family'  => array( __('Font family', 'confirm-cookies-info'), $this->get_selectfield('cci_info_font-family', $options['cci_info_font-family'])),
				'section_btn_accept' 	=> array( '<h3 id="section_btn_accept" class="title">'. __('Button confirm Settings', 'confirm-cookies-info') .'</h3>', ''),
				'cci_btn_accept_label'  => array( __('Button accept label', 'confirm-cookies-info'), $this->get_inputfield('cci_btn_accept_label', $options['cci_btn_accept_label'])),
				'cci_btn_accept-color' 	=> array( __('Button accept color', 'confirm-cookies-info'), $this->get_colorfield('cci_btn_accept-color', $options['cci_btn_accept-color'])),
				'cci_btn_accept-hover' 	=> array( __('Button accept hover color', 'confirm-cookies-info'), $this->get_colorfield('cci_btn_accept-hover', $options['cci_btn_accept-hover'])),
				'section_btn_more' 		=> array( '<h3 id="section_btn_more" class="title">'. __('Button more link Settings', 'confirm-cookies-info') .'</h3>', ''),
				'cci_btn_more_label' 	=> array( __('Link more info label', 'confirm-cookies-info'), $this->get_inputfield('cci_btn_more_label', $options['cci_btn_more_label'])),
				'cci_btn_more_link'  	=> array( __('Link more URL', 'confirm-cookies-info'), $this->get_inputfield('cci_btn_morelink', $options['cci_btn_morelink'])),
				'cci_btn_morelink-color'=> array( __('Link more color', 'confirm-cookies-info'), $this->get_colorfield('cci_btn_morelink-color', $options['cci_btn_morelink-color'])),
				'cci_btn_morelink-hover'=> array( __('Link more hover color', 'confirm-cookies-info'), $this->get_colorfield('cci_btn_morelink-hover', $options['cci_btn_morelink-hover'])),
				//		'button'				=> array( '', $this->get_buttonfield( 'go_zamowienie', 'button', intval($row->id) > 0 ? 'Edytuj' : 'Dodaj'))
		);
	}
	
	private function get_checkboxfield( $name, $value, $ch=0, $alt = false ) {
		if( $alt ) {
			switch( $name ){
				case'cci_display':{
					$info = ($ch == 1 ? __('Plugin switched ON', 'confirm-cookies-info') : __('Plugin switched OFF', 'confirm-cookies-info'));
					break;
				}
				default:{
					$info = "";
					break;
				}
			}
			$span = '<span class="'. $name .'_info">'. $info .'</span>';
		}
		return '<input name="'. $name .'" type="checkbox" id="'. $name .'" value="'. $value .'" '. ($ch == 1 ? 'checked="checked"' : '') .' /> '. $span;
	}
	
	private function get_textareafield( $name, $value, $rows ) {
		return '<textarea name="'. $name .'" class="large-text" id="'. $name .'" rows="'. $rows .'">'. $value .'</textarea>';
	}
	
	private function get_inputfield( $name, $value, $req = "" ) {
		return '<input name="'. $name .'" type="text" id="'. $name .'" value="'. $value .'" class="large-text '. $req .'" />';
	}
	
	private function get_numberfield( $name, $value, $req = "" ) {
		return '<input name="'. $name .'" type="number" step="1" min="0" id="'. $name .'" value="'. $value .'" class="large-text '. $req .'" />';
	}
	
	private function get_colorfield( $name, $value, $req = "" ) {
		return '<input name="'. $name .'" type="color" id="'. $name .'" value="'. $value .'" class="large-text '. $req .'" />';
	}
	
	private function get_radiofield( $name, $vals, $ch_param ) {
		$ret = array();
		foreach( $vals as $k => $v ) {
			array_push($ret, '<input name="'. $name .'" type="radio" id="'. $name .'" value="'. $k .'" '. ( $ch_param == $k ? 'checked="checked"' : '' ) .' /> &nbsp;'.$v );
		}
		return implode('<br>', $ret);
	}
	
	private function get_selectfield( $name, $value, $req = "" ) {
		switch( $name ) {
			case'cci_info_font-family':{
				$lista = $this->get_fontslist($value);
				break;
			}
			case 'cci_confirmedtime':{
				$lista = $this->get_confirmedtime($value);
				break;
			}
			default:{
				$lista ="";
				break;
			}
		}
		return '<select id="'. $name .'" name="'. $name .'" class="large-text '. $req .'">
					'. $lista .'
				</select>';
	}
	
	private function get_buttonfield( $name, $type, $value ) {
		return '<input name="'. $name .'" type="'. $type .'" id="'. $name .'" value="'. $value .'" class="button button-primary" />';
	}
	
	private function get_fontslist( $curr ) {
		$fonts = array('Arial','Helvetica', 'sans-serif', 'Georgia', 'Serif', 'Palatino Linotype',
				'Book Antiqua', 'Times New Roman', 'Arial Black', 'Impact', 'Lucida Sans Unicode',
				'Tahoma', 'Verdana', 'Courier New', 'Lucida Console');
	
		$buffer = '<option value="0"> </option>';
		foreach( $fonts as $key => $val ) {
			$buffer .= '<option value="'. $val .'" '. ($curr == $val ? 'selected="selected"' : '') .'>'. $val .'</option>';
		}
		return $buffer;
	}
	
	private function get_confirmedtime( $curr ) {
		$times = array( 1 => __('One day', 'confirm-cookies-info'), 
						7 => __('One week', 'confirm-cookies-info'), 
						30 => __('One month', 'confirm-cookies-info'), 
						182 => __('Half year', 'confirm-cookies-info'), 
						365 => __('One year', 'confirm-cookies-info') 
		);	
		$buffer = '';
		foreach( $times as $key => $val ) {
			$buffer .= '<option value="'. $key .'" '. ($curr == $key ? 'selected="selected"' : '') .'>'. $val .'</option>';
		}
		return $buffer;
	}
	
	private function get_formtable_row() {
		$ff = $this->get_formfield();
		$buf = "";
		foreach( $ff as $k => $v ) {
			$sec = "";
			$tmp = explode("_", $k);
			if( $tmp[0] == "section" )
				$oldsec = $k;
			else
				$sec = 'class="'. $oldsec .' aktywne"';
			$content = file_get_contents( CCI_PLUGIN_PATH ."templates/html/formtable_row.html" );
			$s = array(
					'{{formrow_class}}',
					'{{formfield_id}}',
					'{{formfield_label}}',
					'{{formfield}}'
			);
			$r = array(
					$sec,
					$k,
					$v[0],
					$v[1]
			);
			$buf .= str_replace($s, $r, $content);
		}
		return $buf;
	}
}
?>