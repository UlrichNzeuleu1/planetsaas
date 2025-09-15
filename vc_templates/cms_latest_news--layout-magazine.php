<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$category_link = $first_text = $last_text = $sub_title = $el_class = '';
$post_in_page = (!empty($atts['cms_number_post_to_show'])) ? $atts['cms_number_post_to_show'] : 6;
$latest_title = (!empty($atts['latest_title'])) ? $atts['latest_title'] : '';
$cms_viewall_text = (!empty($atts['cms_viewall_text'])) ? $atts['cms_viewall_text'] : esc_html__('OUR BLOG', 'haswell');
$categories_name = (!empty($atts['categories_name'])) ? $atts['categories_name'] : '';
$magazine_style = (!empty($atts['magazine_style'])) ? $atts['magazine_style'] : 'grid';

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
    'order'         => 'DESC',
    'meta_query' => array(
        array(
            'key' => '_thumbnail_id',
            'compare' => 'EXISTS'
        )
    )
);
$exclude_post = ( !empty($atts['cms_exclude_post']) ) ? $atts['cms_exclude_post'] : '';
if($exclude_post!=''){
    $exclude_post= explode(',',$exclude_post);
}
$args_query['post__not_in'] = $exclude_post;

$magazine_posts = new WP_Query($args_query);

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
<div class="cms-latest-news-wrapper cms-latest-layout-magazine">
	<?php if (!empty($latest_title) || ((isset($atts['cms_viewall']) && $atts['cms_viewall'] == true)) ) : ?>
		<div class="row">
		    <div class="latest-title col-xs-12">
		    	<h2 class="section-title">
		    		<?php print($first_text.$last_text); ?>
		    		<?php if(isset($atts['cms_viewall']) && $atts['cms_viewall'] == true): ?>
		    			<a class="section-more" href="<?php echo esc_url($category_link);?>"><?php echo esc_attr($cms_viewall_text); ?></a>
		    		<?php endif;?>
		    	</h2>
		    </div>
	    </div>
	<?php endif; ?>
	
	<?php if ($magazine_posts->have_posts()) : ?>
		<?php if ($magazine_style == 'grid'): ?>
			<?php
				$i = 0; 
				echo '<div class="row">';
				while($magazine_posts->have_posts()) : $magazine_posts->the_post(); global $post; ?>
					
				<?php
					if ($i != 0 && $i%2 == 0) {
						echo '</div><div class="row special-row row-'.$i.'">';
					}

					if ($i < 2) { 
				?>
					<div class="col-sm-6 col-md-6 cms-blog-item wow fadeIn pb-70 <?php echo esc_attr($el_class); ?>" data-wow-delay="<?php echo ($i*200) ?>ms">
		    			<div class="entry-feature entry-feature-image mb-25">
		    				<a href="<?php the_permalink(); ?>">
		    					<?php the_post_thumbnail('portfolio-wide'); ?>
		    				</a>
		    			</div>
		    			<header class="entry-header">
							<h3 class="entry-title">
						    	<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						    </h3>
						</header>
						<div class="post-info">
					        <ul>
					            <li class="entry-date">
					                <span><?php echo get_the_date('F d') ?></span>
					            </li>
					            <li class="entry-author">
					                <?php the_author_posts_link(); ?>
					            </li>         
					        </ul>
					    </div>
						<div class="entry-content">
							<?php echo wp_trim_words(get_the_excerpt(),20,'') ?>
						</div>
						<footer class="entry-footer">
						    <?php haswell_archive_readmore(); ?>
						    <!-- .readmore link -->
						</footer>
		    		</div>
				<?php
					}
					if ($i >= 2) {
						?>
							<div class="col-sm-6 col-md-6 cms-blog-item mb-20 <?php echo esc_attr($el_class); ?>">
				    			<div class="entry-feature entry-feature-image pull-left">
				    				<a href="<?php the_permalink(); ?>">
				    					<?php the_post_thumbnail('thumbnail'); ?>
				    				</a>
				    			</div>
								<div class="magazine-listing-wrap">
									<header class="entry-header">
									    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</header>
									<div class="entry-post-info">
								        <ul>
								            <li class="entry-date">
								                <span><?php echo get_the_date('F d') ?></span>
								            </li>
								            <li class="entry-author">
								                <?php the_author_posts_link(); ?>
								            </li>
								        </ul>
								    </div>
								</div>
				    		</div>
						<?php
					}
				?>
			<?php $i++; endwhile; ?>
			</div> <!-- End row -->
			<?php elseif ($magazine_style == 'slider') : //else style ?>
				<div class="row">
					<div class="col-sm-12">
						<div class="cms-carousel-wrapper owl-images-wrap paging_outside mb-30" id="owl-images-carousel-<?php echo uniqid(); ?>">
							<div data-loop="false" data-nav="true" data-pagination="true" data-autoplay="true" data-per-view="1" class="cms-owl-carousel owl-carousel owl-theme owl-loaded owl-drag">
								<?php while($magazine_posts->have_posts()) : $magazine_posts->the_post(); global $post; ?>
									<div class="cms-blog-item">
						    			<div class="entry-feature entry-feature-image mb-30">
						    				<?php the_post_thumbnail('blog-slider'); ?>
						    			</div>
						    			<header class="entry-header">
											<h3 class="entry-title">
										    	<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										    </h3>
										</header>
										<div class="post-info mb-40">
									        <ul>
									            <li class="entry-date">
									                <span><?php echo get_the_date('F d') ?></span>
									            </li>
									            <li class="entry-author">
									                <?php the_author_posts_link(); ?>
									            </li>
									            <?php if (has_category()) : ?>
									                <li class="entry-terms">
									                    <?php the_terms( get_the_ID(), 'category', '', ', ' ); ?>
									                </li>
									            <?php endif; ?>      
									        </ul>
									    </div>
						    		</div>
								<?php endwhile; ?>
							</div>
						</div>
					</div>
				</div>	
			<?php elseif ($magazine_style == 'grid-wide-thumb') :  //End magazine style ?>
				<div class="row cms-latest-news-wrapper">
					<?php $i = 0; while($magazine_posts->have_posts()) : $magazine_posts->the_post(); global $post; ?>
						<?php
							if ($i != 0 && $i%4 == 0) {
								echo '</div><div class="row cms-latest-news-wrapper">';
							}
						?>

						<div class="cms-blog-item col-sm-6 col-md-3 wow fadeIn pb-70 <?php echo esc_attr($el_class); ?>" >
			    			<div class="entry-feature entry-feature-image mb-30">
			    				<a href="<?php the_permalink(); ?>">
			    					<?php the_post_thumbnail('portfolio-wide'); ?>
			    				</a>
			    			</div>
			    			<header class="entry-header">
								<h3 class="entry-title" style="font-size: 18px; line-height: 32px;">
							    	<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							    </h3>
							</header>
							<div class="post-info">
						        <ul>
						            <li class="entry-date">
						                <span><?php echo get_the_date('F d') ?></span>
						            </li>
						            <li class="entry-author">
						                <?php the_author_posts_link(); ?>
						            </li>
						            <?php if (has_category()) : ?>
						                <li class="entry-terms">
						                    <?php the_terms( get_the_ID(), 'category', '', ', ' ); ?>
						                </li>
						            <?php endif; ?>       
						        </ul>
						    </div>
			    		</div>
					<?php $i++; endwhile; ?>	
				</div><!-- end row -->
			<?php endif; //End magazine style ?>

	<?php endif; ?>
</div>
