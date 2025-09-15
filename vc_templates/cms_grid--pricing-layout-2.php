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
<div class="cms-grid-wraper cms-grid-pricing cms-grid-pricing-layout2 row" id="<?php echo esc_attr($atts['html_id']);?>">
    <div class="cms-grid <?php echo esc_attr($atts['grid_class']);?> cms-pricing-item-wrap">
        <?php
        $posts = $atts['posts'];
        while($posts->have_posts()) {
            $posts->the_post();
            $pricing_meta = haswell_post_meta_data();
            ?>
            <div class="cms-grid-item cms-grid-item-pricing <?php echo esc_attr($atts['item_class']);?> <?php echo ( $pricing_meta->_cms_is_feature == 1 ) ? ' pricing-feature-item' : '' ?> pricing-horizontal clearfix">
				<div class="pricing-horizontal-content col-md-9">
					<div class="cms-custom-heading heading-line cms-h4">
						<h4 class="cms-pricing-title <?php echo ( $pricing_meta->_cms_is_feature == 1 ) ? ' pr-feature' : '' ?>"><?php the_title();?></h4>
					</div>
					<div class="pricing-features">
						<div class="row">
							<?php
								$total_option = array();
								for ($i=1; $i <= 10 ; $i++) {
									$pricing_option = $pricing_meta->{'_cms_option'.$i};
									if ( !empty($pricing_meta->{'_cms_option'.$i}) ) {
										$total_option[] = $pricing_meta->{'_cms_option'.$i};
									}
								}
								$half_option = round(count($total_option) / 2);
							?>
							<div class="col-md-6">
								<ul class="icon-list clearfix">
									<?php
										for ($i = 0; $i < $half_option; $i++) { 
											echo '<li><span class="icon icon-arrows-check icon-li" aria-hidden="true"></span>'.$total_option[$i].'</li>';
										}
									?>
								</ul>
							</div>
							<div class="col-md-6">
								<ul class="icon-list clearfix">
									<?php
										for ($i = $half_option; $i < count($total_option); $i++) { 
											echo '<li><span class="icon icon-arrows-check icon-li" aria-hidden="true"></span>'.$total_option[$i].'</li>';
										}
									?>
								</ul>
							</div>
						</div>
					</div>
				</div>

				<div class="pricing-horizontal-container col-md-3">
					<div class="price-heading">
						<span class="currency"><?php echo esc_attr($pricing_meta->_cms_value) ?></span><span class="price"><?php echo esc_attr($pricing_meta->_cms_price) ?></span>
						<span class="cents-cont">
							<span class="cents"><?php echo esc_attr($pricing_meta->_cms_cents) ?></span>
							<span class="place2"><?php echo esc_attr($pricing_meta->_cms_time) ?></span>
						</span>	
					</div>	
					<div class="price-button <?php echo ( $pricing_meta->_cms_is_feature == 1 ) ? ' pr-feature' : '' ?>">
						<?php
	                        if ( $pricing_meta->_cms_is_feature == 1 ) {
	                            echo '<a class="cms-button yellow pricing-button" href=" '. esc_url($pricing_meta->_cms_button_url) .' ">'. esc_attr($pricing_meta->_cms_button_text) .'</a>';
	                        } else {
	                            echo '<a class="cms-button gray pricing-button" href=" '. esc_url($pricing_meta->_cms_button_url) .' ">'. esc_attr($pricing_meta->_cms_button_text) .'</a>';
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