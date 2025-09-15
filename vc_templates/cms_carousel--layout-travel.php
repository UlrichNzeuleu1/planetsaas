<div class="cms-carousel-default cms-carousel-travel cms-carousel owl-carousel <?php echo esc_attr($atts['template']);?>" id="<?php echo esc_attr($atts['html_id']);?>">
    <?php
    $posts = $atts['posts'];
    while($posts->have_posts()){
        $posts->the_post();
        global $post, $product;
        $hot_place = get_post_meta( get_the_ID(), '_travel_is_hot_place', true );
        ?>
        <div class="cms-carousel-item">
            <?php 
                if(has_post_thumbnail() && !post_password_required() && !is_attachment() &&  wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'team-square', false)):
                    $class = ' has-thumbnail';
                    $thumbnail = get_the_post_thumbnail(get_the_ID(),'team-square');
                else:
                    $class = ' no-image';
                    $thumbnail = '<img src="'.esc_url(CMS_IMAGES).'no-image.jpg" alt="'.get_the_title().'" />';
                endif;
            ?>
            <div class="cms-grid-media <?php echo esc_attr($class); ?>">
                <?php echo '<a class="mb-25" href="'.esc_url(get_permalink($product->get_ID())).'">'.$thumbnail.'</a>'  ?>
                <?php if ( $product->is_on_sale() ) : ?>
                    <?php echo apply_filters( 'woocommerce_sale_flash', '<span class="cms-onsale">' . esc_html__( 'HOT', 'haswell' ) . '</span>', $post, $product ); ?>
                <?php endif; ?>
            </div>
            <div class="cms-carousel-title text-center mb-5">
                <a href="<?php echo esc_url(get_permalink($product->get_ID())) ?>">
                    <?php the_title();?>    
                </a>
            </div>
            <div class="cms-travel-price text-center">
                <p class="price"><?php echo $product->get_price_html(); ?></p>
            </div>
        </div>
        <?php
    }
    ?>
</div>