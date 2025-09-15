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
?>
<div id="<?php echo esc_attr($atts['html_id']);?>" class="cms-grid-wraper cms-grid-blog cms-blog-sidebar clearfix">
    <?php
        $posts = $atts['posts'];
        $index = 0;
        echo '<div class="row">';
        while($posts->have_posts()) {
            $posts->the_post();
            if ($index > 0 && ($index%2 == 0)) {
                echo '</div><div class="row">';
            }
            get_template_part( 'single-templates/blog-small-thumb/content', get_post_format() );

            $index++;
        }
        echo '</div>';

        haswell_paging_nav();
    ?>
</div>