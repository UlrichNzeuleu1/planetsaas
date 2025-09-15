<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $style
 * @var $shape
 * @var $color
 * @var $custom_background
 * @var $custom_text
 * @var $size
 * @var $align
 * @var $link
 * @var $title
 * @var $button_block
 * @var $el_class
 * @var $outline_custom_color
 * @var $outline_custom_hover_background
 * @var $outline_custom_hover_text
 * @var $add_icon
 * @var $i_align
 * @var $i_type
 * @var $i_icon_fontawesome
 * @var $i_icon_openiconic
 * @var $i_icon_typicons
 * @var $i_icon_entypo
 * @var $i_icon_linecons
 * @var $i_icon_pixelicons
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Btn
 */
$a_href = $a_title = $a_target = '';
$styles = array();
$icon_wrapper = false;
$icon_html = false;
$attributes = array();

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

//parse link
$link = ( '||' === $link ) ? '' : $link;
$link = vc_build_link( $link );
$use_link = false;
if ( strlen( $link['url'] ) > 0 ) {
	$use_link = true;
	$a_href = $link['url'];
	$a_title = $link['title'];
	$a_target = strlen( $link['target'] ) > 0 ? $link['target'] : '_self';
}
$set_dark_bg_hover = (isset($atts['set_dark_bg_hover']) && $atts['set_dark_bg_hover'] == true) ? 'dark-hover' : '';
$wrapper_classes = array(
	'vc_btn3-container',
	$this->getExtraClass( $el_class ),
	$set_dark_bg_hover,
	'vc_btn3-' . $align
);

$shape = '';
$color_viewall = isset($atts['color_viewall']) ? $atts['color_viewall'] : '';
$button_classes = array(
	'vc_general',
	'cms-button',
	$size,
	$style,
	$color_viewall,
	$css_animation.' btn-icon-animate'
);

$button_html = (!empty($css_animation)) ? '<span class="button-text">'.$title.'</span>' : $title;

if ( '' === trim( $title ) ) {
	$button_classes[] = 'vc_btn3-o-empty';
	$button_html = '<span class="vc_btn3-placeholder">&nbsp;</span>';
}
if ( 'true' == $button_block && 'inline' !== $align ) {
	$button_classes[] = 'vc_btn3-block';
}
if ( 'true' === $add_icon ) {
	$button_classes[] = 'vc_btn3-icon-' . $i_align;
	vc_icon_element_fonts_enqueue( $i_type );

	if ( isset( ${"i_icon_" . $i_type} ) ) {
		if ( 'pixelicons' === $i_type ) {
			$icon_wrapper = true;
		}
		$icon_class = ${"i_icon_" . $i_type};
	} else {
		$icon_class = 'fa fa-adjust';
	}

	if ( $icon_wrapper ) {
		$icon_html = '<i class="vc_btn3-icon"><span class="vc_btn3-icon-inner ' . esc_attr( $icon_class ) . '"></span></i>';
	} else {
		$icon_html = '<i class="vc_btn3-icon ' . esc_attr( $icon_class ) . '"></i>';
	}

	$button_html .= ' ' . $icon_html;
}

$button_classes[] = $color;


//var_dump($color);
if ( $styles ) {
	$attributes[] = 'style="' . implode( ' ', $styles ) . '"';
}

$wrapper_classes = esc_attr( apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $wrapper_classes ) ), $this->settings['base'], $atts ) );

if ( $button_classes ) {
	$button_classes = esc_attr( apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $button_classes ) ), $this->settings['base'], $atts ) );
	$attributes[] = 'class="' . trim( $button_classes ) . '"';
}

if ( $use_link ) {
	$attributes[] = 'href="' . esc_url( trim( $a_href ) ) . '"';
	$attributes[] = 'title="' . esc_attr( trim( $a_title ) ) . '"';
	$attributes[] = 'target="' . esc_attr( trim( $a_target ) ) . '"';
}

$attributes = implode( ' ', $attributes );
?>
	<div class="cms-button-wrap <?php echo trim( $wrapper_classes ); ?>"><?php if ( $use_link ) {
	echo '<a ' . $attributes . '>' . $button_html . '</a>';
} else {
	echo '<button ' . $attributes . '>' . $button_html . '</button>';
} ?></div><?php echo $this->endBlockComment( $this->getShortcode() );