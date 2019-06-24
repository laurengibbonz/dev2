<?php
/**
 * @package WordPress
 * @subpackage: Theme
 * Template Name: Preservation Dialogue
 */
?>

<?php get_header(); ?>
<nav class="page__subnav">
	<a href="<?php echo get_site_url(); ?>/preservation">&larr; Back to Preservation</a>
</nav>

<div id="content">
<?php 
	$ids = get_field('featured_preservation', 5376, false);	
	echo '<div class="featured__header">';
	echo '<h3> Featured Projects</h3>';
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
	echo '<div class="item fourcol effect-caption"><a href="'.get_the_permalink($post->ID).'"><img src="'.$feat_img[0].'" alt="'.get_the_title().'" /><h3 class="caption">'.get_the_title().'</h3></a></div>';
	} 
} 
echo '</div>'; ?>

<aside id="post">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<header class="page__header">	
	<?php the_title(); ?>
</header>

<?php the_content(); ?>
<?php endwhile; endif; ?>
</aside>
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>