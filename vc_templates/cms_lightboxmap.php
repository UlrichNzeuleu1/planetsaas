<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $map_link
 * @var $image_thumbnail
 * @var $el_class
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Video
 */

$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if ( '' === $map_link ) {
	return null;
}

$el_class = $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'cms_map_lightbox ' . $el_class , $this->settings['base'], $atts );

if (!empty($atts['image_thumbnail'])) {
    $attachment_image = wp_get_attachment_image_src($atts['image_thumbnail'], 'full');
    $image_url = $attachment_image[0];
}
$map_content = '<a href="'.esc_url($map_link).'" class="cms-lightbox-map"><div class="map-img-thumb"><img src="'.esc_url($image_url).'" alt=""></div></a>';

$output .= "\n\t" . '<div class="' . esc_attr( $css_class ) . '">';
$output .= "\n\t\t" . '<div class="wpb_wrapper">';
$output .= $map_content;
$output .= "\n\t\t" . '</div> ' . $this->endBlockComment( '.wpb_wrapper' );
$output .= "\n\t" . '</div> ' . $this->endBlockComment( $this->getShortcode() );

echo $output;