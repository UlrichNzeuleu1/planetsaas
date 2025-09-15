<?php 
    $icon_name = "icon_" . $atts['icon_type'];
    $iconClass = isset($atts[$icon_name])?$atts[$icon_name]:'';
    $sub_title = isset($atts['cms_fancybox_subtitle']) ? $atts['cms_fancybox_subtitle'] : '';
   
?>
<div class="cms-fancyboxes-wraper <?php echo esc_attr($atts['template']);?>" id="<?php echo esc_attr($atts['html_id']);?>">
    <?php if($atts['title']!=''):?>
        <div class="cms-fancyboxes-head">
            <div class="cms-fancyboxes-title">
                <?php echo apply_filters('the_title',$atts['title']);?>
            </div>
            <div class="cms-fancyboxes-description">
                <?php echo apply_filters('the_content',$atts['description']);?>
            </div>
        </div>
    <?php endif;?>
    <div class="row cms-fancyboxes-body">

        <div class="col-md-4 maintenance-icon-container">
            <?php if(!empty($iconClass)):?>
                <i class="<?php echo esc_attr( $iconClass );?>"></i>
            <?php endif;?>
        </div>
        <div class="col-md-8 maintenance-text-container">
            <?php if($atts['title_item']):?>
                <h1 class="title">
                    <?php echo apply_filters('the_title',$atts['title_item']);?>
                </h1>
            <?php endif;?>
            <?php if($atts['sub_title']):?>
                <h2 class="sub_title">
                    <?php echo esc_attr( $sub_title );?>
                </h2>
            <?php endif;?>
            <?php if($atts['description_item']): ?>
            <div class="fancy-box-content">
                <p>
                <?php echo esc_attr($atts['description_item']);?>
                <span class="mail">
                    <?php
                    $class_btn = ($atts['button_type']=='button')?'btn btn-large':'';
                    ?>
                    <a href="<?php echo esc_url($atts['button_link']);?>" class="<?php echo esc_attr($class_btn);?>"><?php echo esc_attr($atts['button_text']);?></a>
                </span>
                </p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>