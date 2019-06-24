<?php
/**
 * @package WordPress
 * @subpackage: Theme
 * Template Name: Discipline About
 */
?>

<?php get_header();
	echo '<nav class="page__subnav" role="navigation">';
	if(is_page(5112)) {
		echo '<a href="'. get_site_url() .'/preservation">&larr; Back to Preservation+</a>';
	} else if(is_page(5105)) {
		echo '<a href="'. get_site_url() .'/interiors">&larr; Back to Interiors</a>';
	} else if(is_page(5463)) {
		$lab = get_post(4964);
		$link = get_the_permalink($lab->ID);
		$title = get_the_title($lab->ID);
		$title = ucwords(strtolower($title));
		echo '<a href="'.$link.'">&larr; Back to '.$title.'</a>';
	}
	echo '</nav>'; ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<header class="page__header">	
	<?php the_content(); ?>
</header>

<div class="page__content">
<?php if( have_rows('images') ):
	$imgs = array();
	while ( have_rows('images') ) : the_row();
    $img = get_sub_field('image');
	$img = $img['id'];
    array_push($imgs, $img);
    endwhile;
    endif;
?>

<div class="twocol">

<div class="text--left">
	<div class="content">	
	<?php $lText = get_field('left_text');
	if($lText != '') {
		echo $lText;
	} ?>
	</div>
</div>

<div class="item rect1">
	<?php $img = wp_get_attachment_image_src($imgs[1], 'rect'); ?>
	<img src="<?php echo $img[0]; ?>" alt="" />
</div>

<div class="item sq1 twocol">
	<?php $img = wp_get_attachment_image_src($imgs[2], 'sq260'); ?>
	<img src="<?php echo $img[0]; ?>" alt="" />
</div>

<div class="item sq1 twocol">
	<?php $img = wp_get_attachment_image_src($imgs[3], 'sq260'); ?>
	<img src="<?php echo $img[0]; ?>" alt="" />
</div>

</div>

<div class="twocol">

<div class="item sq2">
	<?php $img = wp_get_attachment_image_src($imgs[0], 'sq500'); ?>
	<img src="<?php echo $img[0]; ?>" alt="" />
</div>

<div class="text--right">
	<div class="content">
		<?php if(!is_page(5463) && !is_page(5112)) { ?>
		<div class="item img--tall twocol">	
			<?php $img = wp_get_attachment_image_src($imgs[4], 'large'); ?>
			<img src="<?php echo $img[0]; ?>" alt="Recent work image" />
		</div>	
		<div class="twocol">	
		<?php } ?>
		<?php $rText = get_field('right_text');
		if($rText != '') {
			echo $rText;
		} ?>
		<?php if(!is_page(5463) && !is_page(5112)) { ?>
		</div>
		<?php } ?>
	</div>
</div>

</div>

</div>


<?php endwhile; endif; ?>
<?php get_footer(); ?>