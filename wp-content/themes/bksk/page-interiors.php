<?php
/**
 * @package WordPress
 * @subpackage: Theme
 * Template Name: Interiors
 */
?>

<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); 
$id = get_the_ID();
$run_blockarray = disciplineBlockImage(4966);
$img1 = $run_blockarray['a'];
$img2 = $run_blockarray['b'];
$block_title = get_field('block_title');
if($block_title != '') {
	$block_title = $block_title['sizes']['rect'];
	$class = 'background-image:url('.$block_title.')';
} else {
	$class = 'background-color:#CCCCCC';
}
$block_titlecolor = get_field('block_titlecolor');
if($block_titlecolor != '') {
	$titleclass = 'color:'.$block_titlecolor;
} else {
	$titleclass = 'color:#FFFFFF';
}
$blocks = array();
if( have_rows('blocks') ):
	while ( have_rows('blocks') ) : the_row();
		$block = get_sub_field('block_image');
		if($block != '') {
   			$block = $block['sizes']['sq260'];
		} else {
   			$block = get_template_directory_uri().'/img/block.png';
		}
		array_push($blocks, $block);
	endwhile;
endif; ?>

<div class="page__content discipline">

<div class="twocol container resp-col1">
<div class="block rect1" style="<?php echo $class; ?>">
	<div class="text">
		<h1 style="<?php echo $titleclass; ?>"><?php the_title(); ?></h1>
	</div>
</div>

<div class="item effect-caption sq2">
<?php echo disciplineImage('sq500', 'living-environments', 'interiors', '.living-environments','living environments'); ?>
</div>

<div class="resp-lg section1">
	
<div class="block sq1" style="background-image:url(<?php echo $blocks[1]; ?>);"></div>

<div class="sq1 bw flip-container" onclick="this.classList.toggle('hover');">
<div class="flip">
	<div class="front">
	<?php echo $img2; ?>
	<div class="text grad-bg--top">	
		<h3>Contact</h3>
	</div>
	</div>
	<div class="back">
		<div class="content">
			<h3>Contact</h3>
			<p>BKSK Architects LLP<br />
			28 West 25th Street, 4th Fl<br />
			New York, NY 10010<br />
			Phone:  212.807.9600<br /></p>
			<p><a href="mailto:interiors@bksk.com" target="_blank">interiors@bksk.com</a></p>
			<p><a href="https://instagram.com/bkskinteriors" target="_blank"><img class="instagram" src="<?php echo get_template_directory_uri(); ?>/img/instagram.svg" alt="Instagram" />/bkskinteriors</a></p>
		</div>
	</div>
</div>
</div>

</div>

</div><!-- twocol -->

<div class="twocol resp-col2">

<div class="item effect-caption sq2">
	<?php echo disciplineImage('sq500', 'work-environments', 'interiors', '.work-environments','work environments'); ?>
</div>

<div class="item sq1 bw resp-sm about">
	<a class="" href="<?php echo get_site_url(); ?>/interiors/about">
	<?php echo $img1; ?>
	<div class="text grad-bg--top">	
		<h3>About</h3>
	</div>
	</a>
</div>

<div class="block sq1 last" style="background-image:url(<?php echo $blocks[0]; ?>);"></div>

<div class="item effect-caption sq1 bw resp-lg about">
<a class="" href="<?php echo get_site_url(); ?>/interiors/about">
	<?php echo $img1; ?>
<div class="text grad-bg--top">	
	<h3>About</h3>
</div>
</a>
</div>

</div>

<div class="fourcol resp-fourcol">

<div class="resp-sm section1">

<div class="block sq1" style="background-image:url(<?php echo $blocks[1]; ?>);"></div>

<div class="sq1 bw flip-container" onclick="this.classList.toggle('hover');">
<div class="flip">
	<div class="front">
	<?php echo $img2; ?>
	<div class="text grad-bg--top">	
		<h3>Contact</h3>
	</div>
	</div>
	<div class="back">
		<div class="content">
			<h3>Contact</h3>
			<p>BKSK Architects LLP<br />
			28 West 25th Street, 4th Fl<br />
			New York, NY 10010<br />
			Phone:  212.807.9600<br /></p>
			<p><a href="mailto:interiors@bksk.com" target="_blank">interiors@bksk.com</a></p>
			<p><a href="https://instagram.com/bkskinteriors" target="_blank"><img class="instagram" src="<?php echo get_template_directory_uri(); ?>/img/instagram.svg" alt="Instagram" />/bkskinteriors</a></p>
		</div>
	</div>
</div>
</div>

</div>

</div>

<div class="twocol first resp-col2">
	
<div class="fourcol last resp-lg section2">
<div class="item sq1 bw">
<?php $jsonurl = "https://api.instagram.com/v1/users/self/media/recent/?access_token=3323346110.1677ed0.8bdb4bc04ff14e0793eac97a159dddb2&count=1";	
	$json = file_get_contents($jsonurl,0,null,null);
	$json_output = json_decode($json, true);
	foreach($json_output['data'] as $item) {
		$title = str_replace(' & ', ' &amp; ', $item['caption']['text']);
	    $link = $item['link'];
	    $image = $item['images']['low_resolution']['url']; 
		echo '<a href="'.get_site_url().'/interiors/inspiration"><img src="'.$image.'" alt="'.$title.'" />';
	} ?>
<div class="text grad-bg--top">	
	<h3>Inspiration</h3>
</div></a>
</div>

<div class="block sq1" style="background-image:url(<?php echo $blocks[2]; ?>);"></div>

</div><!-- section2 -->


<div class="item effect-caption sq2 resp-hack">
	<?php echo disciplineImage('sq500', 'community-environments', 'interiors', '.community-environments', 'community environments'); ?>
</div>

</div><!-- twocol -->

<div class="fourcol last resp-sm section2">
<div class="item sq1 bw">
<?php $jsonurl = "https://api.instagram.com/v1/users/self/media/recent/?access_token=3323346110.1677ed0.8bdb4bc04ff14e0793eac97a159dddb2&count=1";	
	$json = file_get_contents($jsonurl,0,null,null);
	$json_output = json_decode($json, true);
	foreach($json_output['data'] as $item) {
		$title = str_replace(' & ', ' &amp; ', $item['caption']['text']);
	    $link = $item['link'];
	    $image = $item['images']['low_resolution']['url']; 
		echo '<a href="'.get_site_url().'/interiors/inspiration"><img src="'.$image.'" alt="'.$title.'" />';
	} ?>
<div class="text grad-bg--top">	
	<h3>Inspiration</h3>
</div></a>
</div>

<div class="block sq1" style="background-image:url(<?php echo $blocks[2]; ?>);"></div>

</div><!-- section2 -->

</div>
	


<?php endwhile; endif; ?>
<?php get_footer(); ?>