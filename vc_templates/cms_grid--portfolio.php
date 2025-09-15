<?php 
    /* get categories */
    $taxo = 'category-portfolio';
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
    $cms_portfolio_thumb = (isset($atts['cms_portfolio_thumb'])) ? $atts['cms_portfolio_thumb'] : '';
    switch ($cms_portfolio_thumb) {
        case 'fixed_w':
            $thumb_size = 'blog-thumb';
            break;
        case 'square':
            $thumb_size = 'portfolio-square';
            break;
        default:
            $thumb_size = 'portfolio-wide';
            break;
    }

    /* View all */
    $cms_viewall_text = $cms_viewall_link = $cms_viewall_style = '';
    if (isset($atts['cms_viewall']) && $atts['cms_viewall'] == true) {
        $cms_viewall_text = isset($atts['cms_viewall_text']) ? $atts['cms_viewall_text'] : '';
        $cms_viewall_link = isset($atts['cms_viewall_link']) ? $atts['cms_viewall_link'] : '';
        $cms_viewall_style = isset($atts['cms_viewall_style']) ? $atts['cms_viewall_style'] : '';
    }
?>
<div <?php post_class($atts['template'].' cms-grid-wraper cms-portfolio-grid-wrap') ;?> id="<?php echo esc_attr($atts['html_id']);?>"> 
    <?php
        $posts = $atts['posts'];
        $number_posts = explode('|', $atts['source']);
        $number = substr($number_posts[0], 5);

        foreach ($atts['categories'] as $index => $value) {
            $args_query = array(
                'post_type' => 'portfolio',
                'tax_query' => array(
                    array(
                        'taxonomy' => $taxo,
                        'field'    => 'term_id',
                        'terms'    => $value,
                    ),
                ),
            );

            $term = get_term( $value, $taxo );

            $portfolios = new WP_Query($args_query);
        ?>
            <?php if ($portfolios->have_posts()) :  ?>
                <div class="container">
                    <div class="row <?php echo (($index + 1) != count($atts['categories'])) ? 'mb-80' : '' ?>">
                        <div class="col-sm-4 col-md-3">
                            <h2 class="section-title-3 mb-30"><?php echo esc_attr($term->name) ?></h2>
                            <div class="mb-50">
                                <?php
                                    echo apply_filters('the_content', term_description($term->term_id, 'category-portfolio'));
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-8 col-md-offset-1 ">
                            <?php while ($portfolios->have_posts()) : $portfolios->the_post(); ?>
                                <div class="col-md-6 plr-0 cms-portfolio-item">
                                    <div class="cms-portfolio-item-inner">
                                        <a href="<?php the_permalink(); ?>">
                                            <div class="portfolio-image">
                                                <?php echo get_the_post_thumbnail(get_the_ID(), $thumb_size) ?>
                                                <i class="icon_link"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
                <?php echo (($index + 1) != count($atts['categories'])) ? '<hr class="mt-0 mb-80">' : '' ?>
            <?php endif; wp_reset_postdata(); ?>
    <?php } ?>
    <?php haswell_paging_nav(); ?>
</div>