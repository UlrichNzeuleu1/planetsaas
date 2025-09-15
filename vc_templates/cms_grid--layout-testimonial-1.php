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
<div class="cms-grid-wraper cms-grid-testimonials cms-grid-testimonials-layout1 clearfix <?php echo esc_attr($atts['template']);?>" id="<?php echo esc_attr($atts['html_id']);?>">
    <div class="cms-grid <?php echo esc_attr($atts['grid_class']);?> cms-gird-testimonials-item-wrap row">
        <?php
        $posts = $atts['posts'];
        while($posts->have_posts()){
            $posts->the_post();

            $testimonials_meta = haswell_post_meta_data();
            ?>
            <div class="cms-grid-item cms-grid-item-testimonials <?php echo esc_attr($atts['item_class']);?>" >
                <div class="cms-testimonials-wrap mb-30">
                    <div class="cms-icon-container-bg">
                        <div class="cms-icon-container">
                            <span class="icon_quotations main-menu-icon" aria-hidden="true"></span>
                        </div>
                    </div>
                    
                    <div class="cms-testimonial-inner cms-main-container-bg">
                        <div class="cms-main-container clearfix">
                            <div class="cms-text-container">
                                <div><?php echo haswell_content_max_charlength(get_the_content(), 137); ?></div>
                                <div class="text-right t-a-container mt-10">
                                    <span class="author-testimonial"><?php the_title(); ?></span>
                                    <span class="quote-author-description"><?php echo esc_attr($testimonials_meta->_cms_page_testimonial_position); ?></span>
                                </div>
                            </div>
                            <div class="cms-img-container">
                                <?php 
                                    if(has_post_thumbnail() && !post_password_required() && !is_attachment()):
                                        $class = 'has-thumbnail cms-grid-testimonials-media';
                                        $thumbnail = get_the_post_thumbnail(get_the_ID(), 'thumbnail');
                                    else:
                                        $class = ' no-image cms-grid-testimonials-media';
                                        $thumbnail = '<img src="'.esc_url(CMS_IMAGES).'no-image.jpg" alt="'.get_the_title().'" />';
                                    endif;

                                    echo $thumbnail;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>