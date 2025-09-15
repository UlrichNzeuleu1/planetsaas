<?php 
    global $smof_data;
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
    /*ajax media*/
    wp_enqueue_style( 'wp-mediaelement' );
    wp_enqueue_script( 'wp-mediaelement' );
    /* js, css for load more */
    
    wp_register_script( 'timeline-loadmore', get_template_directory_uri().'/assets/js/timeline-loadmore.js', array('jquery') ,'1.0',true);
    // What page are we on? And what is the pages limit?
    global $wp_query;
    $max = $wp_query->max_num_pages;
    $limit = $atts['limit'];
    $paged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;

    // Add some parameters for the JS.
    $current_id =  str_replace('-','_',$atts['html_id']);
    wp_localize_script(
        'timeline-loadmore',
        'cms_more_obj'.$current_id,
        array(
            'startPage' => $paged,
            'maxPages' => $max,
            'total' => $wp_query->found_posts,
            'perpage' => $limit,
            'nextLink' => next_posts($max, false),
            'masonry' => $atts['layout']
        )
    );
    wp_enqueue_script( 'timeline-loadmore' );
    $intro_start_text = $intro_start_date = '';
    $intro_start_text = (!empty($smof_data['timeline_intro_start'])) ? $smof_data['timeline_intro_start'] : esc_html__('START COMPANY', 'haswell');
    $intro_start_text_end = (!empty($smof_data['timeline_intro_start_end'])) ? $smof_data['timeline_intro_start_end'] : esc_html__('RECENT DAY', 'haswell');
    $timeline_intro_start_date = (!empty($smof_data['timeline_intro_start_date'])) ? $smof_data['timeline_intro_start_date'] : '';
?>

<div class="cms-grid-wraper blog-timeline-wrap <?php echo esc_attr($atts['template']);?>" id="<?php echo esc_attr($atts['html_id']);?>">
    <div class="timeline-start">
        <div class="timeline-start-caption">
            <?php esc_html($intro_start_text); ?>
        </div>
        <div class="timeline-start-date">
            <?php echo date('F Y', strtotime($timeline_intro_start_date)); ?>
        </div>
    </div>
    <?php
        $posts = $atts['posts'];

        while($posts->have_posts()) {
            $posts->the_post();
            ?>
            <div class="timeline-block ">
                <div class="timeline-icon">
                    <span class="icon_house_alt" aria-hidden="true"></span>
                </div>
                <div class="timeline-content">
                    <h2 class="entry-title"><?php the_title();?></h2>
                    <div class="entry-excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                    <div class="entry-date">
                        <span class="entry-date-year"><?php echo get_the_time('Y');?></span>
                        <span class="entry-date-month"><?php echo get_the_time('M j');?></span>
                    </div>
                </div>
            </div>
            <?php
        }
    ?>
    <div class="timeline-start timeline-final">
        <div class="timeline-pagination cd-timeline-start-caption" data-text="<?php esc_html($intro_start_text_end); ?>">
        </div>
    </div>
</div>