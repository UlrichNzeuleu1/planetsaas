<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $el_class
 * @var $style
 * @var $color
 * @var $size
 * @var $open
 * @var $css_animation
 * @var $el_id
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Toggle
 */
$output = '';

$inverted = false;
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

// checking is color inverted
$style = str_replace( '_outline', '', $style, $inverted );
/**
 * class wpb_toggle removed since 4.4
 * @since 4.4
 */

$_bg_heading_style = (isset($bg_heading_style)) ? $bg_heading_style : '';

$elementClass = array(
	'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_toggle', $this->settings['base'], $atts ),
	// TODO: check this code, don't know how to get base class names from params
	'style' => 'vc_toggle_' . $style,
	'bg-style' => $_bg_heading_style,
	'inverted' => ( $inverted ) ? 'vc_toggle_color_inverted' : '',
	'open' => ( $open == 'true' ) ? 'vc_toggle_active' : '',
	'extra' => $this->getExtraClass( $el_class ),
	'css_animation' => $this->getCSSAnimation( $css_animation ), // @todo remove getCssAnimation as function in helpers
);

$elementClass = trim( implode( ' ', $elementClass ) );

?>
<div <?php echo isset( $el_id ) && ! empty( $el_id ) ? "id='" . esc_attr( $el_id ) . "'" : ""; ?>
	class="<?php echo esc_attr( $elementClass ); ?>">
	<div class="vc_toggle_title"><?php echo apply_filters( 'wpb_toggle_heading', '<h4><span class="link"></span>' . esc_html( $title ) . '</h4>', array(
			'title' => $title,
			'open' => $open
		) ); ?></div>
	<div class="vc_toggle_content"><?php echo wpb_js_remove_wpautop( apply_filters( 'the_content', $content ), true ); ?></div>
</div><?php echo $this->endBlockComment( $this->getShortcode() ); ?>