<?php
/**
 * @package WordPress
 * @subpackage: Theme
 * Template Name: Preservation
 */
?>

<?php get_header(); 
if (have_posts()) : while (have_posts()) : the_post();	
	 
$id = get_the_ID();
$img1 = disciplineBlockImage(4968)['a'];
$img2 = disciplinePresBlockImage(4968)['a'];
$block_title = get_field('block_title');
if($block_title != '') {
	$block_title = $block_title['sizes']['large'];
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
	else :
	$block = get_template_directory_uri().'/img/block.png';
	array_push($blocks, $block);
	endif; ?>

<div class="page__content discipline">

<div class="twocol resp-col1">

<div class="block rect1" style="<?php echo $class; ?>">
	<div class="text">
	<?php $title = get_the_title(); 
	$title = str_replace('+', '<span class="plus">+</span>', $title); ?>
	<h2 style="<?php echo $titleclass; ?>"><?php echo $title; ?></h2>
	</div>
</div>

<div class="item effect-caption sq2">
	<?php echo disciplineImage('sq500', 'adaptive-reuse', 'architecture', '.preservation.adaptive-reuse','adaptive reuse/restoration'); ?>
</div>

<div class="resp-lg section1">

<div class="item effect-caption rect1 historic block">
	<?php echo disciplineImage('rect', 'historic-resource', 'architecture', '.historic-resource','historic resource analysis'); ?>
</div>

</div><!-- resp-lg -->	


<div class="resp-sm section2">
	
<div class="block sq1" style="background-image:url(<?php echo $blocks[0]; ?>);"></div>

<div class="item sq1 bw last">
<a href="<?php echo get_site_url(); ?>/preservation/dialogue">
	<?php echo $img2; ?>
	<div class="text grad-bg--top">	
		<h3>Preservation Dialogue</h3>
	</div>
</a>
</div>

</div>

<div class="resp-sm section1">

<div class="item effect-caption rect1 historic block">
	<?php echo disciplineImage('rect', 'historic-resource', 'architecture', '.preservation.historic-resource','historic resource analysis'); ?>
</div>

</div>

</div><!-- twocol -->

<div class="twocol resp-col2">

<div class="item effect-caption sq2">
	<?php echo disciplineImage('sq500', 'landmark-districts', 'architecture', '.preservation.landmark-districts','new buildings in landmark districts'); ?>
</div>

<div class="item sq1 bw resp-sm about">
<a href="<?php echo get_site_url(); ?>/preservation/about">
<?php echo $img1; ?>
<div class="text grad-bg--top">	
	<h3>About</h3>
</div>
</a>
</div>

<div class="item sq1 bw resp-lg about last">
<a href="<?php echo get_site_url(); ?>/preservation/dialogue">
	<?php echo $img2; ?>
	<div class="text grad-bg--top">	
		<h3>Preservation Dialogue</h3>
	</div>
</a>
</div>

<div class="block sq1 last" style="background-image:url(<?php echo $blocks[0]; ?>);"></div>

</div><!-- twocol -->

<div class="twocol last resp-col2">

<div class="resp-lg section2">

<div class="item sq1 bw">
<a class="" href="<?php echo get_site_url(); ?>/preservation/about">
	<?php echo $img1; ?>
	<div class="text grad-bg--top">	
		<h3>About</h3>
	</div>
</a>
</div>

<div class="block sq1" style="background-image:url(<?php echo $blocks[1]; ?>);"></div>

</div>	

<div class="item effect-caption sq2 resp-hack">
	<?php echo disciplineImage('sq500', 'preservation-ethos', 'architecture', '.preservation.preservation-ethos','expanding our preservation ethos'); ?>
</div>

</div><!-- twocol -->

</div>
	
<?php endwhile; endif; ?>
<?php get_footer(); ?>