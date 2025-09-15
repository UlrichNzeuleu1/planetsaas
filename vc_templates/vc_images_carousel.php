<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $onclick
 * @var $custom_links
 * @var $custom_links_target
 * @var $img_size
 * @var $images
 * @var $el_class
 * @var $mode
 * @var $slides_per_view
 * @var $wrap
 * @var $autoplay
 * @var $hide_pagination_control
 * @var $hide_prev_next_buttons
 * @var $speed
 * @var $partial_view
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_images_carousel
 */
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$gal_images = '';
$link_start = '';
$link_end = '';
$el_start = '';
$el_end = '';
$slides_wrap_start = '';
$slides_wrap_end = '';
$pretty_rand = $onclick == 'link_image' ? ' rel="prettyPhoto[rel-' . get_the_ID() . '-' . rand() . ']"' : '';

wp_enqueue_script('owl-carousel-cms');

/*if ( 'link_image' === $onclick ) {
	wp_enqueue_script( 'prettyphoto' );
	wp_enqueue_style( 'prettyphoto' );
}*/

$el_class = $this->getExtraClass( $el_class );

if ( '' === $images ) {
	$images = '-1,-2,-3';
}

if ( 'custom_link' === $onclick ) {
	$custom_links = explode( ',', $custom_links );
}

$images = explode( ',', $images );
$i = - 1;
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_images_carousel wpb_content_element vc_clearfix', $this->settings['base'], $atts );
$carousel_id = 'owl-images-carousel-' . WPBakeryShortCode_VC_images_carousel::getCarouselIndex();
$slider_width = $this->getSliderWidth( $img_size );
?>

<div id="<?php echo esc_attr($carousel_id) ?>" class="cms-carousel-wrapper owl-images-wrap <?php echo $paging_postition; ?>">
	<?php echo wpb_widget_title( array( 'title' => $title, 'extraclass' => 'wpb_gallery_heading' ) ) ?>
	<div class="cms-owl-carousel owl-carousel owl-theme" 
		 data-per-view ="<?php echo $slides_per_view ?>"
		 data-autoplay ="<?php echo 'yes' === $autoplay ? 'true' : 'false' ?>" 
	     data-pagination ="<?php echo 'yes' === $hide_pagination_control ? 'false' : 'true' ?>" 
	     data-nav ="<?php echo 'yes' === $hide_prev_next_buttons ? 'false' : 'true' ?>" 
	     data-loop="<?php echo 'yes' === $wrap ? 'true' : 'false' ?>" >
	     
		<?php foreach ( $images as $attach_id ): ?>
			<?php
			$i ++;
			if ( $attach_id > 0 ) {
				$post_thumbnail = wpb_getImageBySize( array(
					'attach_id' => $attach_id,
					'thumb_size' => $img_size
				) );
			} else {
				$post_thumbnail = array();
				$post_thumbnail['thumbnail'] = '<img src="' . vc_asset_url( 'vc/no_image.png' ) . '" />';
				$post_thumbnail['p_img_large'][0] = vc_asset_url( 'vc/no_image.png' );
			}
			$thumbnail = $post_thumbnail['thumbnail'];
			?>
			<div class="cms-image-item item <?php echo esc_attr($el_class); ?>">
				<?php if ( 'link_image' === $onclick ): ?>
					<?php $p_img_large = $post_thumbnail['p_img_large']; ?>
					<a class="prettyphoto"
					   href="<?php echo $p_img_large[0] ?>" <?php echo $pretty_rand; ?>>
						<?php echo $thumbnail ?>
					</a>
				<?php elseif ( 'custom_link' === $onclick && isset( $custom_links[ $i ] ) && '' !== $custom_links[ $i ] ): ?>
					<a
						href="<?php echo esc_attr($custom_links[ $i ]) ?>"<?php echo( ! empty( $custom_links_target ) ? ' target="' . $custom_links_target . '"' : '' ) ?>>
						<?php echo $thumbnail ?>
					</a>
				<?php else: ?>
					<?php echo $thumbnail ?>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
</div><?php echo $this->endBlockComment( '.cms-carousel-wrapper' ) ?>
<?php echo $this->endBlockComment( $this->getShortcode() ) ?>