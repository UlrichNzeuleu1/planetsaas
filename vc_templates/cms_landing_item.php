<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $landing_title
 * @var $image_thumbnail
 * @var $link
 * @var $css_animation
 * @var $css_animation_delay
 * @var $el_class
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_cms_landing_item
 */

$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$wrapper_classes = array(
	$this->getExtraClass( $el_class ),
	$atts['css_animation'],
	'pb-70'
);
$wrapper_classes = esc_attr( apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $wrapper_classes ) ), $this->settings['base'], $atts ) );
$thumbnail = '';
if( !empty($atts['image_thumbnail']) ):
    $thumbnail = wp_get_attachment_url($atts['image_thumbnail']);
else:
    $thumbnail = CMS_IMAGES.'no-image.jpg';
endif;  

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

$attributes = array();
if ( $use_link ) {
	$attributes[] = 'href="' . esc_url( trim( $a_href ) ) . '"';
	$attributes[] = 'title="' . esc_attr( trim( $a_title ) ) . '"';
	$attributes[] = 'target="' . esc_attr( trim( $a_target ) ) . '"';

	$attributes = implode( ' ', $attributes );
}
?>

<div class="cms-lading-wrap <?php echo trim( $wrapper_classes ); ?>" data-wow-delay="<?php echo esc_attr($atts['css_animation_delay']) ?>">
	<div class="landing-thumb-wrap">
		<a <?php echo (!empty($attributes)) ? $attributes : 'href="#"'; ?>>
			<img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($atts['landing_title']) ?>">
		</a>
	</div>
	<div class="landing-text text-center">
		<h3>
			<a href="<?php echo esc_url($link['url']); ?>" >
				<?php echo esc_attr($atts['landing_title']) ?>
			</a>
		</h3>
	</div>
</div>