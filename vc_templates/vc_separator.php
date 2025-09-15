<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $title_align
 * @var $el_width
 * @var $style
 * @var $title
 * @var $align
 * @var $color
 * @var $accent_color
 * @var $el_class
 * @var $layout
 * @var $border_width
 * Shortcode class
 * @var $this WPBakeryShortcode_Vc_Text_Separator
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$icon_name = $iconClass = $separator_type = $separator_hr_type = '';

if ( isset($atts['icon_type']) ) {
	$icon_name = "icon_" . $atts['icon_type'];
	$iconClass = isset($atts[$icon_name]) ? $atts[$icon_name] : '';
}
if ( isset($atts['separator_type']) ) {
	$separator_type = $atts['separator_type'];	
}

if ( isset($atts['separator_hr_type'])) {
	$separator_hr_type = $atts['separator_hr_type'];
}

$class = 'vc_separator wpb_content_element';

$class .= ( '' !== $el_width ) ? ' vc_sep_width_' . $el_width : ' vc_sep_width_100';
$class .= ( '' !== $style ) ? ' vc_sep_' . $style : '';
$class .= ( '' !== $border_width ) ? ' vc_sep_border_width_' . $border_width : '';
$class .= ( '' !== $align ) ? ' vc_sep_pos_' . $align : '';

if ( '' !== $color && 'custom' !== $color ) {
	$class .= ' vc_sep_color_' . $color;
}
$inline_css = ( 'custom' === $color && '' !== $accent_color ) ? ' style="' . vc_get_css_color( 'border-color', $accent_color ) . '"' : '';

$class .= $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );

$css_inline = array();
$css_inline['border_width'] = !empty($atts['border_width']) ? $atts['border_width'].'px' : '1px';
$css_inline['border_style'] = !empty($atts['style']) ? $atts['style'] : 'solid';
$css_inline['border_color'] = ($atts['color'] != 'custom') ? $atts['color'] : $accent_color;

?>
<?php if ($separator_type && $separator_type == 'divider' ): ?>
	<div class="divider <?php echo esc_attr( trim( $css_class ) ); ?>" style=" <?php echo (empty($iconClass)) ? 'height: '.$css_inline['border_width'].';' : '';  ?> border-top: <?php echo esc_attr($css_inline['border_width']) ?> <?php echo esc_attr($css_inline['border_style']) ?> <?php echo esc_attr($css_inline['border_color']) ?>">
		<?php if ($iconClass) : ?>
			<i class="<?php echo esc_attr($iconClass);?>"></i>
		<?php endif; ?>
	</div>
<?php elseif ($separator_type && $separator_type == 'hr' ) : ?>
	<hr class="<?php echo esc_attr($separator_hr_type) ?>" style="border-top: <?php echo esc_attr($css_inline['border_width']) ?> <?php echo esc_attr($css_inline['border_style']) ?> <?php echo esc_attr($css_inline['border_color']) ?>">
<?php endif ?>
<?php echo $this->endBlockComment( $this->getShortcode() ) . "\n";





