<?php
/**
 * @package WordPress
 * @subpackage: Theme
 * Template Name: Approach
 */
?>

<?php get_header();
	echo '<nav class="page__subnav">';
	wp_nav_menu( array('menu' => 'Practice' ));
	echo '</nav>'; ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<header class="page__header">	
	<?php the_content(); ?>
</header>

<?php if(get_field('approach') != '') {
		echo '<h4>Our Approach</h4>';
		echo '<div class="page__intro">';
		the_field('approach');
		echo '</div>';
	} 	
	if( have_rows('sections') ):
		echo '<div class="page__content practice">';
		while( have_rows('sections') ): the_row(); 
		$image = get_sub_field('image');
		$image = $image['sizes']['sq260'];
		$title = get_sub_field('title');
		$text = get_sub_field('text');
		echo '<div class="fourcol">';
		echo '<img src="'.$image.'" alt="'.$title.'"/>';
		echo '<h4>'.$title.'</h4>';
		echo $text;
		echo '</div>';
		endwhile; 
		echo '</div>';
	endif; ?>
<?php endwhile; endif; ?>
<?php get_footer(); ?>