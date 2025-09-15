<div class="cms-grid-wraper <?php echo esc_attr($atts['template']);?> clearfix" id="<?php echo esc_attr($atts['html_id']);?>">
    <div class="row cms-grid <?php echo esc_attr($atts['grid_class']);?>">
        <?php
        $posts = $atts['posts'];
        while($posts->have_posts()){
            $posts->the_post();
            ?>
            <div class="cms-grid-item cms-blog-masonry <?php echo esc_attr($atts['item_class']);?>">
                <?php get_template_part( 'single-templates/blog-masonry/content', get_post_format() ); ?>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
    haswell_paging_nav();
    ?>
</div>