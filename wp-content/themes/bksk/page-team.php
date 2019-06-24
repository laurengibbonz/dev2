<?php
/**
 * @package WordPress
 * @subpackage: Theme
 * Template Name: Team
 */
?>

<?php get_header();
	echo '<nav class="page__subnav">';
	wp_nav_menu( array('menu' => 'Practice' ));
	echo '</nav>'; ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<header class="page__header">	
	<?php the_content(); ?>
</header>
<?php endwhile; endif; ?>

<div id="grid-team" class="content grid-team">
	<div class="grid-sizer"></div>
	<div class="gutter-sizer"></div>
<?php 
$staff_count = 0;
$partner_count = 0;
$emeritus_count = 0;
$i = 0;
$staff_args = array(
    'post_type' =>'team',
    'post_status'=>'publish', 
    'orderby' => 'rand',
    'posts_per_page' => -1,
    'meta_key' => 'partner',
    'meta_value' => 0
); 
$partners = get_posts( array(
    'post_type' =>'team',
    'post_status'=>'publish', 
    'orderby' => 'rand',
    'posts_per_page' => -1,
    'meta_key' => 'partner',
    'meta_value' => 1
));
$staff_query = new WP_Query($staff_args);
if ($staff_query->have_posts()) :
while ($staff_query->have_posts()) : $staff_query->the_post();
	$image = get_field('image1');
	$image2 = get_field('image2');
	$title = get_field('title');
	$name = get_the_title();
	$nameCount = strlen($name);
	if($nameCount >= 16 || strpos($name, 'w') !== false){
		$captionClass = 'twoline';
		$name = wordwrap($name, 16, "<br />\n");
	} else {
		$captionClass = '';
	}
	$partner = get_field('partner');
	$credentials = get_field('credentials');
	$resume = get_field('resume');
	$bio = get_field('bio');
	$bio = preg_replace("/'/", "&#39;", $bio);
	$bio = preg_replace("/\"/", "&quot;", $bio);
// 	echo $image;
	if($image['url'] != '') {
		$staff_count++;
		$img = $image['sizes']['sq260'];
		if($image2['url'] != '') {
			$img2 = $image2['sizes']['sq500'];
			$width = $image2['sizes']['sq500-width'];
			if($width < 500) {
// 				$img2 = $image['sizes']['sq260'];
			}
		} else {
			$img2 = $image['sizes']['sq500'];
			$width = $image['sizes']['sq500-width'];
			if($width < 500) {
// 				$img2 = $image['sizes']['sq260'];
			}
		}
		echo '<div class="grid-item grid-item--staff bw effect-caption" data-slide-id="'.$staff_count.'" data-id="'.get_the_ID().'">';
		echo '<a href="#" data-type="staff" data-name="'.get_the_title().'" data-title="'.$title.'" data-credentials="'.$credentials.'" data-bio="'.$bio.'" data-largesrc="'.$img2.'" data-resume="'.$resume['url'].'"><img src="'.$img.'" alt="'.get_the_title().'"/>';
		echo '<div class="text grad-bg"><h3>'.$name.'</h3><p class="caption '.$captionClass.'">'.$title.'</p></div></a>';
		echo '</div>';
	} 
	if($staff_count == 4 || $staff_count == 6 || $staff_count == 8 || $staff_count == 10 || $staff_count == 12 || $staff_count == 14 || $staff_count == 16) {
		if($i <= 7) {
		$partner_image = get_field('image1', $partners[$i]->ID);
		$partner_image2 = get_field('image2', $partners[$i]->ID);
		$title = get_field('title', $partners[$i]->ID);
		$credentials = get_field('credentials', $partners[$i]->ID);
		$emeritus = get_field('partner_emeritus', $partners[$i]->ID);
		$prebio = get_field('bio', $partners[$i]->ID);
		$bio = preg_replace("/<\/?div[^>]*\>/i", "", $prebio); 
		$resume = get_field('resume_pdf', $partners[$i]->ID);
		$link = get_template_directory_uri();
		if($partner_image['url'] != '') {
			$partner_img = $partner_image['sizes']['sq500'];
			$partner_img2 = $partner_image2['sizes']['large'];
			if($emeritus == 1) {
				$emeritus_count++;
				$type = 'emeritus';
				$slideType = 'data-slide-emeritus-id="'.$emeritus_count.'"';
			} else {
				$partner_count++;	
				$type = 'partner';
				$slideType = 'data-slide-partner-id="'.$partner_count.'"';
			}
			$class = 'grid-item--partner';
			echo '<div class="grid-item '.$class.' effect-caption" '.$slideType.' data-id="'.$partners[$i]->ID.'">';
			echo '<a href="#" data-type="'.$type.'" data-link="'.$link.'" data-name="'.get_the_title($partners[$i]->ID).'" data-title="'.$title.'" data-credentials="'.$credentials.'" data-bio="'.$bio.'" data-largesrc="'.$partner_img2.'" data-resume="'.$resume['url'].'"><img src="'.$partner_img.'" alt="'.get_the_title($partners[$i]->ID).'" />';
			echo '<div class="text grad-bg"><h3>'.get_the_title($partners[$i]->ID).'</h3><p class="caption">'.$title.'</p></div>';
			echo '</a></div>';
			$i++;
		}
		}
	}
?>
<?php endwhile; endif; ?>
</div>

<?php include('overlay-team.php'); ?>

<?php get_footer(); ?>