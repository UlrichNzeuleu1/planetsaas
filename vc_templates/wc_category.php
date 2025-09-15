<?php
/**
 *
 * @var $atts
 *
 */
// init value
if (!empty($atts['category'])) {
    $category = get_term_by('id', $atts['category'], 'product_cat');
    //var_dump( $category );
    $category_thumbnail = get_woocommerce_term_meta($category->term_id, 'thumbnail_id', true);
    $image = wp_get_attachment_url($category_thumbnail);
    $wc_custom_text = '';
    if (isset($atts['wc_custom_text']) && !empty($atts['wc_custom_text']) ) {
        $wc_custom_text = $atts['wc_custom_text'];
    }
    if($category) {
        ?>
        <div
            class="woo-category-item <?php echo (isset($atts['wc_custom']) && $atts['wc_custom'] == true) ? 'custom-title' : '' ?>"
            id="<?php echo esc_attr($atts['html_id']); ?>">
            <a href="<?php echo get_term_link($category->slug, 'product_cat') ?>">
                <img class="woo-category-thumb" src="<?php echo esc_url($image); ?>"
                     alt="<?php echo esc_attr($category->name); ?>">

                <div class="category-info">
                    <?php if (isset($atts['wc_custom']) && $atts['wc_custom'] == true) : ?>
                        <h4 class="category-name">
                            <?php echo apply_filters('the_title', $atts['wc_custom_text']); ?>
                        </h4>
                    <?php else: ?>
                        <h4 class="category-name">
                            <?php echo apply_filters('the_title', $category->name); ?>
                        </h4>
                        <div class="category-desc">
                            <?php echo apply_filters('the_content', $category->description) ?>
                        </div>
                    <?php endif; ?>

                </div>
            </a>
        </div>
        <?php
    }
}