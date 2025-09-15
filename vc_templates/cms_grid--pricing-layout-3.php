<?php 
    /* get categories */
    $taxo = 'category-pricing';
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

    $cms_pricing_layout = !empty( $atts['cms_pricing_layout'] ) ? $atts['cms_pricing_layout'] : 'pr-default';
?>
<div class="cms-grid-wraper cms-grid-pricing cms-grid-pricing-layout3 clearfix" id="<?php echo esc_attr($atts['html_id']);?>">
    <div class="cms-grid <?php echo esc_attr($atts['grid_class']);?> cms-pricing-item-wrap row">
        <?php
        $posts = $atts['posts'];
        while($posts->have_posts()) {
            $posts->the_post();
            $pricing_meta = haswell_post_meta_data();
            ?>
            <div class="cms-grid-item cms-grid-item-pricing <?php echo esc_attr($atts['item_class']);?> <?php echo ( $pricing_meta->_cms_is_feature == 1 ) ? ' pricing-feature-item' : '' ?> mb-30">
                <div class="pricing-wrap">
                    <h1 class="cms-pricing-title <?php echo ( $pricing_meta->_cms_is_feature == 1 ) ? ' pr-feature' : '' ?>">
                        <?php the_title();?>
                    </h1>
                    <div class="price-heading <?php echo ( $pricing_meta->_cms_is_feature == 1 ) ? ' pr-feature' : '' ?>">
    					<span class="currency"><?php echo esc_attr($pricing_meta->_cms_value) ?></span><span class="price"><?php echo esc_attr($pricing_meta->_cms_price) ?></span>
    					<span class="cents-cont-wrap">
    						<span class="place">/ <?php echo esc_attr($pricing_meta->_cms_time) ?></span>
    					</span>	
    				</div>
    				<div class="price-content <?php echo ( $pricing_meta->_cms_is_feature == 1 ) ? ' pr-feature' : '' ?>">		
    					<ul>
    						<?php
                                for ($i=1; $i <= 10 ; $i++) { 
                                    $pricing_option = $pricing_meta->{"_cms_option".$i};
                                    if ( !empty( $pricing_option ) ) {
                                        $pricing_option = explode(' ', $pricing_option);
                                        echo '<li><b>'.$pricing_option[0].'</b> ';
                                        for ($j=1; $j <= count($pricing_option) ; $j++) { 
                                            if (isset($pricing_option[$j])) echo esc_attr($pricing_option[$j]);
                                        }
                                        echo '</li>';
                                    }
                                }
                            ?>
    					</ul>
    				</div>
    				<div class="price-button <?php echo ( $pricing_meta->_cms_is_feature == 1 ) ? ' pr-feature' : '' ?>">
    					<?php
                            if ( $pricing_meta->_cms_is_feature == 1 ) {
                                echo '<a class="cms-button gray" href=" '. esc_url($pricing_meta->_cms_button_url) .' ">'. esc_attr($pricing_meta->_cms_button_text) .'</a>';
                            } else {
                                echo '<a class="cms-button gray" href=" '. esc_url($pricing_meta->_cms_button_url) .' ">'. esc_attr($pricing_meta->_cms_button_text) .'</a>';
                            }
                        ?>
    				</div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>