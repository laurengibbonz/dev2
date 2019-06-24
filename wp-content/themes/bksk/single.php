<?php get_header(); ?>

<?php if (have_posts()): while (have_posts()) : the_post(); 
	
if(is_singular('careers')) { ?>
	<nav class="page__subnav" role="navigation">
		<a href="<?php echo get_site_url(); ?>/careers">&larr; Back to Careers</a>
	</nav>
	<?php } 
?>

<div id="content">

<aside id="post">  

<div class="loop-entry">
	<p class="date"><?php the_time('F j, Y') ?></p>
	<h2><?php the_title(); ?></h2>
	<?php the_content(); ?>
</div>

</aside>

<?php endwhile; endif; ?>  

<?php get_sidebar(); ?>  

</div>
	
<?php get_footer(); ?>