<?php
/**
 * @package WordPress
 * @subpackage: Theme
 * Template Name: Images
 */
?>

<?php get_header(); ?>
<?php 
$args = array(
	'post_type' => 'work',
	'posts_per_page' => 50
);
$query = new WP_Query( $args );
if($query->have_posts() ) :
	while ( $query->have_posts() ) :
	$query->the_post();
		$id = get_the_ID();
		$types = array('interior_photographs','photographs','drawings','process','data', 'context');
		$ids = array();
		foreach($types as $type) {
			if(have_rows($type)) :
			while( have_rows($type) ): the_row(); 
			$image = get_sub_field('image');
			if($image) {
				array_push($ids, $image['ID']);
			}
			endwhile; endif;
		}
		
endwhile; endif; 

wp_reset_query();

// var_dump($ids);
	$args = array(
        'post_type' => 'attachment',
        'orderby' => 'post__in',
        'post__in' => $ids,
        'post_status' => 'inherit',
        'posts_per_page' => -1
    );
	$attachments = get_posts($args);
	foreach($attachments as $attachment) {
		$image = wp_get_attachment_image_src($attachment->ID, 'large');
		echo '<a href="'.$image[0].'">'.$image[0].'</a> ';
		$img = get_headers($image[0], 1);
		$imgsize = $img["Content-Length"]/1024;
		if($imgsize > 800) {
			echo '<span style="color:red;">';
		}
		echo round($imgsize, 2). 'KB<br />';
		if($imgsize > 800) {
			echo '</span>';
		}
	}
?>

<?php get_footer(); ?>