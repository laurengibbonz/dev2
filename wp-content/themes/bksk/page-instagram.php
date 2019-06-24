<?php
/**
 * @package WordPress
 * @subpackage: Theme
 * Template Name: Instagram
 */
?>

<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<nav class="page__subnav" role="navigation">
	<a href="<?php echo get_site_url(); ?>/post">&larr; Back to (Po)st</a>
</nav>
	
<header class="page__header">	
	<?php the_title(); ?>
</header>

<article class="inspiration">
	<?php $jsonurl = "https://api.instagram.com/v1/users/self/media/recent/?access_token=1433913024.1677ed0.cf327409200347adbefb83d477754726&count=28";	
	$json = file_get_contents($jsonurl,0,null,null);
	$json_output = json_decode($json, true);
	foreach($json_output['data'] as $item) {
		$title = str_replace(' & ', ' &amp; ', $item['caption']['text']);
	    $link = $item['link'];
	    $image = $item['images']['low_resolution']['url']; 
		echo '<div class="item fourcol"><a href="'.$link.'" target="_blank"><img src="'.$image.'" alt="'.$title.'" /></div>';
	} ?>
</article>

<?php endwhile; endif; ?>
<?php get_footer(); ?>