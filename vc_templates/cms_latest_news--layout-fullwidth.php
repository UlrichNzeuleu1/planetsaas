<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$category_link = $first_text = $last_text = '';
$post_in_page = (!empty($atts['post_in_page'])) ? $atts['post_in_page'] : 3;
$latest_title = (!empty($atts['latest_title'])) ? $atts['latest_title'] : '';
$cms_viewall_text = (!empty($atts['cms_viewall_text'])) ? $atts['cms_viewall_text'] : esc_html__('OUR BLOG', 'haswell');
$categories_name = (!empty($atts['categories_name'])) ? $atts['categories_name'] : '';

if (!empty($categories_name)) {
	$category_id = get_cat_ID( $categories_name );
	$category_link = get_category_link( $category_id );
} else {
	$category_link = '#';
}

$args_query = array(
    'posts_per_page'   => $post_in_page,
    'category__in' => $category_id,
    'orderby'       => 'post_date',
    'order'         => 'DESC'
);
$recent_posts = new WP_Query($args_query);

$text_array = explode('|', $latest_title);
for ($i=0; $i < count($text_array); $i++) { 
	if (($i + 1) == count($text_array)) {
		$last_text = '<span class="bold">'.$text_array[$i].'</span>';
	}
	else {
		$first_text = $text_array[$i].' ';
	}
}
?>
<div class="cms-latest-news-wrapper cms-latest-layout-fullwidth">
	<?php if (!empty($latest_title) || ((isset($atts['cms_viewall']) && $atts['cms_viewall'] == true)) ) : ?>
	    <div class="latest-title">
	    	<h2 class="section-title">
	    		<?php print($first_text.$last_text); ?>
	    		<?php if(isset($atts['cms_viewall']) && $atts['cms_viewall'] == true): ?>
	    			<a class="section-more" href="<?php echo esc_url($category_link);?>"><?php echo esc_attr($cms_viewall_text); ?></a>
	    		<?php endif;?>
	    	</h2>
	    </div>
	<?php endif; ?>
    <?php if ($recent_posts->have_posts()) : ?>
		<?php while($recent_posts->have_posts()) : $recent_posts->the_post(); global $post; ?>
			<div class="cms-blog-item col-md-12 wow fadeIn pb-30">
				<div class="row">
					<div class="col-md-4 col-sm-12 blog2-post-title-cont">
						<div class="post-prev-date-cont">
							<span class="blog2-date-numb"><?php echo get_the_date('d'); ?></span>
							<span class="blog2-month"><?php echo get_the_date('F'); ?></span>
						</div>
						<div class="post-title">
		    				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		    				<div class="post-info">
						        <ul>
						            <li class="entry-date">
						            	<a href="<?php echo esc_url( $category_link ); ?>" title="<?php echo esc_attr($categories_name) ?>"><?php echo esc_attr($categories_name) ?></a>
						            </li>
						            <li class="entry-author">
						                <?php the_author_posts_link(); ?>
						            </li>         
						        </ul>
						    </div>
		    			</div>
					</div>
					<div class="col-md-8 col-sm-12">
		    			<div class="content-excrept">
							<?php the_excerpt(); ?>
						</div>
					</div>
				</div>
    		</div>
		<?php endwhile; ?>
	<?php endif; ?>
</div>
<?php
    /*foreach( $recent_posts as $recent ) {
    	echo '<div class="post-item row">';
    		echo '<div class="col-md-4 blog2-post-title-cont">';
    			echo '<div class="post-prev-date-cont">
    				<span class="blog2-date-numb">'.get_the_date('d').'</span>
					<span class="blog2-month">'.get_the_date('F').'</span>';
    			echo '</div>';
		    	echo '<div class="post-title">
		    	<h3><a href="'.get_permalink($recent["ID"]).'">'.$recent["post_title"].'</a></h3>';
		    	echo haswell_archive_detail_v2();
		    	echo '</div>';
	    	echo '</div>';
	    	echo '<div class="col-md-8">';
		    	echo '<div class="content-excrept"><p>'.wp_trim_words($recent["post_content"],40,'...').'</p>';
		    	echo '</div>';
	    	echo '</div>';
		echo "</div>";
	}*/
?>