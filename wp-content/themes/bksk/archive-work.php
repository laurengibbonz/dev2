 <?php
/**
 * @package WordPress
 * @subpackage Adapt Theme
 */
?>
<?php get_header(); ?>

<div class="work__search">
<div id="filters">
<div class="fourcol">
	<h3>Search By:</h3>
	<a href="#" class="filter--remove">Remove Filters</a>
</div>
<div class="fourcol">
	<div class="filter--one">
		<h3>Discipline</h3>
		<div class="group" data-group="discipline-architecture">
		<a href="#" class="discipline-architecture" data-filter-name="discipline1" data-filter-value=".architecture" data-filter=".Architecture"><label class="control control--checkbox">Architecture<input checked value=".architecture" type="checkbox"/><span class="control__indicator"></span></label></a>
		</div>
		<div class="group" data-group="discipline-interiors">
		<a href="#filter" class="discipline-interiors" data-filter-name="discipline2" data-filter-value=".interiors" data-filter=".interiors"><label class="control control--checkbox">Interiors<input value=".interiors" type="checkbox"/><span class="control__indicator"></span></label></a>
		</div>
	</div>
</div>
<div class="fourcol">
	<div class="group project_type filter filter--two interiors" data-group="interiors">
		<h3>Project Type</h3>
		<?php $terms = get_terms( array(
			'taxonomy' => 'interior_project_type',
			'hide_empty' => false,
		)); 
		$term_count = 0;
		foreach($terms as $term) {
		$term_count++;
		echo '<a href="#" class="'.$term->slug.'" data-filter-name="int_type" data-filter-value=".'.$term->slug.'"><label class="control control--checkbox">'.$term->name.'<input value=".'.$term->slug.'" type="checkbox"/><span class="control__indicator"></span></label></a>';
		} ?>	
	</div>
	<div class="filter filter--two specialty architecture">
		<h3>Specialty</h3>
		<div class="group" data-group="specialty-preservation">
		<a href="#" class="specialty-preservation preservation" data-filter-name="specialty" data-filter-value=".preservation" data-filter=".preservation"><label class="control control--checkbox">Preservation+<input value=".preservation" type="checkbox"/><span class="control__indicator"></span></label></a>
		</div>
		<div class="group" data-group="specialty-sustainability">
		<a href="#" class="sustainability" data-filter-name="specialty" data-filter-value=".sustainability" data-filter=".sustainability"><label class="control control--checkbox">Sustainability<input value=".sustainability" type="checkbox"/><span class="control__indicator"></span></label></a>
		</div>
	</div>
</div>
<div class="fourcol">
	<div class="group filter project_type filter--three architecture" data-group="architecture">
		<h3>Project Type</h3>
	<?php $terms = get_terms( array(
		'taxonomy' => 'project_type',
		'hide_empty' => false,
		'exclude' => array(4, 192, 193)
	)); 
	$term_count = 0;
	foreach($terms as $term) {
		$term_count++;
		echo '<a href="#" class="'.$term->slug.'" data-filter-name="type" data-filter-value=".'.$term->slug.'" data-filter=".'.$term->slug.'"><label class="control control--checkbox">'.$term->name.'<input value=".'.$term->slug.'" type="checkbox"/><span class="control__indicator"></span></label></a>';
	} ?>
	</div>	
	<div class="group project_type filter filter--three preservation" data-group="preservation">
		<h3>Project Type</h3>
	<?php $terms = get_terms( array(
		'taxonomy' => 'specialty',
		'hide_empty' => false,
		'exclude' => array(184,17)
	)); 
	$term_count = 0;
	foreach($terms as $term) {
		$term_count++;
		echo '<a href="#filter=.'.$term->slug.'" class="'.$term->slug.'" data-filter-name="type'.$term_count.'" data-filter-value=".'.$term->slug.'" data-filter=".'.$term->slug.'"><label class="control control--checkbox">'.$term->name.'<input value=".'.$term->slug.'" type="checkbox"/><span class="control__indicator"></span></label></a>';
	} ?>
	</div>	
</div>
</div>
<div class="keyword--work">
	<h3>Keyword Search</h3>
	<input type="text" class="quicksearch" placeholder="" />
</div>
</div>
<div class="loading-wrapper"><div class="loading"></div></div>		
<div id="grid" class="grid-work">
	<div class="grid-sizer"></div><div class="gutter-sizer"></div>
<?php 
$f_types = array();	
$types = array();
$ids = array();
$taxonomy = array('project_type', 'interior_project_type', 'specialty');

$terms = get_terms( array(
		'taxonomy' => $taxonomy,
		'hide_empty' => false,
		'exclude' => 4
	)); 
	$term_count = 0;
	foreach($terms as $term) {
		array_push($types, $term->slug);
	}
	//recursive array search not picking up first array hack
	array_push($f_types, array('id' => '0', 'type' => 'test'));
	
foreach($types as $type) {
	${'feat_'.$type.'s'} = get_field('featured_'.$type, 5376);	
	if(${'feat_'.$type.'s'}) {
		foreach(${'feat_'.$type.'s'} as ${'feat_'.$type}){
			array_push($f_types, array('id' => ${'feat_'.$type}->ID, 'type' => $type));
			array_push($ids, ${'feat_'.$type}->ID);
		}
	}
}

	$feat_archs = get_field('featured_architecture', 5376);
	if($feat_archs) {
		foreach($feat_archs as $feat_arch) {
			array_push($f_types, array('id' => $feat_arch->ID, 'type' => 'architecture'));
			array_push($ids, $feat_arch->ID);
		}
	}
	
	$feat_interiors = get_field('featured_interiors', 5376);
	if($feat_interiors) {
		foreach($feat_interiors as $feat_interior) {
			array_push($f_types, array('id' => $feat_interior->ID, 'type' => 'interiors'));
		}
	}
	
	$feat_defaults = get_field('featured', 5376);
	if($feat_defaults) {
		foreach($feat_defaults as $feat_default) {
			array_push($f_types, array('id' => $feat_default->ID, 'type' => 'default'));
		}
	}
	
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;	
$count = 0;
$small_count = 0;
$args = array(
            'post_type' =>'work',
            'post_status'=>'publish', 
//             'orderby' => 'meta_value_num',
			'orderby' => 'rand',
            'meta_key' => 'featured',
            'order' => 'DESC',
            'posts_per_page' => -1,
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
if (have_posts()) :
while (have_posts()) : the_post();

$count++;
$inprogress = get_field('in-progress');
$disciplines = get_field('discipline');

$keywords = get_field('keywords');
$keyword_types = array();
$feat_img = get_field('feat_img');
if($feat_img != '') {
	$feat_img = $feat_img['sizes']['sq500'];
} else {
	$feat_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'sq500');
	$feat_img = $feat_img[0];
}
$interiors_feat_img = get_field('interiors_feat_img');
if($interiors_feat_img != '') {
	$interiors_feat_img = $interiors_feat_img['sizes']['sq500'];
}

//get terms
$project_terms = get_the_terms( get_the_ID(), 'project_type' );
$interior_terms = get_the_terms( get_the_ID(), 'interior_project_type' );
$specialty_terms = get_the_terms( get_the_ID(), 'specialty' );
$types = array();
	if(search($f_types, 'id', $post->ID) != '') {
		$values = search($f_types, 'id', $post->ID);

		foreach($values as $value) {
			array_push($types, $value['type']);	
		}

	} else {
	} ?>  
<?php if($feat_img != '') { ?>

	<div class="grid-item <?php if($disciplines) { foreach($disciplines as $discipline) { array_push($keyword_types, strtolower($discipline)); echo strtolower($discipline).' '; } }if($project_terms) { foreach ($project_terms as $p_term) { array_push($keyword_types, $p_term->slug); echo $p_term->slug .' '; } } if($interior_terms){ foreach ($interior_terms as $i_term) array_push($keyword_types, $i_term->slug); echo $i_term->slug .' ';} if($specialty_terms) { foreach ($specialty_terms as $s_term) { array_push($keyword_types, $s_term->slug); echo $s_term->slug .' '; } } if($types) { foreach($types as $type) { echo 'featured_'.$type.' ' ; } }?>" <?php if(in_array($post->ID, $ids)) { echo 'data-category="featured"'; } else { echo 'data-category="z"'; } ?>>

	<?php if(!$inprogress) { ?>
	    <a class="link" href="<?php the_permalink(); ?>">
	<?php } else { ?>
	<!-- <span class="in-progress">Work In Progress</span> -->
	<?php } ?>
		    <img src="<?php echo $feat_img; ?>" alt="<?php echo the_title(); ?>" />
	<?php if($interiors_feat_img != '') { ?>
			<img class="img--interiors" src="<?php echo $interiors_feat_img; ?>" alt="<?php echo the_title(); ?>" />
	<?php } ?>
		<div class="text grad-bg">
			<h3><?php the_title(); ?><span class="keywords"><?php if($keywords) echo $keywords; if($keyword_types) foreach($keyword_types as $k_type) echo ' '.$k_type; ?></span></h3>		  	
		</div>
	<?php if(!$inprogress) { ?>
	    </a>
	<?php } ?>    
	    
</div><!-- item -->

<?php $small_count++;
if($small_count >= 10 && ($small_count % 9) == 0) {
	echo '<div class="grid-item grid-item--block '; if($disciplines) foreach($disciplines as $discipline) echo strtolower($discipline).' '; echo '"'; if($small_count % 18 == 0) { echo 'data-category="featured"'; } else { echo 'data-category="z"'; } echo '></div>';
} ?>
<?php } ?>
   
<?php endwhile; ?>                	     
</div><!-- END grid-work -->

<div id="empty">
	<h2>No projects match your search.</h2>
	<p>Please try to <a href="javascript:reset(true);">remove filters</a>.</p>
</div>
<?php endif; ?>

<?php get_footer(); ?>