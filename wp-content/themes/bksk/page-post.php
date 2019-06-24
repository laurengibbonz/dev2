<?php
/**
 * @package WordPress
 * @subpackage: Theme
 * Template Name: (Po)st
 */
?>

<?php get_header(); ?>
<?php if (have_posts()) : ?>
	
<header class="page__header">	
	<?php echo get_post_field('post_content', 5361); ?>
	<?php if (is_category()) { ?>
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
<?php query_posts(
            array(
            'post_type'=> 'post',
            'posts_per_page' => 6,
            'paged'=>$paged
        )); ?>
<aside id="post">
		<?php get_template_part( 'loop' , 'entry') ?>   

<div class="nav-previous alignleft"><?php previous_posts_link( 'Newer (Po)sts' ); ?></div>
<div class="nav-next alignright"><?php next_posts_link( 'Older (Po)sts' ); ?></div>

</aside>

<?php wp_reset_query(); endif; ?>
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>