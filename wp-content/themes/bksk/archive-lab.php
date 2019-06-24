<?php
/**
 * @package WordPress
 * @subpackage: Theme
 */
?>

<?php get_header(); ?>
<?php if (have_posts()) : ?>
	
<header class="page__header">	
	<?php if(is_post_type_archive('lab')) { ?>
	<?php echo get_post_field('post_content', 4964); ?>
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

<div class="grid-lab"><div class="grid-sizer"></div><div class="gutter-sizer"></div>
  <?php
  query_posts(array('post_type' => 'lab', 'showposts' => -1));
  $count = 0;
  if (have_posts()): while (have_posts()) : the_post();
  ?>
    <?php

    /* Build class list for filtering */
    $classList = "";
    $syntax_terms = wp_get_post_terms($post->ID, 'syntax', array("fields" => "all"));
    $keyword_terms = wp_get_post_terms($post->ID, 'keywords', array("fields" => "all"));
    foreach ($syntax_terms as $term) {
      if ($term -> name != "Featured") {
        $classList    .= "syntax-" . $term -> slug . " ";
      }
    }
    foreach ($keyword_terms as $term) {
      $classList    .=  $term -> slug . " ";
    }

    /* Data Fields */
    $title = get_the_title();
    $quote = get_field('quote');
    $count++;
    if (!$quote){
      /*
      $syntax = get_field('primary_syntax');
      if ($syntax) {
        $syntax = get_term($syntax, 'syntax');
      } else {
        $featured = get_category_by_slug('featured');
        $syntax = wp_get_post_terms($post->ID, 'syntax');
        $syntax = wp_list_filter($syntax, array('slug' => 'featured'), 'NOT');
        $syntax = array_shift($syntax);
      }
      if (!$syntax){ $syntax = "N/A"; }
      */
      $keyword = wp_get_post_terms($post->ID, 'keywords');
      if (count($keyword)) {
        $keyword = array_shift($keyword);
      } else {
        $keyword = 'N/A';
      }

      $copy = strip_tags(get_the_excerpt());
      if (!$copy) {
        $copy = strip_tags(get_the_content());
        if (strlen($copy) > 200){
          $copy = substr($copy,0,190) . "...";
        }
      }
      $image = get_field('thumbnail');
      if (!$image) {
			$image = wp_get_attachment_image(get_post_thumbnail_id(), 'sq260');
      }
    } ?>

	<?php if($count == 1) {
	    $class= 'grid-item--featured';  
	} else if($quote) {
	    $class = 'lab-quote';
	} else {
	    $class = '';
	} ?>    
	<div class="loop-entry grid-item <?php echo $class.' '.$classList; ?>">
	<?php if($quote) { ?>
		&ldquo;<?php the_title(); ?>&rdquo;
		<span><?php the_field('author'); ?></span>
	<?php } else { ?>
		<a href="<?php the_permalink(); ?>">
		<?php if($keyword != 'N/A') { ?><div class="lab-cat"><?php echo $keyword->name; ?></div><?php } ?>
		<div class="lab-img">
		<?php if($count == 1) { ?>
			<img src="<?php echo $image['sizes']['large']; ?>" />
	    <?php } else { ?>
	    	<img src="<?php echo $image['sizes']['medium']; ?>" />
	    <?php } ?>	
		</div>
		<div class="lab-text">  
			<h3><?php the_title(); ?></h3>
			<?php echo $copy; ?>
			<span class="read-more">Read More</span>
		</div>
	    </a>  
	<?php } ?>
	</div>


  <?php $count++; endwhile; endif; echo wp_reset_query(); ?>
      </div>
</aside>

<?php wp_reset_query(); endif; ?>
<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>