<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $text
 * @var $link
 * @var $google_fonts
 * @var $font_container
 * @var $el_class
 * @var $css
 * @var $font_container_data - returned from $this->getAttributes
 * @var $google_fonts_data - returned from $this->getAttributes
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Custom_heading
 */
$output = $output_text = $css_class = $style = $custom_heading_type = $animate_class = $cms_custom_link_url = $rotator_effect = '';
$link = $text = $google_fonts = $font_container = $el_class = $css = $font_container_data = $google_fonts_data = '';
extract( $this->getAttributes( $atts ) );

extract( $this->getStyles( $el_class, $css, $google_fonts_data, $font_container_data, $atts ) );
$_cms_heading_type = (isset($atts['cms_custom_headding_type'])) ? $atts['cms_custom_headding_type'] : '';
$cms_heading_letter_spacing = (isset($atts['cms_heading_letter_spacing'])) ? $atts['cms_heading_letter_spacing'] : '';
$rotator_effect = (isset($atts['cms_rotator_effect'])) ? $atts['cms_rotator_effect'] : '';

$custom_heading_type = (isset($atts['cms_custom_headding_type'])) ? ' cms-custom-heading '.$atts['cms_custom_headding_type'].' cms-'.$font_container_data['values']['tag'] : '';
$animate_class = isset($atts['css_animation']) ? $atts['css_animation'] : '';
$cms_heading_specolor = (isset($atts['cms_heading_specolor']) && $atts['cms_heading_specolor'] == true) ? ' special-color ' : '';
$cms_heading_block = (isset($atts['cms_heading_block']) && $atts['cms_heading_block'] == true) ? ' dis-block ' : '';
$cms_link_style = (isset($atts['cms_link_style']) && $atts['cms_link_style'] == true) ? ' cms-link-style ' : '';
$settings = get_option( 'wpb_js_google_fonts_subsets' );
$subsets = '';
if ( is_array( $settings ) && ! empty( $settings ) ) {
	$subsets = '&subset=' . implode( ',', $settings );
}
if ( ! empty( $google_fonts_data ) && isset( $google_fonts_data['values']['font_family'] ) ) {
	wp_enqueue_style( 'vc_google_fonts_' . vc_build_safe_css_class( $google_fonts_data['values']['font_family'] ), '//fonts.googleapis.com/css?family=' . $google_fonts_data['values']['font_family'] . $subsets );
}
if ( ! empty( $styles ) ) {
	if(!empty($cms_heading_letter_spacing)){
		$styles[]="letter-spacing:".$cms_heading_letter_spacing;
	}
	$style = 'style="' . esc_attr( implode( ';', $styles ) ) . '"';
}
$tag_class="";
$output_text = $text;
if ( ! empty( $link ) && empty($cms_link_style)) {
	$link = vc_build_link( $link );
	$output_text = '<a href="' . esc_attr( $link['url'] ) . '"'
	               . ( $link['target'] ? ' target="' . esc_attr( $link['target'] ) . '"' : '' )
	               . ( $link['title'] ? ' title="' . esc_attr( $link['title'] ) . '"' : '' )
	               . '>' . $text . '</a>';
} else {
	if ( !empty($text) ) {

		$output_text_array = explode('|', $text);
		$_output_text = $_output_text_last = '';
		if (empty($_cms_heading_type)) {
			$output_text_array = explode('///', $text);
			for ($i=0; $i < count($output_text_array) ; $i++) {
				$_output_text .=  $output_text_array[$i].'<span class="slash-divider-10">/</span>';
			}
		} else {
			for ($i=0; $i < count($output_text_array) ; $i++) {
				if ($i + 1 == count($output_text_array)) {
					if ($_cms_heading_type == 'heading-inline-textbold-rotator' || $_cms_heading_type == 'heading-textbold-rotator') {
						if(count($output_text_array) >= 2 ){
							$text_rotator=explode(',', $output_text_array[1]);
							$_output_text_last =' <span class="cd-words-wrapper waiting">';
								foreach ($text_rotator as $key => $value) {
									if($key==0){
										$_output_text_last .='<b  class="is-visible">'.$value.'</b>';
									}else{
										$_output_text_last .='<b>'.$value.'</b>';
									}
									
								}
							$_output_text_last .=' </span">';
							$tag_class="cd-headline";
						}else{
							$_output_text_last = $output_text_array[$i];
						}
						
					}else{
						$_output_text_last = (count($output_text_array) >= 2 ) ? '<span class="bold">'.$output_text_array[$i].'</span>' : $output_text_array[$i];
					
					}
		
				} else {
					if ($_cms_heading_type == 'heading-underline-textbold' || $_cms_heading_type == 'heading-borderleft-textbold' || $_cms_heading_type == 'heading-textbold-rotator') {
						$_output_text.= $output_text_array[$i].'<br />';
					} else {
						$_output_text.= $output_text_array[$i].' ';
					}
					
				}
			}	
		}

		if ( ! empty( $link ) && !empty($cms_link_style)) {
			$link = vc_build_link( $link );
			$cms_custom_link_url = '<a class="cms-new-link" href="' . esc_attr( $link['url'] ) . '"'
	               . ( $link['target'] ? ' target="' . esc_attr( $link['target'] ) . '"' : '' )
	               . ( $link['title'] ? ' title="' . esc_attr( $link['title'] ) . '"' : '' )
	               . '>' . esc_attr( $link['title'] ) . '</a>';
		}

		$output_text = $_output_text.$_output_text_last.$cms_custom_link_url;
	}
}

$output .= '<div class="' . esc_attr( $css_class .$custom_heading_type. ' '.$animate_class. $cms_heading_specolor.$cms_heading_block.$cms_link_style.' '.$rotator_effect ) . '" >';
$output .= '<' . $font_container_data['values']['tag'] . ' ' . $style . ' class="cms-heading-inner '.$tag_class.'" >';
$output .= $output_text;
$output .= '</' . $font_container_data['values']['tag'] . '>';
$output .= '</div>';

$output .= $this->endBlockComment( $this->getShortcode() );

echo $output;