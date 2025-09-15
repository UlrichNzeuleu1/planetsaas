<?php
global $smof_data;
/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $full_width
 * @var $full_height
 * @var $content_placement
 * @var $parallax
 * @var $parallax_image
 * @var $css
 * @var $el_id
 * @var $video_bg
 * @var $video_bg_url
 * @var $video_bg_parallax
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Row
 */
$output = $after_output = $row_style = $row_data = $video_style = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

//wp_enqueue_script( 'wpb_composer_front_js' );
$uqid = uniqid();

$el_class = $this->getExtraClass( $el_class );
$css_classes = array(
    'vc_row',
    'wpb_row', //deprecated
    'vc_row-fluid',
    'cshero_'. $uqid,
    $el_class,
    vc_shortcode_custom_css_class( $css ),
);

$wrapper_attributes = array();
// build attributes for wrapper
if ( ! empty( $row_id ) ) {
    $wrapper_attributes[] = 'id="' . esc_attr( $row_id ) . '"';
}

if ( ! empty( $full_height ) ) {
    $css_classes[] = ' vc_row-o-full-height';
    if ( ! empty( $content_placement ) ) {
        $css_classes[] = ' vc_row-o-content-' . $content_placement;
    }
}

if (!empty($cms_row_overflow)) {
    $css_classes[] = 'cms-over-hidden';
}

/* Overlay Row */
$html_overlay_row = '';
if($overlay_row == 'yes') {
    $html_overlay_row = '<div class="cms-overlay-color" style="background-color: '.$overlay_color.'; opacity: '.$overlay_opacity.';"></div>';
    $css_classes[] = 'row-overlay-color';
}
/* End Overlay Row */

/* Row Arrow */
$html_row_arrow = '';
if($row_arrow == true ) {
    $css_classes[] = 'row-arrow';
    $html_row_arrow = '<div class="arrow-in-home"><div class="arrow-in-home-inner"><a href="'. $cms_arrow_target .'" title=""><i class="icon icon-arrows-down" style="color: '. $cms_arrow_color .'"></i></a></div></div>';
}
/* End Row Arrow */

if ($row_mask_bg == true ) {
    $css_classes[] = 'row_mask_bg';
}

/* Link Color */
$link_style = '';
$class_link = ' .cshero_'.$uqid;
if($row_link_color || $row_link_color_hover || $row_head_color) {
    $link_style .= '<style type="text/css">';
    if($row_head_color){
        $link_style .= "".$class_link." h1,".$class_link." h2,".$class_link." h3,".$class_link." h4,".$class_link." h5,".$class_link." h6 {color: $row_head_color}";
    }
    if($row_link_color){
        $link_style .= "".$class_link." a{color: $row_link_color}";
    }
    if($row_link_color_hover){
        $link_style .= "".$class_link." a:hover{color: $row_link_color_hover}";
    }
    $link_style .= '</style>';
}
/* End Link Color */

/* Background effect */
$bg_effect = '';
if($bg_style == 'bg-effect-lg') {
    $css_classes[] = 'bg-effect-lg';
}

/* Class Animation For Row */
if ($animation) {
    wp_enqueue_script( 'waypoints');
    $css_classes[] = ' wpb_animate_when_almost_visible wpb_'.$animation;
}

/* Row Full Width */
if($full_width) {
    $css_classes[] = 'cms-row-full-width';
}

if (!empty($row_color)) {
    $row_style .= ' color: '.$row_color.'; ';
}

/* BG Style Image */
switch ($bg_style){
    case 'img_parallax':
        if(!empty($smof_data['paralax'])){
            $css_classes[] = 'cms_parallax';
            $row_data = " data-speed = $bd_p_speed";
            $row_style .= 'background-repeat: inherit; background-position: 50% 0; background-attachment:fixed;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;';
        }
        break;
    case 'img_fixed':
        $row_style .= 'background-attachment:fixed;background-repeat: no-repeat;';
        break;
    case 'hvideo':
        $css_classes[] = 'row-bg-video';
        $video_style = '<div class="cms-bg-video">'.do_shortcode('[video autoplay="on" loop="on" preload="none" height="0" width="0" mp4="'.$bg_video_mp4.'" webm="'.$bg_video_webm.'"]').'</div>';
        break;
}

if ($bg_style == 'img_fixed') {
    $css_classes[] = 'background-image-fixed';
}

if ($this->settings( 'base' ) === 'cms_row_inner') {
    $css_classes[] = 'cms_inner';
}
$style = ' style=" '.$row_style.' "';  //$this->buildStyle();
$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

?>

<div <?php echo implode( ' ', $wrapper_attributes ); ?> 
    <?php echo $style; ?>
    <?php if($data_offset) echo ' data-offset=" '.esc_attr($data_offset).' " '; ?> 
    <?php echo esc_attr($row_data); ?>>
    <?php echo ''.$html_overlay_row; ?>
    <?php echo ''.$video_style; ?>

    <?php if(!$full_width): ?><div class="container"><div class="row"><?php endif ; ?>
    <?php if($full_width): ?><div class="no-container"><div class="row"><?php endif ; ?>
    <?php echo wpb_js_remove_wpautop( $content ); ?>
    <?php if(!$full_width): ?></div></div><?php endif ; ?>
    <?php if($full_width): ?></div></div><?php endif ; ?>
    <?php echo ''.$link_style; ?>

    <?php echo ''.$html_row_arrow; ?>
</div>