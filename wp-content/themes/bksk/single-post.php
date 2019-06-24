<?php get_header(); ?>

<div id="content">

<?php if (have_posts()): while (have_posts()) : the_post();?>

<aside id="post">  

<div class="loop-entry">
	<p class="date"><?php the_time('F j, Y') ?></p>
	<h2><?php the_title(); ?></h2>
		<?php the_content(); ?>
	<div class="tags">
		<?php the_tags('<span>Tags:</span> ', ', ', ''); ?> 
	</div>
</div>

</aside>

<?php endwhile; endif; ?>  

<?php get_sidebar(); ?>  

</div>
	
<?php get_footer(); ?>