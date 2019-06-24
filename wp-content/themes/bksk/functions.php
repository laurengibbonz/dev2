<?php
/**
 * theme functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage BKSK
 * @since theme 1.0
 */

if ( ! function_exists( 'theme_setup' ) ) :
/**
 * theme setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 *
 * @since theme 1.0
 */
function theme_setup() {

	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Enable support for Post Thumbnails, and declare two sizes.
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'   => __( 'Top primary menu', 'twentyfourteen' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array('search-form', 'gallery', 'caption'
	) );
}
endif; // esc_setup
add_action( 'after_setup_theme', 'theme_setup' );

// register navigation menus
register_nav_menus( array( 'menu'=>__('Menu') ) );

/// add home link to menu
add_filter( 'wp_page_menu_args', 'home_page_menu_args' );
function home_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}

/* Remove toolbar */
show_admin_bar(false);

// menu fallback
function default_menu() {
	require_once (get_template_directory() . '/includes/default-menu.php');
}

/**
 * Enqueue scripts and styles for the front end.
 *
 * @since theme 1.0
 */
function theme_scripts() {
	wp_enqueue_style( 'theme-style', get_template_directory_uri() . '/css/style.min.css', array(), '20190601', 'all');
/*
	if(is_post_type_archive('lab')) {
		wp_enqueue_script( 'images', get_template_directory_uri() . '/js/imagesloaded.min.js', array( 'jquery' ), '20161201', true );	
		wp_enqueue_script( 'masonry', get_template_directory_uri() . '/js/masonry.4.1.1.min.js', array( ), false, true );
	}
*/
	if(is_post_type_archive('work') || is_page('team') || is_post_type_archive('lab') || is_home()) {
		wp_enqueue_script( 'images', get_template_directory_uri() . '/js/imagesloaded.min.js', array( 'jquery' ), '20161201', true );
		wp_enqueue_script( 'isotope', get_template_directory_uri() . '/js/isotope.3.0.1.min.js', array( 'jquery' ), '20170102', true );
		wp_enqueue_script( 'packery', get_template_directory_uri() . '/js/packery.1.3.2.min.js', array( 'jquery', 'isotope', 'images' ), '20170102', true );
	} if(is_page(2)) {	
		wp_enqueue_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBoNAm7T3ov5Yy_6TeL7ijFqb-IDyMrE3Q&callback=initMap', array( 'jquery', 'theme' ), '20180104', true );
	} if(is_singular('work')) {
		wp_enqueue_script( 'images', get_template_directory_uri() . '/js/imagesloaded.min.js', array( 'jquery' ), '20161201', true );
		wp_enqueue_script( 'modernizer', get_template_directory_uri() . '/js/modernizr.custom.js', array( 'jquery' ), '20170104', true );
		wp_enqueue_script( 'slick', get_template_directory_uri() . '/js/slick.min.js', array( 'jquery' ), '20170112', true );
	} 
	wp_enqueue_script( 'theme', get_template_directory_uri() . '/js/theme.min.js', array( 'jquery' ), '201701227', true );
}
add_action( 'wp_enqueue_scripts', 'theme_scripts' );

add_theme_support('post-thumbnails');
// add_image_size( 'sq1', 125, 125, true );
add_image_size( 'sq260', 260, 260, true );
add_image_size( 'sq500', 500, 500, true );
add_image_size( 'rect', 500, 240, true );
// add_image_size( 'loop', 1024, 512, true );
// add_image_size( 'slider', 9999, 800, true );

add_filter( 'jpeg_quality', create_function( '', 'return 90;' ) );

function work_url($slug) {
	return get_site_url().'/work/#'.$slug;
}

function homeImage($exclude, $type, $img, $nav, $url, $class, $title) { 
	$project = array();
	if($nav == 'work') {
		$link = work_url($url);
	} else {
		$link = get_site_url().'/'.$url;
	}
	if($class == 'top') {
		$class = 'grad-bg--top';
	} else {
		$class = 'grad-bg';
	}
	$ids = array();
	$feat_types = get_field('featured_'.$type, 5376);
	if($feat_types) {
		foreach($feat_types as $feat_type) {
			if(!in_array($feat_type->ID, $exclude)) {
				array_push($ids, $feat_type->ID);	
			}
		}
	}
	shuffle($ids);
	$args = array(
		'post_type' => 'work',
		'orderby' => 'rand',
		'post__in' => $ids,
		'posts_per_page' => 1
	);
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$interiors_feat_img = get_field('interiors_feat_img');
			if($img == 'interiors' && $interiors_feat_img != '') {
				$feat_img = get_field('interiors_feat_img');
				$feat_img = $feat_img['sizes']['sq500'];
			} else {
				$feat_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'sq500');	
				$feat_img = $feat_img[0];
			}
			$project['img'] = '<a href="'.$link.'"><img src="'.$feat_img.'" alt="'.get_the_title().'" /><div class="text '.$class.'"><h3>'.$title.'</h3></div><div class="caption"><h3>'.get_the_title().'</h3></div></a>';
			$project['id'] = get_the_ID();
			return $project;
		}
	} 	
}

function disciplineImage($size, $type, $img, $url, $title) { 
	$ids = array();
	$feat_types = get_field('featured_'.$type, 5376);
	if($feat_types) {
		foreach($feat_types as $feat_type) {
			array_push($ids, $feat_type->ID);
		}
	}
	shuffle($ids);
	$args = array(
		'post_type' => 'work',
		'orderby' => 'rand',
		'post__in' => $ids,
		'posts_per_page' => 1
	);
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$interiors_feat_img = get_field('interiors_feat_img');
			if($img == 'interiors' && $interiors_feat_img != '') {
				$feat_img = get_field('interiors_feat_img');
				$feat_img = $feat_img['sizes'][$size];
			} else {
				// $feat_img = wp_get_attachment_image_src(get_post_thumbnail_id(), $size);	
				// $feat_img = $feat_img[0];
				$feat_img = get_field('feat_img');
				$feat_img = $feat_img['sizes'][$size];
			}
			return '<a href="'.work_url($url).'"><img src="'.$feat_img.'" alt="'.get_the_title().'" /><div class="caption"><h3>'.get_the_title().'</h3></div><div class="text grad-bg"><h3>'.$title.'</h3></div></a>';
		}
	} 
}

function disciplineLabImage($type, $img, $url, $title) { 
	$ids = array();
	$project = array();
	$project['lab_img'] = '';
	$feat_types = get_field('featured_'.$type, 5376);
	if($feat_types) {
		foreach($feat_types as $feat_type) {
			array_push($ids, $feat_type->ID);
		}
	}
	shuffle($ids);
	$args = array(
		'post_type' => 'work',
		'orderby' => 'rand',
		'post__in' => $ids,
		'posts_per_page' => 1
	);
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			//$feat_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'sq500');	
			//$feat_img = $feat_img[0];	
			$feat_img = get_field('feat_img');
			if($feat_img != '') {
				$feat_img = $feat_img['sizes']['sq500'];
			} else {
				$feat_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'sq500');	
				$feat_img = $feat_img[0];	
			}
			$project['img'] = '<a href="'.work_url($url).'"><img src="'.$feat_img.'" alt="'.get_the_title().'" /><div class="caption"><h3>'.get_the_title().'</h3></div><div class="text grad-bg"><h3>'.$title.'</h3></div></a>';
			$project['title'] = get_the_title();
			$lab_img = get_field('lab_image');
			if($lab_img != '') {
				$lab_img = $lab_img['sizes']['sq500'];
				$project['lab_img'] = $lab_img;
			}
			return $project;
		}
	} 
}

function set_custom_post_types_admin_order($wp_query) {  
  if (is_admin()) {  
  
    // Get the post type from the query  
    $post_type = $wp_query->query['post_type'];  
  
    if ( $post_type == 'team' || $post_type == 'work') {  
  
      // 'orderby' value can be any column name  
      $wp_query->set('orderby', 'title');  
  
      // 'order' value can be ASC or DESC  
      $wp_query->set('order', 'ASC');
//       $wp_query->set('post_status', 'publish');   
    }  
  }  
}  
add_filter('pre_get_posts', 'set_custom_post_types_admin_order');  

function recursive_array_search($needle,$haystack) {
   $keys = '';
    foreach($haystack as $key=>$value) {
        $current_key=$key;
        if($needle===$value OR (is_array($value) && recursive_array_search($needle,$value) !== false)) {
            $keys .= $current_key;
        } else {
	        
        }
    }
    return $keys;
}

function search($array, $key, $value) 
{ 
    $results = array(); 

    if (is_array($array)) 
    { 
        if (isset($array[$key]) && $array[$key] == $value) 
            $results[] = $array; 

        foreach ($array as $subarray) 
            $results = array_merge($results, search($subarray, $key, $value)); 
    } 

    return $results; 
}

function my_nav_wrap() {
  // open the <ul>, set 'menu_class' and 'menu_id' values
  $wrap  = '<ul id="%1$s" class="%2$s">';
  
  // get nav items as configured in /wp-admin/
  $wrap .= '%3$s';
  
  // the static link 
  $wrap .= '<li class="back-top"><a class="toplink">Back to Top &uarr;</a></li>';
  
  // close the <ul>
  $wrap .= '</ul>';
  // return the result
  return $wrap;
 }
 
 function mobileBox($link, $text) {
	 echo '<div class="item block dark-gray">
		<div class="vertical-align-wrap">
			<div class="vertical-align">
				<a href="'.get_site_url().'/'.$link.'">
					<h3>'.$text.'</h3>
				</a>
			</div>
		</div>
	</div>';
 }
 
 function mobileMessage($text) {
	 echo '<div id="message"><h1>Please refresh for '.$text.' screen experience</h1></div>';
 }

function disciplineBlockImage($id) {
	$imgs = array();
	$images = get_field('images', $id);
	$rand_keys = array_rand($images, 2);	
	shuffle($rand_keys);
	$rand_image1 = $images[ $rand_keys[0] ]['image'];
	$rand_image2 = $images[ $rand_keys[1] ]['image'];
	$image1 = wp_get_attachment_image_src( $rand_image1['ID'], 'sq260' );
	$image2 = wp_get_attachment_image_src( $rand_image2['ID'], 'sq260' );
	$imgs['a'] = '<img src="'.$image1[0].'" alt="'.get_the_title().'" />';
	$imgs['b'] = '<img src="'.$image2[0].'" alt="'.get_the_title().'" />';
	return $imgs;
}

function disciplinePresBlockImage($id) {
	$pres_imgs = array();
	$images = get_field('pres_images', $id);
	$rand_keys = array_rand($images, 2);	
// 	shuffle($rand_keys);
	$rand_image1 = $images[ $rand_keys[0] ]['image'];
	$rand_image2 = $images[ $rand_keys[1] ]['image'];
	$image1 = wp_get_attachment_image_src( $rand_image1['ID'], 'sq260' );
	$image2 = wp_get_attachment_image_src( $rand_image2['ID'], 'sq260' );
	$pres_imgs['a'] = '<img src="'.$image1[0].'" alt="'.get_the_title().'" />';
	$pres_imgs['b'] = '<img src="'.$image2[0].'" alt="'.get_the_title().'" />';
	return $pres_imgs;
}

/*
add_filter( 'wp_image_editors', 'change_graphic_lib' );
function change_graphic_lib($array) {
	return array( 'WP_Image_Editor_GD', 'WP_Image_Editor_Imagick' );
}
*/

function attachment_image_link_remove_filter( $content ) {
	$link = get_permalink();
    $content =
    preg_replace(array('{<a[^>]*><img}','{/></a>}'), array('<a href="'.$link.'"><img','/></a>'), $content);
    return $content;
}
add_filter( 'the_excerpt', 'attachment_image_link_remove_filter' );

add_theme_support( 'html5', array( 'search-form', 'script', 'style' ) );

function noResults($type) {
	if($type == 'thinking') {
		echo '<div id="empty">
	    	<h2>No Lab or (Po)st articles found for that query.</h2>
		</div>';
	} else if($type == 'careers') {
		echo '<div id="empty">
	    	<h2>There are no current job openings at BKSK. Please check back.</h2>
		</div>';
	} else {
	echo '<div id="empty">
	    	<h2>No work found for that query.</h2>
		</div>';
	}
}

function add_search_to_wp_menu ( $items, $args ) {
	if( 'Navigation' === $args->menu ) {
$items .= '<li class="menu-item menu-item-search">';
$items .= '<div class="nav__search"><button id="btn-search" class="btn btn--search"><svg class="icon icon--search"><use xlink:href="#icon-search"></use></svg></button></div>';
$items .= '</li>';
	}
return $items;
}
add_filter('wp_nav_menu_items','add_search_to_wp_menu',10,2);

// REMOVE WP EMOJI
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

function wp_infinitepaginate(){ 
    $loopFile        = $_POST['loop_file'];
    $paged           = $_POST['page_no'];
    $posts_per_page  = get_option('posts_per_page');
 
    # Load the posts
$args = array(
            'post_type' =>'work',
            'post_status'=>'publish', 
            'orderby' => 'meta_value_num',
            'meta_key' => 'featured',
            'order' => 'DESC',
            'posts_per_page' => 40,
            'paged' => $paged,
            'meta_query' => array(
		        'relation' => 'OR',
		        array( 
		            'key'=>'featured',
		            'compare' => 'EXISTS'           
		        ),
		        array( 
		            'key'=>'featured',
		            'compare' => 'NOT EXISTS'           
		        )
		    )
        ); 
	query_posts($args);
    get_template_part( 'loop' , 'work' );
 
    exit;
}
add_action('wp_ajax_infinite_scroll', 'wp_infinitepaginate');           // for logged in user
add_action('wp_ajax_nopriv_infinite_scroll', 'wp_infinitepaginate');    // if user not logged in

add_filter('relevanssi_content_to_index', 'work_keywords', 10, 2);
add_filter('relevanssi_excerpt_content', 'work_keywords', 10, 2);

function work_keywords($content, $post) {
	$content .= get_field('keywords', $post->ID);
    $content .= " ";
    return $content;
}

add_filter('relevanssi_match', 'custom_field_weights');
function custom_field_weights($match) {
	$keywords = get_field('keywords', $match->doc);
	if($keywords != '') {
 		$match->weight = $match->weight * 2;
	}
	else {
		$match->weight = $match->weight / 2;
	}
	return $match;
}
/*
add_filter('relevanssi_modify_wp_query', 'rlv_asc_date');
function rlv_asc_date($query) {
	    $query->set('orderby', 'post_date');
	    $query->set('order', 'DESC');
	    return $query;
}
*/