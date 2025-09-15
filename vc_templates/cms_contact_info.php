<?php
    $icon_name = $iconClass = $animate_class = $icon_font_size = '';
    $icon_name = "icon_" . $atts['icon_type'];
    $iconClass = isset($atts[$icon_name])?$atts[$icon_name]:'';
    $animate_class = isset($atts['css_animation']) ? $atts['css_animation'] : '';
    $css_animation_delay = isset($atts['css_animation_delay']) ? $atts['css_animation_delay'] : '0ms'; 
?>
<div data-wow-delay="<?php echo esc_attr($css_animation_delay); ?>" class="cms-contact-info-wraper cms_contact_info <?php echo esc_attr($atts['template']);?> <?php echo esc_attr($animate_class); ?> clearfix" >
    <div class="cms-contact-info-body">
        <?php if (!empty($iconClass)) : ?>
            <div class="contact-info-box-icon">
                <i class="<?php echo esc_attr($iconClass);?>"></i>
            </div>
        <?php endif; ?>
        <?php if($content): ?>
            <div class="contact-info-box-content">
                <?php if($atts['title']): ?>
                    <h3 class="contact-info-title"><?php echo apply_filters('the_title',$atts['title']);?></h3>

                <?php endif;?>
                <?php echo apply_filters('the_content',$content);?>
            </div>
        <?php endif; ?>
    </div>
</div>