<?php 
    $icon_name = "icon_" . $atts['icon_type'];
    $iconClass = isset($atts[$icon_name])?$atts[$icon_name]:'';
    $item_class = 'cms-progress-item-wrap';
    $item_title     = $atts['item_title'];
    $show_value     = ($atts['show_value']=='true')?true:false;
    $value          = $atts['value'];
    $value_suffix   = $atts['value_suffix'];
    $bg_color       = $atts['bg_color'];
    $color          = $atts['color'];
    $width          = $atts['width'];
    $height         = $atts['height'];
    $border_radius  = $atts['border_radius'];
    $vertical       = ($atts['mode']=='vertical')?true:false;
    $striped        = ($atts['striped']=='yes')?true:false;
    $layout         = !empty($atts['style']) ? $atts['style'] : 'style1';
    $progressbar_bt_type         = !empty($atts['bootstrap_type']) ? $atts['bootstrap_type'] : '';
?>
<?php if ($layout != 'style3') : ?>
<div class="cms-progress-wraper <?php echo esc_attr($atts['template']);?>" id="<?php echo esc_attr($atts['html_id']);?>">
    <div class="cms-progress-body">
        <div class="<?php echo esc_attr($item_class. ' '.$layout );?>" <?php echo ($layout == 'style2') ? 'data-percent="'.$value.'" ': '' ?>>
            <?php if($iconClass):?>
                <i class="<?php echo esc_attr($iconClass);?>"></i>
            <?php endif;?>
            <div class="cms-progress progress<?php if($vertical){ echo ' vertical bottom'; } ?> <?php if($striped){echo ' progress-striped';}?>" 
                style="background-color:<?php echo esc_attr($bg_color);?>;
                width:<?php echo esc_attr($width);?>;
                height:<?php echo esc_attr($height);?>;
                border-radius:<?php echo esc_attr($border_radius);?>;
                " >

                <?php if ($layout == 'style1') : ?>
                    <div id="item-<?php echo esc_attr($atts['html_id']); ?>" 
                        class="progress-bar" role="progressbar" 
                        data-valuetransitiongoal="<?php echo esc_attr($value); ?>" 
                        style="background-color:<?php echo esc_attr($color);?>;"
                        >
                        <div class="cms-progress-title" style="<?php echo ($height) ? 'height:'.$height.'; line-height:'.$height : '' ?>">
                            <?php if($item_title):?>
                                <?php echo apply_filters('the_title',$item_title);?>
                            <?php endif;?>
                            <?php if($show_value): ?>
                                <?php echo esc_attr($value.$value_suffix);?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php elseif ($layout == 'style2') : ?>
                    <?php if($item_title):?>
                        <div class="cms-progress-title">
                            <span><?php echo apply_filters('the_title',$item_title);?></span>
                        </div>
                    <?php endif;?>
                    <div id="item-<?php echo esc_attr($atts['html_id']); ?>" 
                        class="progress-bar" role="progressbar" 
                        data-valuetransitiongoal="<?php echo esc_attr($value); ?>" 
                        style="background-color:<?php echo esc_attr($color);?>;"
                        >
                    </div>
                    <?php if($show_value): ?>
                        <div class="csm-bar-percent" style="<?php echo ($height) ? 'height:'.$height.'; line-height:'.$height : '' ?>"><?php echo esc_attr($value.$value_suffix);?></div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php elseif ($layout == 'style3') : ?>
    <div class="progress <?php echo esc_attr($layout); ?> <?php echo ($striped) ? 'progress-striped' : ''; ?>">
        <div style="width: <?php echo esc_attr($value); ?>%;" 
            aria-valuemax="100" 
            aria-valuemin="0" 
            aria-valuenow="<?php echo esc_attr($value); ?>" 
            role="progressbar" class="progress-bar <?php echo ($progressbar_bt_type) ? $progressbar_bt_type : ''; ?> <?php echo ($show_value) ? 'show_value' : ''; ?>">
            <span class="sr-only"><?php echo esc_attr($value.$value_suffix);?></span>
        </div>
    </div>
<?php endif; ?>