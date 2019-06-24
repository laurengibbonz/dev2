<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage BKSK
 */
get_header(); ?>

<div id="content">
	<header class="page-header">
		<h1 class="page-title">Page Not Found</h1>
	</header><!-- .page-header -->

	<div class="page__content error-404">
		<h2>Try a search or check out our featured projects.</h2>

		<?php $ids = get_field('featured', false, false);	
		echo '<div class="featured__header">';
		echo '<h3>Featured Projects</h3>';
		$args = array(
		'post_type' => 'work',
		'orderby' => 'rand',
		'post__in' => $ids,
		'posts_per_page' => 4
		);
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$feat_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'sq500');
				echo '<div class="fourcol effect-caption"><a href="'.get_the_permalink($post->ID).'"><img src="'.$feat_img[0].'" alt="'.get_the_title().'" /><caption><h3 class="caption">'.get_the_title().'</h3></caption></a></div>';
			} 
		} 
		echo '</div>'; ?>
	</div><!-- .page__content -->

</div><!-- #content -->

<?php get_footer(); ?>
