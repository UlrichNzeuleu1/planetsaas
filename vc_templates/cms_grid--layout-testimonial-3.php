<?php 
    /* get categories */
        $taxo = 'category-testimonial';
        $_category = array();
        if(!isset($atts['cat']) || $atts['cat']=='') {
            $terms = get_terms($taxo);
            foreach ($terms as $cat){
                $_category[] = $cat->term_id;
            }
        } else {
            $_category  = explode(',', $atts['cat']);
        }
        $atts['categories'] = $_category;
?>
<div class="cms-grid-wraper cms-grid-testimonials cms-grid-testimonials-layout3 clearfix <?php echo esc_attr($atts['template']);?>" id="<?php echo esc_attr($atts['html_id']);?>">
    <div class="cms-grid <?php echo esc_attr($atts['grid_class']);?> cms-gird-testimonials-item-wrap row">
        <?php
        $posts = $atts['posts'];
        while($posts->have_posts()){
            $posts->the_post();

            $testimonials_meta = haswell_post_meta_data();
            ?>
            <div class="cms-grid-item cms-grid-item-testimonials <?php echo esc_attr($atts['item_class']);?>" >
                <div class="cms-testimonials-wrap">
                    <blockquote class="custom-blockquote">
                        <?php the_content(); ?>
                        <footer>
                            <?php the_title(); ?>
                            <cite title="<?php echo esc_attr($testimonials_meta->_cms_page_testimonial_position); ?>"><?php echo esc_attr($testimonials_meta->_cms_page_testimonial_position); ?></cite>
                        </footer>
                    </blockquote>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>