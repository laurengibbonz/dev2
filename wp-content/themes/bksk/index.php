<?php
/**
 * @package WordPress
 * @subpackage BKSK
 */
?>
<?php get_header(); ?>
<h2 style="display:none;"><?php bloginfo('description'); ?></h2>
<?php $exclude = array(); 
$home_order = array();
if( have_rows('home_order', 8267) ):

    while ( have_rows('home_order', 8267) ) : the_row();

        $title = get_sub_field('title');
        $type = get_sub_field('type');
        $url = get_sub_field('url');
		
		array_push($home_order, array('title' => $title, 'type' => $type, 'url' => $url));
    endwhile;

else :
endif; ?>

<div class="home--browser">

<div class="col30">
<div class="item block rect2">
<a class="link" href="<?php echo get_site_url(); ?>/work/#.architecture">
	<div class="text">
		<h1>Architecture</h1>
	</div>
</a>
</div>

<div class="col sm">
<div class="item sq1 bw">
<a href="<?php echo get_site_url(); ?>/practice">
	<?php $img = wp_get_attachment_image(4909, 'thumbnail', array('alt'=>'Practice')); 
	echo $img; ?>
	<div class="text grad-bg">	
		<h3>Practice</h3>
	</div>
</a>
</div>	

<div class="item block sq1"></div>	

</div>

<div class="col lg last">
<div class="item effect-caption sq2">
	<?php $run_array = homeImage($exclude, $home_order[1]['type'], 'architecture', 'work', $home_order[1]['url'], 'top', $home_order[1]['title']); 
		echo $run_array['img'];
		array_push($exclude, $run_array['id']);  ?>	
</div>
</div>

<div class="col lg first">
<div class="item effect-caption sq2">
	<?php $run_array = homeImage($exclude, $home_order[0]['type'], 'architecture', 'work', $home_order[0]['url'], 'top', $home_order[0]['title']);
		echo $run_array['img'];
		array_push($exclude, $run_array['id']); ?>
</div>
</div>

<div class="col sm last">
<div class="item block block--last sq1"></div>

<div class="item sq1 bw">
<a href="<?php echo get_site_url(); ?>/careers">
	<?php $img = wp_get_attachment_image(4906, 'thumbnail'); 
	echo $img; ?>
<div class="text grad-bg">	
	<h3>Careers</h3>
</div>
</a>
</div>

</div>	
</div><!-- col30 -->


<div class="col50">
<div class="grid">
	<div class="grid-sizer"></div>
	<div class="gutter-sizer"></div>
	
<div class="item grid-item--med effect-caption sq2">	
	<?php 
		$run_array = homeImage($exclude, $home_order[2]['type'], 'architecture', 'work', $home_order[2]['url'], 'top', $home_order[2]['title']); 
		echo $run_array['img'];
		array_push($exclude, $run_array['id']);  ?>
</div>

<div class="item grid-item--med block rect2">
<a class="link" href="<?php echo get_site_url(); ?>/preservation">
	<div class="text">
		<h2>Preservation<span class="plus">+</span></h2>
	</div>
</a>
</div>

<div class="item grid-item--sm sq1 bw last">
<a href="<?php echo get_site_url(); ?>/post">
<?php $img = wp_get_attachment_image(4907, 'thumbnail'); 
	echo $img; ?>
	<div class="text grad-bg">	
		<h3>(PO)ST</h3>
	</div>
</a>
</div>

<div class="item item--contact grid-item--sm sq1 bw">
<a href="<?php echo get_site_url(); ?>/contact">
	<?php $img = wp_get_attachment_image(4908, 'thumbnail'); 
	echo $img; ?>
	<div class="text grad-bg">	
		<h3>Contact</h3>
	</div>
</a>
</div>

<div class="item grid-item--med effect-caption sq2">
	<?php $run_array = homeImage($exclude, $home_order[4]['type'], 'architecture', 'work', $home_order[4]['url'], 'top', $home_order[4]['title']); 
		echo $run_array['img'];
		array_push($exclude, $run_array['id']); ?>
</div>

<div class="item grid-item--lg block clear rect2">
<a class="link" href="<?php echo get_site_url(); ?>/interiors">
	<div class="text">
		<h1>Interiors</h1>
	</div>
</a>
</div>

</div><!-- col50 grid -->

<div class="clearfix"></div>
<div class="col lg first">

<div class="item effect-caption sq2">
	<?php $run_array = homeImage($exclude, $home_order[3]['type'], 'interiors', 'work', $home_order[3]['url'], 'top', $home_order[3]['title']); 
		echo $run_array['img'];
		array_push($exclude, $run_array['id']);	?>
</div>
</div>

<div class="col sm">
<div class="item sq1 bw">
<a href="<?php echo get_site_url(); ?>/recognition">
	<?php $img = wp_get_attachment_image(4910, 'thumbnail'); 
	echo $img; ?>
<div class="text grad-bg">	
	<h3>Recognition</h3>
</div>
</a>
</div>
<div class="item block sq1"></div>
</div>

<div class="col lg last">
<div class="item effect-caption sq2">
	<?php $run_array = homeImage($exclude, $home_order[5]['type'], 'architecture', 'work', $home_order[5]['url'], 'top', $home_order[5]['title']);
	echo $run_array['img'];
	array_push($exclude, $run_array['id']);	?>
</div>
</div>

</div><!-- col50 -->

<div class="col20">
<div class="item effect-caption sq2">
	<?php $run_array = homeImage($exclude, $home_order[6]['type'], 'architecture', 'work', $home_order[6]['url'], 'top', $home_order[6]['title']); 
		echo $run_array['img'];
		array_push($exclude, $run_array['id']);	?>
</div>

<div class="item effect-caption sq2">
	<?php $run_array = homeImage($exclude, $home_order[7]['type'], 'architecture', 'work', $home_order[7]['url'], 'top', $home_order[7]['title']);
		echo $run_array['img'];
		array_push($exclude, $run_array['id']);	?>
</div>

<div class="item block med">
	<?php $pages = get_pages(array('include' => '4964'));
		if ($pages): foreach($pages as $page): ?>
	<a class="link" href="<?php echo get_permalink($page->ID); ?>">
		<div class="text">	
		<h2><?php echo $page->post_title; ?></h2>
	</div>
	</a>
	<?php endforeach; endif; ?>
</div>

</div><!-- col20 -->

</div><!-- home-browser -->




<div class="page home--tablet">

<div class="twocol">
<div class="item block rect1">
<a class="link" href="<?php echo get_site_url(); ?>/work/#.architecture">
	<div class="text">
		<h1>Architecture</h1>
	</div>
</a>
</div>

<div class="item bg effect-caption sq2">
	<?php $run_array = homeImage($exclude, 'cultural-civic', 'architecture', 'work', '.cultural-civic', 'top', 'Cultural & Civic'); 
		echo $run_array['img'];
		array_push($exclude, $run_array['id']); ?>	
</div>

</div>

<div class="twocol">
<div class="item bg effect-caption sq2">
	<?php $run_array = homeImage($exclude, 'commercial', 'architecture', 'work', '.commercial', 'top', 'Commercial');
		echo $run_array['img'];
		array_push($exclude, $run_array['id']); ?>	
</div>

<div class="item sq1 bw">
<a href="<?php echo get_site_url(); ?>/practice">
	<?php $img = wp_get_attachment_image(4909, 'thumbnail'); 
	echo $img; ?>
<div class="text grad-bg">	
	<h3>Practice</h3>
</div>
</a>
</div>	

<div class="item block sq1"></div>	
</div>

<div class="twocol">
<div class="item sq1 bw">
<a href="<?php echo get_site_url(); ?>/contact">
	<?php $img = wp_get_attachment_image(4908, 'thumbnail'); 
	echo $img; ?>
<div class="text grad-bg">	
	<h3>Contact</h3>
</div>
</a>
</div>	

<div class="item block sq1 last"></div>	

<div class="item block rect2">
<a class="link" href="<?php echo get_site_url(); ?>/interiors">
	<div class="text">
		<h1>Interiors</h1>
	</div>
</a>
</div>
</div><!--twocol-->

<div class="twocol">
<div class="item bg effect-caption sq2">
	<?php $run_array = homeImage($exclude, 'interiors', 'interiors', 'work', '.interiors', 'top', 'Interiors'); 
		echo $run_array['img'];
		array_push($exclude, $run_array['id']);	?>
</div>
</div><!--twocol-->

<div class="twocol">
<div class="item bg effect-caption sq2">
	<?php $run_array = homeImage($exclude, 'preservation', 'architecture', 'work', '.preservation', 'top', 'Preservation+'); 
		echo $run_array['img'];
		array_push($exclude, $run_array['id']); ?>
</div>
</div><!--twocol-->


<div class="twocol">
<div class="item block rect2">
<a class="link" href="<?php echo get_site_url(); ?>/preservation">
	<div class="text">
		<h2>Preservation+</h2>
	</div>
</a>
</div>

<div class="item sq1 bw">
<a href="<?php echo get_site_url(); ?>/recognition">
	<?php $img = wp_get_attachment_image(4910, 'thumbnail'); 
	echo $img; ?>
<div class="text grad-bg">	
	<h3>Recognition</h3>
</div>
</a>
</div>	

<div class="item block sq1"></div>	
</div><!--twocol-->

<div class="twocol">
<div class="item block rect2">
	<?php $pages = get_pages(array('include' => '4964'));
		if ($pages): foreach($pages as $page): ?>
	<a class="link" href="<?php echo get_permalink($page->ID); ?>">
		<div class="text">	
		<h2><?php echo $page->post_title; ?></h2>
	</div>
	</a>
	<?php endforeach; endif; ?>
</div>

<div class="item sq1 bw">
<a href="<?php echo get_site_url(); ?>/post">
<?php $img = wp_get_attachment_image(4907, 'thumbnail'); 
	echo $img; ?>
	<div class="text grad-bg">	
		<h3>(PO)ST</h3>
	</div>
</a>
</div>	

<div class="item block sq1"></div>	
</div><!--twocol-->

<div class="twocol">
<div class="item bg effect-caption sq2">
	<?php $run_array = homeImage($exclude, 'sustainability', 'architecture', 'work', '.sustainability', 'top', 'Sustainability');
	echo $run_array['img'];
	array_push($exclude, $run_array['id']);	?>
</div>
</div><!--twocol-->


</div><!--home-tablet-->



<div class="home--mobile">

<?php $exclude = array(); ?>
<div class="twocol">
<div class="item bg">
	<?php $run_array = homeImage($exclude, 'architecture', 'architecture', 'work', '.architecture', 'bottom', 'Architecture'); 
		echo $run_array['img'];
		array_push($exclude, $run_array['id']);
	?>	
</div>
	
<div class="item block dark-gray">
	<div class="vertical-align-wrap">
		<div class="vertical-align">
			<a href="<?php echo get_site_url(); ?>/contact">
				<h3>Contact</h3>
			</a>
		</div>
	</div>
</div>

</div><div class="twocol">

<?php mobileBox('practice', 'Practice'); ?>

<div class="item bg">
	<?php $run_array = homeImage($exclude, 'interiors', 'interiors', 'discipline', '.interiors', 'bottom', 'Interiors'); 
		echo $run_array['img'];
		array_push($exclude, $run_array['id']);
	?>	
</div>

</div><div class="twocol">

<div class="item bg">
	<?php $run_array = homeImage($exclude, 'sustainability', 'architecture', 'discipline', 'sustainability', 'bottom', 'Lab');
	echo $run_array['img'];
	array_push($exclude, $run_array['id']);	?>
</div>	

<?php mobileBox('post', '(Po)st'); ?>

</div><div class="twocol">

<?php mobileBox('recognition', 'Press'); ?>

<div class="item bg">
	<?php $run_array = homeImage($exclude, 'preservation', 'architecture', 'discipline', 'preservation', 'bottom', 'Preservation+'); 
		echo $run_array['img'];
		array_push($exclude, $run_array['id']); ?>
</div>	

</div>

</div><!-- home-mobile -->

<?php get_footer(); ?>