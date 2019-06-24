<?php
  get_header(); while (have_posts()) : the_post();
  /* Variables */
  $projID = $post->ID;
  $occupancy = get_field('occupancy_date');
  $location = get_field('location');
  $client = get_field('client');
  $pdf = get_field('pdf');
  $video = get_field('video');
  $quote = get_field('quote');
  $quote_source = get_field('quote_source');
  parse_str($_SERVER["QUERY_STRING"], $query_array);
  if(!empty($query_array['order']) && $query_array['order'] == 'interiors') {
	  $types = array('interior_photographs','photographs','drawings','process','data', 'context');
	  $forceorder = true;
  } else {
	  $types = array('photographs','interior_photographs','drawings','process','data', 'context');
	  $forceorder = false;
  } ?>

<?php $slides = array();
	$interior_ids = array();
	$ids = array();
	foreach($types as $type) {
	if(have_rows($type)) :
	while( have_rows($type) ): the_row(); 
		$image = get_sub_field('image');
// 		echo $image['ID'].'<br />';
		if($image) {
			$image_types = get_field('image_type', $image['ID']);
			if($image_types && in_array('interiors', $image_types) && $forceorder == true) {
				foreach($image_types as $image_type) {
					if($image_type == 'interiors') {
						array_push($interior_ids, $image['ID']);
					}	
				}
			} else {
				array_push($ids, $image['ID']);
			}
		}
// 		$image = $image['sizes']['large'];
	endwhile; endif;
	}
	
	$ids = array_merge($interior_ids, $ids);
	
	$args = array(
            'post_type' => 'attachment',
            'orderby' => 'post__in',
            'post__in' => $ids,
            'post_status' => 'inherit',
            'posts_per_page' => -1
        ); 
		query_posts ($args);
		if (have_posts()) :
		while (have_posts()) : the_post();
		$ratio = wp_get_attachment_metadata($post->ID);
		$width = $ratio['width'];
		$height = $ratio['height'];
		if(($height/$width) < .55) {
			$image = wp_get_attachment_image_src($post->ID, 'large');
		} else {
			$image = wp_get_attachment_image_src($post->ID, 'large');	
		}
		array_push($slides, $image[0]);
	endwhile; endif; wp_reset_query();
	
	if($slides) {
		echo '<div class="loading-wrapper"><div class="loading"></div></div>';
		echo '<div id="slides">';
	if($video) {
		echo '<span>'.$video.'</span>';
	}
	foreach($slides as $slide) {
		if($slide != 'NULL' || $slide != 0) {
// 			echo $slide;
			echo '<span><img src="'.$slide.'" alt="'.get_the_title().'" /></span>';
		}
	}
		echo '</div>';
	} ?>

<header class="page__header">
  <h2><?php the_title(); ?></h2>
</header>

<div class="single-work">

    <div class="fourcol">
      <div class="work-box">
        <h4>Project Type</h4>
        <?php
          $type = wp_get_post_terms($post->ID, 'project_type', array("fields" => "all"));
          for ($i = 0; $i < count($type); $i++){
            if ($type[$i]->name != 'Featured') {
              echo '<a href="' . get_site_url().'/work/#.'.$type[$i]->slug.'">';
              echo $type[$i]->name;
              echo '</a>';
            }
          } 
          $interior = false;
          $disciplines = get_field('discipline');
          if($disciplines) :
          foreach($disciplines as $discipline) {
	      	if($discipline == 'Interiors') {
		      $interior = true;
	          echo '<a href="' . get_site_url().'/work/#.interiors" >';
	          echo 'Interiors';
	          echo '</a>';
          	}   
          }
          //catch if Interiors not checked but Interiors Project Type selected
          $interior_types = get_the_terms($post->ID, 'interior_project_type');
          if($interior_types && $interior == false) {
	          echo '<a href="' . get_site_url().'/work/#.interiors" >';
	          echo 'Interiors';
	          echo '</a>';
          }
          endif;
          $specialties = get_the_terms($post->ID, 'specialty');
          $skip = false;
          if($specialties) :
          foreach($specialties as $specialty) {
	          if($specialty->term_id == 184 || $specialty->term_id == 17 || $specialty->parent == 184) :
	          if($specialty->parent == 184 || $specialty->term_id == 184) {
		          $link = '.preservation';
		          $name = 'Preservation';
	          } else {
		          $link = '.sustainability';
		          $name = 'Sustainability';
		          $skip = false;
	          }
	          if($skip != true) {
		          echo '<a href="' . get_site_url().'/work/#.'.$link.'" >';
		          echo $name;
		          echo '</a>';
		      } if($specialty->parent == 184 || $specialty->term_id == 184) {
		          $skip = true;
	          }    
		      endif;
          } 
          endif; ?>
      </div>

      <?php if($occupancy) {
        echo '<div class="work-box"><h4>Occupancy</h4>' . $occupancy . '</div>';
      } if($location) {
        echo '<div class="work-box"><h4>Location</h4>' . $location . '</div>';
      } if($client) {
        echo '<div class="work-box"><h4>Client</h4>' . $client . '</div>';
      } if($pdf) {
        echo '<div class="work-box"><h4><a class="pdf" href="'.$pdf['url'].'">Download Project PDF</a></h4></div>';
      } ?>
    </div>

    <div class="twocol">
	<?php the_field('description');
		
	$args = array(
	'post_type' => 'award',
	'meta_query' => 
		array(
			array(
				'key' => 'project',
				'value' => $post->ID,
				'compare' => 'LIKE'
			),
		),
	);
	$query = new WP_Query( $args );
	if ( $query->have_posts() ) :
		echo '<div class="section"><h4>Awards</h4>';
		while ( $query->have_posts() ) :
			$query->the_post();
			$press_projID = get_field('project');
			if($projID == $press_projID[0]) :
				$award = get_field('award');
				echo '<p>'.get_the_title().', '.$award.', '.get_the_time('Y').'</p>';
			endif;
		endwhile;
		echo '</div>';
	endif;
	wp_reset_query();
	
	$args = array(
	'post_type' => 'press',
	'meta_query' => 
		array(
			array(
				'key' => 'project',
				'value' => $post->ID,
				'compare' => 'LIKE',
			),
		),
	);
	$query = new WP_Query( $args );
	if ( $query->have_posts() ) :
		echo '<div class="section"><h4>Press</h4>';
		while ( $query->have_posts() ) :
			$query->the_post();
			$press_projID = get_field('project');
			if($projID == $press_projID[0]) :
				$source = get_field('website');
				$link = get_field('website_link'); 
				if($link != '') {
					echo '<p><a target="_blank" href="'.$link.'">&ldquo;'.get_the_title().',&rdquo;</a> ';
				} else {
					echo '<p>&ldquo;'.get_the_title().',&rdquo; ';
				}
				echo $source.', '.get_the_time('F Y').'</p>';
			endif;
		endwhile;
		echo '</div>';
	endif;
	wp_reset_query();
	
	$credits = get_field('credits');
	if($credits != '') {
		echo '<div class="section">';
		echo $credits;
		echo '</div>';
	} ?>
    </div>

	<div class="fourcol">
	<?php if(have_rows('related_posts')) :
		echo '<div class="work-box"><h4>Related Projects</h4>';
		while(have_rows('related_posts')) : the_row();
			$project = get_sub_field('post');
			if($project != '') {
				echo '<a href="'.get_the_permalink($project->ID).'">'.get_the_title($project->ID).'</a>';	
			}
		endwhile; 
		echo '</div>';
	endif; 
		
	if ($quote != ''){
        echo '<div class="quote"><p>"' . $quote . '"</p>';
        if ($quote_source){
     	   echo '<p class="quote-source">' . $quote_source . '</p>';
        }
    echo '</div>';
    } ?>
	</div>

</div><!-- Single Work -->

<?php endwhile; get_footer(); ?>