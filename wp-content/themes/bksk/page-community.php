<?php
/**
 * @package WordPress
 * @subpackage: Theme
 * Template Name: Community
 */
?>

<?php get_header();
	echo '<nav class="page__subnav">';
	wp_nav_menu( array('menu' => 'Practice' ));
	echo '</nav>'; ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<header class="page__header">	
	<?php $headline = get_field('headline');
		if($headline) {
			the_field('headline');
		} ?>
</header>

<?php if( have_rows('photographs') ):
	$count = 0;
	echo '<div class="page__content grid-community">';
    while ( have_rows('photographs') ) : the_row();
      $img = get_sub_field('image');
      $caption = get_sub_field('caption');
      if($count == 0) {
		  echo '<div class="container twocol resp-col1">';
	  }
	  
	  if($count == 3) {
		  echo '<div class="container twocol resp-col2">';
	  }
	  
	  if($count == 6) {
		  echo '<div class="container resp-col3">';
	  }
	  
	  if($count == 0 || $count == 1 || $count == 4 || $count == 5) {
		  $class = 'twocol';
	} else {
		$class = '';
	}
	  
	if($count == 0 || $count == 1 || $count == 4 || $count == 5) {
	  $img = $img['sizes']['sq260'];
	} else {
	  $img = $img['sizes']['sq500'];
	}
		echo '<div class="item effect-caption '.$class.'"><img src="'.$img.'" alt="Community" />';
		echo '<h3 class="caption">';
		if($caption) {
			echo $caption;
		} else {
			echo '';
		} 
		echo '</h3></div>';
	
	if($count == 2 || $count == 5 || $count == 8) {
	  echo '</div>';
	}
	$count++;
	endwhile;
	echo '</div>';
endif; ?>

<?php 
	echo '<div class="clearfix"></div>';
	echo '<div class="text--column">';
	the_content();
	echo '</div>';
 ?>
		 
<?php endwhile; endif; ?>

<?php get_footer(); ?>