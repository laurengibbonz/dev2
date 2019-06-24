<?php
/**
 * @package WordPress
 * @subpackage: BKSK
 * Template Name: Recognition
 */
?>

<?php get_header(); ?>
<div id="content">

<?php $ids = get_field('featured', false, false);	
	echo '<div class="featured__header">';
	echo '<h3>Featured Projects</h3>';
	$args = array(
	'post_type' => 'work',
	'orderby' => 'rand',
	'post__in' => $ids,
	'posts_per_page' => 4
);
$the_query = new WP_Query( $args );
if ( $the_query->have_posts() ) {
	while ( $the_query->have_posts() ) {
	$the_query->the_post();
	$feat_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'sq500');
	echo '<div class="fourcol effect-caption"><a href="'.get_the_permalink($post->ID).'"><img src="'.$feat_img[0].'" alt="'.get_the_title().'" /><caption><h3 class="caption">'.get_the_title().'</h3></caption></a></div>';
	} 
} 
echo '</div>'; ?>

<aside id="post">

<h3>Press</h3>
<?php $args = array(
        'post_type' =>'press',
        'post_status'=>'publish', 
        'orderby' => 'date',
        'posts_per_page' => -1,
	    'meta_query' => array(
	        array(
	            'key' => 'featured',
	            'value' => '1', 
	            'compare' => '=='
	        )
	    )
    ); 
query_posts($args);
if(have_posts()) :
	echo '<div id="accordion">';
	$year_variable = '';
	$count = 0;
	$text = '';
	while(have_posts()) : the_post(); 
		$source = get_field('website');
		$link = get_field('website_link'); 
		$post_year = get_the_date( 'Y' );
	    $year_int = intval($post_year);
	    //close accorion content on new year
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
		echo '<p>';
		$terms = get_field('project');
	    //associate press with project else associate with BKSK
	    if($terms) {
		    foreach($terms as $term) {
			    echo '<a href="'.get_the_permalink($term).'">';
			    echo get_the_title($term);
			    echo '</a>';
			}
		} else {
			echo 'BKSK Architects';
		} 
		echo ' - ';
		if($link != '') {
			echo '<a target="_blank" href="'.$link.'">&ldquo;'.get_the_title().',&rdquo;</a> ';
		} else {
			echo '&ldquo;'.get_the_title().',&rdquo; ';
		}
		echo $source.', '.get_the_time('F Y').'</p>';
		$count++; 
	endwhile; 
echo '</div></div>'; 
endif; wp_reset_query(); ?>


<?php $args = array(
    'post_type' =>'award',
    'post_status'=>'publish', 
    'orderby' => 'date',
    'posts_per_page' => -1
); 
query_posts ($args);
if (have_posts()) :
	$year_variable = '';
	$award_array = array();
	while (have_posts()) : the_post(); 
		$award = get_field('award');
		$post_year = get_the_date( 'Y' );
		$year_int = intval($post_year);
	    $year_variable = $post_year;
	    $terms = get_field('project');
	    if($terms) {
		    foreach($terms as $term) {
			    $term_link = get_the_permalink($term);
				$award_text = '<p>'.get_the_title().', '.$award.'</p>';
				array_push($award_array, array('award' => $award_text, 'term' => get_the_title($term), 'term_link' => $term_link, 'date' => $post_year));
		    }
	    } else {
		    $award_text = '<p>'.get_the_title().', '.$award.'</p>';
		    array_push($award_array, array('award' => $award_text, 'term' => 'z_none', 'term_link' => '', 'date' => $post_year));
	?>
		<?php } ?>

<?php endwhile; endif; wp_reset_query(); ?>

<?php 
echo '<h3>Awards</h3>';
echo '<div id="accordion" class="awards">';
$sort = array();
foreach($award_array as $k=>$v) {
    $sort['date'][$k] = $v['date'];
    $sort['term'][$k] = $v['term'];
}
array_multisort($sort['date'], SORT_DESC, $sort['term'], SORT_ASC,$award_array);

// 	$award_array = array_reverse($award_array);
// var_dump($award_array);
$count = 0;	
$year_variable = '';
$term_variable = '';
foreach($award_array as $award) {
	$post_year = $award['date'];
	$term = $award['term'];
	if($term == 'z_none') {
		$term = 'BKSK Architects';
	}
    $year_int = intval($post_year);
    //new year variable - separate accordions
	if ($year_variable !== $post_year && $year_int >= 2012) {
	    if($count != 0) {
		    echo '</div>';
	    }
	    if($year_int == 2012) {
		    $post_year = '2012 and earlier';
	    }
        echo '<div class="accordion-header">' . $post_year . '<span class="arrow"></span></div><div class="accordion-content">';
        //change back $post_year for 2012
        $post_year = $award['date'];
    }
    //2012 and earlier - separate years
    if($year_variable !== $post_year && $year_int < 2012) {
		echo '</article>';
	    echo '<p>'.$year_int.'</p>';
    }
    $year_variable = $post_year;
    //if new project group - seaparate group
    if($term_variable !== $term) {
	    echo '</article><article class="group">';
	    if($term != 'BKSK Architects') {
		    echo '<a href="'.$award['term_link'].'">';
		} 
		echo $term;
		if($term != 'BKSK Architects') {
		    echo '</a>';
		} 
	}
    echo $award['award'];
	$term_variable = $term;
    $count++;
} 
echo '</div>'; ?>
</aside>

<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>