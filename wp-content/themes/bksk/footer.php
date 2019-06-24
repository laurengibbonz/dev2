<?php
/**
 * @package WordPress
 * @subpackage BKSK
 */
?>
</div><!-- main /wrapper --> 
<div class="clearfix"></div>
<footer>
	<div class="wrapper" role="navigation">
<?php echo '<nav class="footer__subnav">';
	wp_nav_menu( array('menu' => 'Footer', 'items_wrap' => my_nav_wrap() ));
	echo '</nav>'; ?>
<?php query_posts('page_id=2'); 
	if(have_posts()) : while (have_posts ()): the_post(); 
	if( have_rows('social') ):
		echo '<div class="footer__social">';
		while( have_rows('social') ): the_row(); 
		$image = get_sub_field('image');
		$image = wp_get_attachment_image_url( $image, 'full' );
		$link = get_sub_field('link');
		echo '<a href="'.$link.'" target="_blank"><img alt="social" src="'.$image.'" /></a>';
	endwhile; echo '</div>'; endif;
endwhile; endif; wp_reset_query(); ?>
</div>
</footer>
<?php 
	if(is_page('team') || is_page(4997)) { 
	echo '<div class="overlay"><button class="close">X</button><button class="prev"></button><button class="next">></button><div class="content"></div></div>';
	}
 ?>
<div class="overlay-search">
	<button id="btn-search-close" class="btn btn--search-close" aria-label="Close search form"><svg class="icon icon--cross"><use xlink:href="#icon-cross"></use></svg></button>
	<?php get_search_form(); ?>
</div><!-- /search -->

<?php wp_footer(); ?>

</body>
</html>