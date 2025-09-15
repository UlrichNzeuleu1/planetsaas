<div class="cms-carousel owl-carousel cms-carousel-testimonial-layout1 <?php echo esc_attr($atts['template']);?> p-80-cont pt-40" id="<?php echo esc_attr($atts['html_id']);?>">
    <?php
    $posts = $atts['posts'];
    while($posts->have_posts()){
        $posts->the_post();
        $testimonials_meta = haswell_post_meta_data();
        $show_avatar = isset($atts['cms_testimonial_show_avatar']) ? $atts['cms_testimonial_show_avatar'] : 'none'; 
    ?>
        <div class="cms-carousel-item <?php echo (is_singular('portfolio') || (isset($atts['cms_testimonial_container']) && $atts['cms_testimonial_container'] == true )) ? ' container ' : '';  ?>">
            <?php if ($show_avatar == 'y') : ?>
                <div class="row <?php echo (is_singular('portfolio') || (isset($atts['cms_testimonial_container']) && $atts['cms_testimonial_container'] == true )) ? '' : ' plr-50 ';  ?>">
                    <div class="col-md-7">
                        <blockquote class="testimonial-2">
                            <?php the_content(); ?>
                        </blockquote>
                    </div>
                    <div class="col-md-4 col-md-offset-1">
                        <div class="cms-author-cont">
                            <div class="cms-author-info">
                                <div class="cms-name">
                                    <span class="bold"><b><?php the_title();?></b></span>
                                </div>
                                <div class="cms-type"><?php echo esc_attr($testimonials_meta->_cms_page_testimonial_position); ?></div>
                            </div>
                            <div class="cms-author-img">
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
            <?php else : ?>
                <div class="row <?php echo (!is_singular('portfolio')) ? ' plr-50 ': '';  ?>">
                    <div class="col-md-12">
                        <blockquote class="testimonial-2">
                            <?php the_content(); ?>
                            <footer>
                                <?php the_title(); ?>
                                <cite title="<?php echo esc_attr($testimonials_meta->_cms_page_testimonial_position); ?>"><?php echo esc_attr($testimonials_meta->_cms_page_testimonial_position); ?></cite>
                            </footer>
                        </blockquote>
                    </div>
                </div>
            <?php endif; ?> 
        </div>
        <?php //the_terms( get_the_ID(), 'categories-testimonial', '', ' / ' ); ?>
        <?php
    }
    ?>
</div>