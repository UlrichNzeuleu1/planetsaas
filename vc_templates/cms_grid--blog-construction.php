<div class="cms-grid-wraper cms-blog-construction-wrap <?php echo esc_attr($atts['template']);?> clearfix" id="<?php echo esc_attr($atts['html_id']);?>">
    <div class="row cms-grid <?php echo esc_attr($atts['grid_class']);?>">
        <?php
        $posts = $atts['posts'];
        $j = 0;
        $sub_title = '';
        while($posts->have_posts()) {
            $posts->the_post(); global $post;
            if (!empty($post->ID) && get_post_meta($post->ID, 'post_subtitle', true)) {
                $sub_title = get_post_meta($post->ID, 'post_subtitle', true);
            }
            ?>
            <div class="cms-grid-item cms-contruction-item <?php echo esc_attr($atts['item_class']);?>">
                <article id="post-<?php the_ID(); ?>" <?php post_class('cms-blog-item wow fadeIn pb-70 clearfix'); ?> data-wow-delay="<?php echo esc_attr($j*200); ?>ms">
                    <div class="entry-feature entry-feature-image mb-30"><?php the_post_thumbnail( 'portfolio-wide' ); ?></div>
                    <header class="entry-header">
                        <h3 class="entry-title">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        <p><?php echo esc_attr($sub_title); ?></p>
                    </header>
                    <div class="entry-content">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
            </div>
            <?php
            $j++;
        }
        ?>
    </div>
</div>
