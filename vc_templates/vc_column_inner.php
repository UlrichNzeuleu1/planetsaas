<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $width
 * @var $css
 * @var $offset
 * @var $content - shortcode content
 * 
 * @var $column_max_width
 * 
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Column_Inner
 */
$output = $_equal_height = $_text_middle = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$width = wpb_translateColumnWidthToSpan( $width );
$width = vc_column_offset_class_merge( $offset, $width );

$_column_max_width = (isset($column_max_width) && $column_max_width == true) ? 'style="max-width: 500px; width: auto; float: none; margin: 0 auto;"' : '';
$padding_class = (!empty($_column_max_width)) ? 'fes2-main-text-cont' : '';
$_equal_height = (isset($equal_height) && $equal_height == true) ? ' equal-height ' : '';
//$_text_middle = (isset($text_middle) && $text_middle == true) ? '  ' : '';

$css_classes = array(
	$this->getExtraClass( $el_class ),
	'wpb_column',
	'vc_custom_column_container',
	$width,
	vc_shortcode_custom_css_class( $css ),
);

$wrapper_attributes = array();

$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

$output .= '<div ' . implode( ' ', $wrapper_attributes ) . ' '.$_column_max_width.'>';
$output .= '<div class="wpb_wrapper '.$padding_class.$_equal_height.'">';
if ( (isset($text_middle) && $text_middle == true) ) $output .= '<div class="text-middle block-center-x-767">';
$output .= wpb_js_remove_wpautop( $content );
if ( (isset($text_middle) && $text_middle == true) ) $output .= '</div>';
$output .= '</div>' . $this->endBlockComment( '.wpb_wrapper' );
$output .= '</div>' . $this->endBlockComment( $this->getShortcode() );

echo $output;