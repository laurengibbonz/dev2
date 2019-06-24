<?php
/**
 * @package WordPress
 * @subpackage: BKSK
 */
?>

<?php get_header(); ?>
<?php if (have_posts()) : ?>
	
<header class="page__header">	
	<?php if(is_page(5361)) { ?>
	<?php the_content(); ?>
	<?php } if (is_category()) { ?>
	<h2><?php single_cat_title(); ?></h2>
	<?php } elseif( is_tag() ) { ?>
	<h2>(Po)sts tagged &quot;<?php single_tag_title(); ?>&quot;</h2>
	<?php  } elseif (is_day()) { ?>
	<h2>Archive for <?php the_time('F jS, Y'); ?></h2>
	<?php  } elseif (is_month()) { ?>
	<h2>Archive for <?php the_time('F, Y'); ?></h2>
	<?php  } elseif (is_year()) { ?>
	<h2>Archive for <?php the_time('Y'); ?></h2>
	<?php  } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
	<h2>Blog Archives</h2>
	<?php } ?>
</header>
<div id="content">

<aside id="post">
		<?php get_template_part( 'loop' , 'entry') ?>   
</aside>

<?php wp_reset_query(); endif; ?>
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>