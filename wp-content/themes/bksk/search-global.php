<?php
/**
 * @package WordPress
 * @subpackage BKSK
 */
?>
<?php get_header(); ?>

<header class="page__header">	
	<p>Search results: <span class="gray"><?php the_search_query(); ?></span></p>
</header>

<?php 
$work_array = array();	
$thinking_array = array();	
$recognition_array = array();	
if ( have_posts() ) :
while ( have_posts() ) : the_post();

$type = get_post_type();
if($type == 'work') {
	$progress = get_field('in-progress');
	if($progress == 1) {
		$link = get_site_url().'/work';
	} else {
		$link = get_the_permalink($post->ID);
	}
	$feat_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'sq260');
	if($feat_img != '') {
	$content = '<a href="'.$link.'"><img src="'.$feat_img[0].'" alt="'.get_the_title().'" /><caption><h3 class="caption">'.get_the_title().'</h3></caption></a>';
	}
	array_push($work_array, $content);
}
if($type == 'post' || $type == 'lab') {
	$title = get_the_title(); 
    $title = substr($title, 0, 130);
    if(strlen($title) > 130) {
        $title .= '...';
    }
    if($type == 'post') {
	    $type = '(Po)st';
    }
	$content = '<p class="date">'.get_the_time('F j, Y').' / '.$type.'</p><a href="'.get_the_permalink($post->ID).'"><h3>'.$title.'</h3></a>';
	array_push($thinking_array, $content);
}
if($type == 'press' || $type == 'award') {
	$terms = get_field('project');
    if($terms) {
	    foreach($terms as $term) {
		    $project = get_the_title($term);
		    $project_link = '<a href="'.get_the_permalink($term).'">'.$project.'</a>';
		}
	} else {
		$project = 'BKSK Architects';
		$project_link = $project;
	} 
	if($type == 'press') {
		$source = get_field('website');
		$link = get_field('website_link'); 
		$content_link = '<a href="'.$link.'" target="_blank">'.get_the_title().'</a>," '.$source;
	} else {
		$award = get_field('award');
		$content_link = get_the_title().', '.$award;
	}
	$content = '<p class="date">'.get_the_time('Y').' / '.$type.'</p><p>'.$project_link.' - '.$content_link.', '.get_the_time('F Y').'</p>';
	array_push($recognition_array, $content);
}
endwhile;
endif; ?>

<div class="page__content">
<?php
$query_string = get_search_query();
// $query_string = explode("=", $query_string);
// $query_string = $query_string[1];
$query_string = str_replace('%20',' ',$query_string);
?>

<div class="twocol">
<?php if($query_string == 'jobs' || $query_string == 'careers' || $query_string == 'internships') { ?>
	<div class="search-careers">
	<h2>Careers</h2>
	<?php $children = get_pages('post_type=careers&post_status=publish');
if( $children ) {
	echo '<h2>Current Opportunities</h2>';
	$args = array(  'post_type' => 'careers',
		            'post_status'=> 'publish',
						'sort_column' => 'post_title',
					'hierarchical' => 0  
					);
		$mypages = get_pages($args);
		foreach( $mypages as $page ) {    
			echo '<article class="loop-entry clearfix">';
			echo '<a href="'.get_permalink($page->ID).'"><h3>'.$page->post_title.'</h3><p>'.$page->post_excerpt.' </span>  <span class="black"> View Listing→</span></p></a></article>';
		}	
}
else { 
	noResults('careers'); 
}
	echo '</div>';
} else { ?>
	
<section class="search-work">
<h2>Work</h2>
<?php if(!empty($work_array)) {
	foreach($work_array as $work) {
		echo '<div class="twocol effect-caption">';
		echo $work;
		echo '</div>';
	}
} else {
	noResults('work'); 
} ?>
</section>

<div class="clearfix"></div>

<?php if(!empty($recognition_array)) {
	echo '<section class="section-news">';
	echo '<h2>Recognition</h2>';
	foreach($recognition_array as $recognition) {      
		echo '<div class="loop-entry">';
		echo $recognition;
		echo '</div>';
	}
	echo '</section>';
} else {

} ?>
</div><!-- /two  -->
        
        
        
<div class="twocol">
<h2>Thinking</h2>
<?php if(!empty($thinking_array)) {
	foreach($thinking_array as $thinking) {      
		echo '<div class="loop-entry">';
		echo $thinking;
		echo '</div>';
	}
} else {
	noResults('recognition'); 
} ?>
</div><!-- /search-right  -->
<?php } ?>

</div>

<?php get_footer(); ?>