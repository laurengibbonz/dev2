<?php
/**
 * @package WordPress
 * @subpackage: BKSK
 * Template Name: Default
 */
?>

<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php if(is_page(6261)) { ?>
<nav class="page__subnav" role="navigation">
	<?php $lab = get_post(4964);
		$link = get_the_permalink($lab->ID);
		$title = get_the_title($lab->ID);
		$title = ucwords(strtolower($title)); ?>
	<a href="<?php echo $link; ?>">&larr; Back to <?php echo $title; ?></a>
</nav>
<?php } ?>
<div id="content">	
<aside id="post">
<header class="page__header">	
	<?php the_title(); ?>
</header>
<div class="page__content">
	<?php the_content(); ?>
</div>
</aside>
</div>
<?php endwhile; endif; ?>
<?php get_footer(); ?>