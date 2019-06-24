<?php
/**
 * @package WordPress
 * @subpackage: Theme
 * Template Name: Practice
 */
?>

<?php get_header();
	echo '<nav class="page__subnav" role="navigation">';
	wp_nav_menu( array('menu' => 'Practice' ));
	echo '</nav>'; ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<!--
<header class="page__header">	
	<?php the_content(); ?>
</header>
-->

<h1><?php the_title(); ?></h1>
<h3><?php the_field('title'); ?></h3>

<?php the_field('bio'); ?>

<?php endwhile; endif; ?>
<?php get_footer(); ?>