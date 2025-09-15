<?php
/* get categories */
$taxo = 'product_cat';
$_category = array();
if(!isset($atts['cat']) || $atts['cat']=='') {
    $terms = get_terms($taxo);
    foreach ($terms as $cat) {
        $_category[] = $cat->term_id;
    }
} else {
    $_category  = explode(',', $atts['cat']);
}
$atts['categories'] = $_category;

$gutter = (!empty($atts['cms_portfolio_gutter'])) ? $atts['cms_portfolio_gutter'] : 0;

$cms_portfolio_thumb = (isset($atts['cms_portfolio_thumb'])) ? $atts['cms_portfolio_thumb'] : '';
switch ($cms_portfolio_thumb) {
    case 'fixed_w':
        $thumb_size = 'blog-thumb';
        break;
    case 'square':
        $thumb_size = 'portfolio-square';
        break;
    default:
        $thumb_size = 'portfolio-wide';
        break;
}
$haswell_paging_nav = (isset($atts['cms_port_navigation'])) ? $atts['cms_port_navigation'] : false;
?>

<div class="cms-portfolio-no-padding cms-travel-wrap clearfix">
    <div class="cms-grid-wraper <?php echo esc_attr($atts['template']);?>" id="<?php echo esc_attr($atts['html_id']);?>" style="margin-left: -<?php echo esc_attr($gutter); ?>">
        <?php if($atts['filter']=="true" and $atts['layout']=='masonry'):?>
            <div class="cms-grid-filter">
                <ul class="cms-filter-category list-unstyled list-inline">
                    <li><a class="active" href="#" data-group="all"><?php esc_html_e('All Projects', 'haswell') ?></a></li>
                    <?php foreach($atts['categories'] as $category):?>
                        <?php $term = get_term( $category, $taxo );?>
                        <li><a href="#" data-group="<?php echo esc_attr('category-'.$term->slug);?>">
                                <?php echo esc_html($term->name);?>
                            </a>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
        <?php endif;?>
        <div class="cms-grid <?php echo esc_attr($atts['grid_class']);?>">
            <?php
            $posts = $atts['posts'];
            while($posts->have_posts()){
                $posts->the_post();
                $groups = array();
                $groups[] = '"all"';
                foreach(cmsGetCategoriesByPostID(get_the_ID(),$taxo) as $category){
                    $groups[] = '"category-'.$category->slug.'"';
                }
                global $product, $post;
                ?>
                <div <?php post_class('cms-travel-wrap cms-product pb-80 '.esc_attr($atts['item_class'])) ?> data-groups='[<?php echo implode(',', $groups);?>]'>
                    <div class="cms-woo-item-wrap" style="margin: 0 0 0 <?php echo esc_attr($gutter); ?>;">
                        <?php 
                            if(has_post_thumbnail() && !post_password_required() && !is_attachment() &&  wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), $thumb_size, false)):
                                $class = ' has-thumbnail';
                                $thumbnail = get_the_post_thumbnail(get_the_ID(), $thumb_size);
                            else:
                                $class = ' no-image';
                                $thumbnail = '<img src="'.esc_url(CMS_IMAGES).'no-image.jpg" alt="'.get_the_title().'" />';
                            endif;
                        ?>
                        <div class="cms-woo-image <?php echo esc_attr($class); ?>">
                            <?php if ( $product->is_on_sale() ) : ?>
                                <?php echo apply_filters( 'woocommerce_sale_flash', '<span class="cms-onsale">' . esc_html__( 'Sale!', 'haswell' ) . '</span>', $post, $product ); ?>
                            <?php endif; ?>
                            <?php echo '<a class="mb-25" href="'.esc_url(get_permalink($product->get_ID())).'">'.$thumbnail.'</a>'  ?>
                        </div>
                        <div class="cms-product-title">
                            <h3 class="mb-5">
                                <a href="<?php echo get_permalink(get_the_ID()); ?>"><?php the_title(); ?></a>
                            </h3>
                        </div>
                        <?php
                            do_action( 'woocommerce_after_shop_loop_item_title' );
                            do_action( 'woocommerce_after_shop_loop_item' ); 
                        ?>
                    </div>
                </div>
                <?php
                }
            ?>

        </div>
        <?php
            if ($haswell_paging_nav == true) {
                haswell_paging_nav();    
            }
        ?>
    </div>
</div>
    