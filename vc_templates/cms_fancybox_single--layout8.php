<?php
/**
 *
 * @var $atts
 *
 */
// init value
$image=wp_get_attachment_url($atts['image']);
if( isset($atts['link']) && !empty($atts['link'])){
	$link =$atts['link'];
}else{
	$link='#';
}

if (!empty($image)) {
    ?>
    <div
        class="woo-category-item <?php echo (isset($atts['custom_title']) && $atts['custom_title'] == true) ? 'custom-title bold' : '' ?>"
        id="<?php echo esc_attr($atts['html_id']); ?>">
        <a href="<?php echo esc_url($link); ?>">
            <img class="woo-category-thumb" src="<?php echo esc_url($image); ?>"
                 alt="">

            <div class="category-info">
                
                    <h4 class="category-name <?php echo (isset($atts['custom_title']) && $atts['custom_title'] == true) ? ' bold' : '' ?>">
                        <?php echo apply_filters('the_title', $atts['title_item']); ?>
                    </h4>

            </div>
        </a>
    </div>
    <?php
}