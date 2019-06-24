<?php
/**
 * @package WordPress
 * @subpackage: Theme
 * Template Name: Contact
 */
?>

<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
<header class="page__header">	
	<?php the_content(); ?>
</header>


<div id="content">

<?php $text = get_field('text'); ?>

<div class="left">
	<?php echo $text; ?>
</div>

<div class="right">
	<div id="map__office" class="map"></div>
</div>


</div>

<?php endwhile; endif; ?>
<?php get_footer(); ?>