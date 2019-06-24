<?php
/**
 * @package WordPress
 * @subpackage: Theme
 * Template Name: Lab
 */
?>

<?php get_header(); ?>
<?php
$id = get_the_ID();
$run_blockarray = disciplineBlockImage(4964);
$img1 = $run_blockarray['a'];
$img2 = $run_blockarray['b'];	
$run_array = disciplineLabImage('sustainability', 'architecture', '.sustainability', 'projects we\'ve done');
$title = $run_array['title'];
$feat_img = $run_array['img'];
$lab_img = $run_array['lab_img'];
wp_reset_query();
if (have_posts()) : while (have_posts()) : the_post(); 
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
endif; 

$feat_tool_img = get_field('feat_tool_image', 4964);
$feat_tool_img = $feat_tool_img['sizes']['rect'];
$feat_tool_text = get_field('feat_tool_text', 4964);
$feat_tool_textcolor = get_field('feat_tool_textcolor', 4964); 
if($feat_tool_textcolor != '') {
	$feat_tool_textcolor = 'color:'.$feat_tool_textcolor.' !important';
} else {
	$feat_tool_textcolor = 'color:#FFFFFF !important';
}
$feat_tool_link = get_field('feat_tool_link', 4964);

$feat_tool = '<a href="'.get_permalink($feat_tool_link->ID).'"><img src="'.$feat_tool_img.'" alt="Featured tool image" /><div class="text grad-bg"><h3 style="'.$feat_tool_textcolor.'">'.$feat_tool_text.'</h3></div></a>';
	
?>

<div class="page__content discipline">

<div class="twocol resp-col1">
<div class="block rect1" style="<?php echo $class; ?>">
	<div class="text small">
		<h2 style="<?php echo $titleclass; ?>"><?php the_title(); ?></h2>
	</div>
</div>

<div class="item effect-caption sq2">
	<?php 
		if($lab_img) {
			$img = $lab_img;
			$title_lab = $title;
		} else {
			$args = array(
				'post_type' => 'work',
				'orderby' => 'rand',
				'meta_query' => array(
					'relation' => 'AND',
					array(
						'key' => 'lab_image',
						'compare' => 'EXISTS',
					),
					array(
						'key' => 'lab_image',
						'value' => '',
						'compare' => '!=',
					),
				),
				'posts_per_page' => 1
			);
			$query = new WP_Query( $args );
			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
				$query->the_post();
					$img = get_field('lab_image');
					$img = $img['sizes']['sq500'];
					$title_lab = get_the_title();
				}
			}
		}
		echo '<a href="'.get_site_url().'/lab">';
		echo '<img src="'.$img.'" alt="Abstract architectural image" />'; ?>
	<div class="caption">
		<h3><?php echo $title_lab; ?></h3>
	</div>		
	<div class="text grad-bg">	
		<h3>what we're thinking</h3>
	</div></a>	
</div>

<div class="resp-lg section1">
	
	<div class="rect1 item--strategy item block">	
		<?php echo $feat_tool; ?>
	</div>
	
</div>

</div><!-- twocol -->

<div class="twocol resp-col2">
	
<div class="item effect-caption sq2">
<?php echo $feat_img; ?>
</div>

<div class="item sq1 bw resp-sm">
	<?php  echo '<a href="'.get_site_url().'/sustainability-lab/about">'.$img1; ?>
	<div class="text grad-bg--top">	
		<h3>About</h3>
	</div></a>
</div>

<div class="item block sq1 last" style="background-image:url(<?php echo $blocks[0]; ?>);"></div>

</div><!-- twocol -->


<div class="twocol first">

<div class="rect1 item--strategy item block resp-sm">	
	<?php echo $feat_tool; ?>
</div>

<div class="resp-sm section2">
	
<div class="item block sq1" style="background-image:url(<?php echo $blocks[1]; ?>);"></div>

<div class="sq1 last bw flip-container">
	<div class="flip">
	<div class="front">
	<?php echo $img2; ?>
	<div class="text grad-bg--top">	
		<h3>Contact</h3>
	</div>
	</div>
	<div class="back back--lab">
		<div class="content">
			<h3>Contact</h3>
			<p>BKSK Architects LLP<br />
			28 West 25th Street, 4th Fl<br />
			New York, NY 10010<br />
			Phone:  212.807.9600<br /></p>
			<p><a href="mailto:lab@bksk.com" target="_blank">lab@bksk.com</a></p>
		</div>
	</div>
	</div>
</div>

</div>

</div><!-- twocol -->


<div class="twocol resp-col2 last">

<div class="resp-lg section2">

<div class="sq1 last bw flip-container">
	<div class="flip">
	<div class="front">
	<?php echo $img2; ?>
	<div class="text grad-bg--top">	
		<h3>Contact</h3>
	</div>
	</div>
	<div class="back back--lab">
		<div class="content">
			<h3>Contact</h3>
			<p>BKSK Architects LLP<br />
			28 West 25th Street, 4th Fl<br />
			New York, NY 10010<br />
			Phone:  212.807.9600<br /></p>
			<p><a href="mailto:lab@bksk.com" target="_blank">lab@bksk.com</a></p>
		</div>
	</div>
	</div>
</div>

<div class="item block sq1" style="background-image:url(<?php echo $blocks[1]; ?>);"></div>

</div>
	
<div class="item sq2 resp-hack">
<a href="<?php echo get_site_url(); ?>/sustainability-lab/tools">
	<?php $img = get_field('tools_image', 4964); 
	$img = $img['sizes']['sq500'];
	$text = get_field('tools_text', 4964);
	echo '<img src="'.$img.'" "Abstract tools we like image" />'; ?>
	<div class="text grad-bg">	
		<h3><?php echo $text; ?></h3>
	</div>	
</a>
</div>
	
</div>

</div>	

<?php endwhile; endif; ?>
<?php get_footer(); ?>