<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $type
 * @var $onclick
 * @var $custom_links
 * @var $custom_links_target
 * @var $img_size
 * @var $images
 * @var $el_class
 * @var $interval
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_gallery
 */
$thumbnail = '';
$title = $source = $type = $onclick = $custom_links = $custom_links_target = $img_size = $external_img_size = $images = $custom_srcs = $el_class = $el_id = $interval = $css = $css_animation = ''; 
$output = '';
$large_img_src = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
  
$default_src = vc_asset_url( 'vc/no_image.png' );
$gal_images = '';
$link_start = '';
$link_end = '';
$el_start = '';
$el_end = '';
$slides_wrap_start = '';
$slides_wrap_end = '';
$cms_special_img = '';

$el_class = $this->getExtraClass( $el_class );
if ( 'nivo' === $type ) {
	$type = ' wpb_slider_nivo theme-default';
	wp_enqueue_script( 'nivo-slider' );
	wp_enqueue_style( 'nivo-slider-css' );
	wp_enqueue_style( 'nivo-slider-theme' );

	$slides_wrap_start = '<div class="nivoSlider">';
	$slides_wrap_end = '</div>';
} elseif ( 'flexslider' === $type || 'flexslider_fade' === $type || 'flexslider_slide' === $type || 'fading' === $type ) {
	$el_start = '<li>';
	$el_end = '</li>';
	$slides_wrap_start = '<ul class="slides">';
	$slides_wrap_end = '</ul>';
	wp_enqueue_style( 'flexslider' );
	wp_enqueue_script( 'flexslider' );
} else if ( 'image_grid' === $type ) {
	wp_enqueue_script( 'vc_grid-js-imagesloaded' );
	wp_enqueue_script( 'isotope' );
	$cls_here = 'cms-popup-gallery';
	if ( 'custom_link' === $onclick ) 
		$cls_here = '';
	$el_start = '<li class="isotope-item">';
	$el_end = '</li>';
	$slides_wrap_start = '<ul class="wpb_image_grid_ul '.$cls_here.'">';
	$slides_wrap_end = '</ul>';
} else if ( 'cms_special' === $type) {
	$el_start = '<div class="fes9-img-center">';
	$el_end = '</div>';
	$slides_wrap_start = '<div class="fes9-img-center clearfix">';
	$slides_wrap_end = '</div>';
}

if ( 'link_image' === $onclick ) {
	wp_enqueue_script( 'prettyphoto' );
	wp_enqueue_style( 'prettyphoto' );
}

$flex_fx = '';
if ( 'flexslider' === $type || 'flexslider_fade' === $type || 'fading' === $type ) {
	$type = ' wpb_flexslider flexslider_fade flexslider';
	$flex_fx = ' data-flex_fx="fade"';
} elseif ( 'flexslider_slide' === $type ) {
	$type = ' wpb_flexslider flexslider_slide flexslider';
	$flex_fx = ' data-flex_fx="slide"';
} elseif ( 'image_grid' === $type ) {
	$type = ' wpb_image_grid';
}

if ( '' === $images ) {
	$images = '-1,-2,-3';
}

$pretty_rel_random = ' data-rel="prettyPhoto[rel-' . get_the_ID() . '-' . rand() . ']"';

if ( 'custom_link' === $onclick ) {
	$custom_links = vc_value_from_safe( $custom_links );
	$custom_links = explode( ',', $custom_links );
}

switch ( $source ) {
	case 'media_library':
		$images = explode( ',', $images );
		break;

	case 'external_link':
		$images = vc_value_from_safe( $custom_srcs );
		$images = explode( ',', $images );

		break;
}
$j = 1;
foreach ( $images as $i => $image ) {
	switch ( $source ) {
		case 'media_library':
			if ( $image > 0 ) {
				$img = wpb_getImageBySize( array(
					'attach_id' => $image,
					'thumb_size' => $img_size,
				) );
				$thumbnail = $img['thumbnail'];
				$large_img_src = $img['p_img_large'][0];
			} else {
				$large_img_src = $default_src;
				$thumbnail = '<img src="' . $default_src . '" />';
			}
			break;

		case 'external_link':
			$image = esc_attr( $image );
			$dimensions = vcExtractDimensions( $external_img_size );
			$hwstring = $dimensions ? image_hwstring( $dimensions[0], $dimensions[1] ) : '';
			$thumbnail = '<img ' . $hwstring . ' src="' . $image . '" />';
			$large_img_src = $image;
			break;
	}
	  
	$link_start = $link_end = '';
	switch ( $onclick ) {
		case 'img_link_large':
			$link_start = '<a href="' . $large_img_src . '" target="' . $custom_links_target . '">';
			$link_end = '</a>';
			break;

		case 'link_image':
			$link_start = '<a class="lightbox" href="' . esc_url($large_img_src) . '">';
			$link_end = '</a>';
			break;

		case 'custom_link':
			if ( ! empty( $custom_links[ $i ] ) ) {
				$link_start = '<a href="' . $custom_links[ $i ] . '"' . ( ! empty( $custom_links_target ) ? ' target="' . $custom_links_target . '"' : '' ) . '>';
				$link_end = '</a>';
			}
			break;
	}
	 
	$gal_images .= $el_start . $link_start . $thumbnail . $link_end . $el_end;

	if ('cms_special' === $type) {
		$cms_special_img .= '<img class="wow fadeInUp" data-wow-duration="1s" data-wow-delay="'.(150*$j).'ms" src="'.esc_url($large_img_src).'" alt="image">';
	}
	$j = $j+2;
}

if ('cms_special' === $type) {
	
	$output .= $el_start;
	$output .= $cms_special_img;
	$output .= $el_end;

} else {
	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_gallery wpb_content_element' . $el_class . ' vc_clearfix', $this->settings['base'], $atts );
	$output .= "\n\t" . '<div class="' . $css_class . '">';
	$output .= "\n\t\t" . '<div class="wpb_wrapper">';
	$output .= wpb_widget_title( array( 'title' => $title, 'extraclass' => 'wpb_gallery_heading' ) );
	$output .= '<div class="wpb_gallery_slides' . $type . '" data-interval="' . $interval . '"' . $flex_fx . '>' . $slides_wrap_start . $gal_images . $slides_wrap_end . '</div>';
	$output .= "\n\t\t" . '</div> ' . $this->endBlockComment( '.wpb_wrapper' );
	$output .= "\n\t" . '</div> ' . $this->endBlockComment( $this->getShortcode() );	
}

echo $output;