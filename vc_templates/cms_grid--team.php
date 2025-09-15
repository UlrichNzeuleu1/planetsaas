<?php
    /* get categories */
    $taxo = 'category';
    $_category = array();
    if(!isset($atts['cat']) || $atts['cat']==''){
        $terms = get_terms($taxo);
        foreach ($terms as $cat){
            $_category[] = $cat->term_id;
        }
    } else {
        $_category  = explode(',', $atts['cat']);
    }
    $atts['categories'] = $_category;
    $team_thumb_size = (isset($atts['cms_team_thumb']) && $atts['cms_team_thumb'] == 'square') ? 'team-square' : 'team';

    /* View all */
    $cms_viewall_text = $cms_viewall_link = $cms_viewall_style = '';
    if (isset($atts['cms_viewall']) && $atts['cms_viewall'] == true) {
        $cms_viewall_text = isset($atts['cms_viewall_text']) ? $atts['cms_viewall_text'] : '';
        $cms_viewall_link = isset($atts['cms_viewall_link']) ? $atts['cms_viewall_link'] : '';
        $cms_viewall_style = isset($atts['cms_viewall_style']) ? $atts['cms_viewall_style'] : '';
    }
?>
<div class="cms-grid-wraper <?php echo esc_attr($atts['template']);?>" id="<?php echo esc_attr($atts['html_id']);?>">
    <div class="row cms-grid <?php echo esc_attr($atts['grid_class']);?>">
        <?php
        $posts = $atts['posts'];
        $j = 0;
        while($posts->have_posts()) {
            $posts->the_post();
            $team_meta = haswell_post_meta_data();
            ?>
            <div class="cms-grid-team <?php echo esc_attr($atts['item_class']);?> wow fadeInUp mb-30" data-wow-delay="<?php echo (200*$j)?>ms">
                <?php 
                    if(has_post_thumbnail() && !post_password_required() && !is_attachment() &&  wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), $team_thumb_size, false)):
                        $class = ' has-thumbnail';
                        $thumbnail = get_the_post_thumbnail(get_the_ID(), $team_thumb_size);
                    else:
                        $class = ' no-image';
                        $thumbnail = '<img src="'.esc_url(CMS_IMAGES).'no-image.jpg" alt="'.get_the_title().'" />';
                    endif;
                    echo '<div class="cms-grid-media '.esc_attr($class).'">'.$thumbnail.'</div>';
                ?>
                <h3 class="cms-grid-title">
                    <?php the_title();?>
                </h3>
                <?php if (!empty($team_meta->_cms_page_team_position)):?>
                    <span><?php echo esc_attr($team_meta->_cms_page_team_position); ?></span>
                <?php endif; ?>
                <ul class="team-social">
                    <?php
                        for($i=1;$i<7;$i++) {
                            $icon = $team_meta->{"_cms_icon".$i};
                            $link = $team_meta->{"_cms_link".$i};
                            if(!empty($icon) && !empty($link)): ?>
                                <li>
                                    <a href="<?php echo esc_attr($link);?>"><span class="<?php echo esc_attr($icon);?>" aria-hidden="true"></span></a>
                                </li>
                            <?php endif;
                        }
                    ?>    
                </ul>
            </div>
            <?php
            $j++;
        }
        ?>
    </div>
</div>
<?php if (isset($atts['cms_viewall']) && $atts['cms_viewall'] == true) : ?>
    <div class="cms-grid-viewall">
        <div class="cms-button-wrap">
            <a target="_self" title="" href="<?php echo esc_url($cms_viewall_link); ?>" class="vc_general cms-button md cms-viewall cms-viewall-grid <?php echo esc_attr($cms_viewall_style); ?> btn-icon-animate vc_btn3-block"><span><?php echo esc_attr($cms_viewall_text); ?></span></a>
        </div>
    </div>
<?php endif; ?>
