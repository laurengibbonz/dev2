<?php
/**
 * @package WordPress
 * @subpackage BKSK
 */
?>
<?php get_header(); ?>

<header class="page__header">	
	<p>Search results: <span class="gray"><?php the_search_query(); ?></span></p>
</header>
<div id="content">
<aside id="post">
	<?php if(have_posts()) : ?>
		<?php get_template_part( 'loop' , 'entry') ?>  
	<?php else :
		echo '<div id="empty">
	    	<h2>No (Po)st articles found for that query.</h2>
	    	<a href="'.get_site_url().'/post">&larr; Back to (Po)st</a>
		</div>';
		endif; ?> 
<div class="nav-previous alignleft"><?php previous_posts_link( 'Newer (Po)sts' ); ?></div>
<div class="nav-next alignright"><?php next_posts_link( 'Older (Po)sts' ); ?></div>

</aside>

<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>