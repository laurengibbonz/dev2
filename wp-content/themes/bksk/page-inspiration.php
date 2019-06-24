<?php
/**
 * @package WordPress
 * @subpackage: Theme
 * Template Name: Inspiration
 */
?>

<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<nav class="page__subnav" role="navigation">
	<a href="<?php echo get_site_url(); ?>/interiors">&larr; Back to Interiors</a>
</nav>
	
<header class="page__header">	
	<?php the_title(); ?>
</header>

<article class="inspiration">
	<?php $jsonurl = "https://api.instagram.com/v1/users/self/media/recent/?access_token=3323346110.1677ed0.8bdb4bc04ff14e0793eac97a159dddb2&count=28";	
	$json = file_get_contents($jsonurl,0,null,null);
	$json_output = json_decode($json, true);
	if($json_output) {
		foreach($json_output['data'] as $item) {
			$title = str_replace(' & ', ' &amp; ', $item['caption']['text']);
		    $link = $item['link'];
		    $image = $item['images']['low_resolution']['url']; 
			echo '<div class="item fourcol"><a href="'.$link.'" target="_blank"><img src="'.$image.'" alt="'.$title.'" /></div>';
		} 
	} else {
		echo 'Visit us on Instagram at <a href="https://www.instagram.com/bkskinteriors/">BKSK Interiors</a>';
	} ?>
</article>

<?php endwhile; endif; ?>
<?php get_footer(); ?>