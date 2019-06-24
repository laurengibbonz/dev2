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
	
while (have_posts()) : the_post();

// $featured = get_post_meta(get_the_ID(), 'featured', true);
/* if($featured != 1) :  ADD BACK IN ENDIF */

// $count++;
$inprogress = get_field('in-progress');
$disciplines = get_field('discipline');

$keywords = get_field('keywords');
$keyword_types = array();
$feat_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'sq500');
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
// 		echo $post->ID;
	}

// var_dump($types);
?>  
<?php if($feat_img) { ?>

	<div class="grid-item hidden <?php if($disciplines) { foreach($disciplines as $discipline) { array_push($keyword_types, strtolower($discipline)); echo strtolower($discipline).' '; } }if($project_terms) { foreach ($project_terms as $p_term) { array_push($keyword_types, $p_term->slug); echo $p_term->slug .' '; } } if($interior_terms){ foreach ($interior_terms as $i_term) array_push($keyword_types, $i_term->slug); echo $i_term->slug .' ';} if($specialty_terms) { foreach ($specialty_terms as $s_term) { array_push($keyword_types, $s_term->slug); echo $s_term->slug .' '; } } if($types) { foreach($types as $type) { echo 'featured_'.$type.' ' ; } }?>" <?php if(in_array($post->ID, $ids)) { echo 'data-category="featured"'; } else { echo 'data-category="z"'; } ?>>

	<?php if(!$inprogress) { ?>
	    <a class="link" href="<?php the_permalink(); ?>">
	<?php } ?>
		    <img src="<?php echo $feat_img[0]; ?>" alt="<?php echo the_title(); ?>" />
	<?php if($interiors_feat_img != '') { ?>
			<img class="img--interiors" src="<?php echo $interiors_feat_img; ?>" />
	<?php } ?>
		<div class="text grad-bg">
			<h3><?php the_title(); ?><span class="keywords"><?php if($keywords) echo $keywords; if($keyword_types) foreach($keyword_types as $k_type) echo ' '.$k_type; ?></span></h3>		  	
		</div>
	<?php if(!$inprogress) { ?>
	    </a>
	<?php } ?>    
	    
</div><!-- item -->

<?php $small_count++;
if($small_count >= 10 && ($small_count % 8) == 0) {
	echo '<div class="grid-item hidden grid-item--block ';if($disciplines) foreach($disciplines as $discipline) echo strtolower($discipline).' '; echo '"></div>';
	$small_count++;
} ?>
<?php } ?>
   
<?php endwhile; ?>