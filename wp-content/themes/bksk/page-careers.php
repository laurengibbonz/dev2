<?php
/**
 * @package WordPress
 * @subpackage: Theme
 * Template Name: Careers
 */
?>

<?php get_header(); ?>
<?php if (have_posts()) : ?>
	
<header class="page__header">
	<?php echo get_post_field('post_content', 5059); ?>
</header>

<?php wp_reset_query(); endif; ?>

<div id="content">

<aside id="post">	
<?php $args = array(
            'post_type'=> 'careers',
            'posts_per_page' => 15,
            'post_status' => 'publish',
            'paged'=>$paged
        ); 
$query = new WP_Query($args);
if ($query->have_posts()) :
while ($query->have_posts()) : $query->the_post(); ?>
        
	<div class="loop-entry">
		<a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
			<p><?php the_content(); ?></p>
	</div> 

<?php endwhile; 
	else :
	$no_careers = get_field('no_careers', 5059);
	echo '<h3 class="no-careers">'.$no_careers.'<h3>';
	endif; ?>
</aside>

<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>