<?php
/**
 * @package WordPress
 * @subpackage BKSK
 */
?>
<aside id="sidebar">

<?php if(is_page(5361) || is_tag() || is_post_type_archive('post') || is_singular('post') || is_search()) { 
// 	get_search_form();
// (Po)st Categories 
	echo '<div class="sidebar-box"><h3>Keyword Search</h3>';
	echo '<form method="get" id="searchform" action="'.get_site_urL().'/">
<input type="text" value="" name="s" id="s" />
<input type="hidden" name="search-type" value="post" />
<input type="hidden" name="post_types" value="post" />
<button type="submit" class="search-submit">Submit</button>
</form>';
	echo '</div>';
	echo '<div class="sidebar-box"><h3>Tags</h3>';
	$args = array(  'taxonomy' => 'post_tag', 'hide_empty'=> false, 'orderby' => 'title', 'include' => array( 25, 45, 21, 54, 53, 26, 64, 111, 44, 29)
	);
	$cats = get_terms($args);
	if($cats) {
		echo '<ul>';
		foreach( $cats as $cat ) {    
			echo '<li><a href="'.get_term_link($cat->term_id).'">'.$cat->name.'</a></li>';
		}
		echo '</ul>';	
	}
	echo '</div>';

// Instagram
	$jsonurl = "https://api.instagram.com/v1/users/self/media/recent/?access_token=1433913024.1677ed0.cf327409200347adbefb83d477754726&count=6";	
	$json = file_get_contents($jsonurl,0,null,null);
	$json_output = json_decode($json, true);

	echo '<div class="sidebar-box instagram"><a href="'.get_site_url().'/instagram"><h3>Instagram</h3></a>';
	foreach($json_output['data'] as $item) {
		$title = str_replace(' & ', ' &amp; ', $item['caption']['text']);
	    $link = $item['link'];
	    $image = $item['images']['low_resolution']['url'];  
// 	    $image = substr($image, 0, strpos($image, "?"));
	    
	    $type  = $item['type'];
	   
		echo '<a class="twocol" href="'.$link.'" target="_blank">';
		if($type == 'video') {
		    $video = $item['videos']['low_resolution']['url']; 
			echo '<video poster="'.$image.'" data-setup="{}">';
			echo '<source src="'.$video.'" type="video/mp4" />';
			echo '</video>';
		} else {
			echo '<img src="'.$image.'" alt="'.$title.'" />';
		}
		echo '</a>';
			
	}
	echo '</div>';


	echo '<div class="sidebar-box archive"><h3>Archive</h3>';
	
	$args = array(
        'post_type' =>'post',
        'post_status'=>'publish', 
        'orderby' => 'date',
        'posts_per_page' => -1
    ); 
	query_posts ($args);
	if (have_posts()) :
	$year_variable = '';
	$count = 0;
    $text = '';
	while (have_posts()) : the_post(); 
	$post_year = get_the_date( 'Y' );
	$year_int = intval($post_year);
    $year_int = intval($post_year);
	if ($year_variable !== $post_year && $year_int >= 2012) {
	    if($count != 0) {
		    echo '</div>';
	    }
	    if($year_int == 2012) {
		    $text = 'and earlier';
	    }
		echo '<div class="accordion-header">' . $post_year . ' '.$text.'<span class="arrow"></span></div><div class="accordion-content">';
    }
    $year_variable = $post_year;
    echo '<a href="'.get_the_permalink($post->ID).'">'.get_the_title().'</a>';
	$count++;
	endwhile;
	echo '</div>';
	endif;
	
	echo '</div>';
	
}	
?>

<?php if(is_page(5061)) { 
	echo '<div class="sidebar-box"><h3>Twitter</h3>';
		echo '<div class="twitter"></div>';
	echo '</div>';

	echo '<div class="sidebar-box"><h3>Press Inquiries</h3>';
	echo '<p>Contact: <a href="mailto:bkskinfo@bksk.com" target="_blank">bkskinfo@bksk.com</a></p>';
	echo '</div>';
} ?>

<?php if(is_page(5059) || is_post_type_archive('careers')) {
	echo '<div class="sidebar-box sidebar--careers">';
	$sidebar_text = get_field('sidebar_text', 5059);
	if($sidebar_text != '') {
		echo $sidebar_text;
	}
	echo '</div>';
} ?>

<?php if(is_post_type_archive('lab') || is_singular('lab')) { 
	echo '<div class="sidebar-box"><h3>Syntax</h3>';
	$args = array(  'taxonomy' => 'syntax', 'hide_empty'=> false, 'orderby' => 'title', 'exclude' => array(173)	);
	$cats = get_terms($args);
	if($cats) {
		echo '<ul class="filter">';
		echo '<li><a data-filter="understanding-the-syntax">Understanding The Syntax</a></li>';
		foreach( $cats as $cat ) {    
			echo '<li><a href="'.get_site_url().'/lab/#filter=syntax-'.$cat->slug.'" data-filter="syntax-'.$cat->slug.'">'.$cat->name.'</a></li>';
		}
		echo '</ul>';	
	}
	echo '</div>';
	
	echo '<div class="sidebar-box"><h3>Keywords</h3>';
	$args = array(  'taxonomy' => 'keywords', 'hide_empty'=> false, 'orderby' => 'title', 'exclude' => array(191) );
	$cats = get_terms($args);
	if($cats) {
		echo '<ul class="filter">';
		foreach( $cats as $cat ) {    
			echo '<li><a href="'.get_site_url().'/lab/#filter='.$cat->slug.'" data-filter="'.$cat->slug.'">'.$cat->name.'</a></li>';
		}
		echo '</ul>';	
	}
	echo '</div>';

	echo '<div class="sidebar-box"><h3>Tools</h3>';
	echo '<a href="'.get_site_url().'/lab/introducing-the-nyc-strategy-field/">NYC Strategy Field</a>';
	echo '</div>';

} ?>

</aside><!-- /sidebar -->