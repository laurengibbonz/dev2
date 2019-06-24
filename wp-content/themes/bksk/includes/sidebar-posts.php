<div class="sort">
  <h4>Latest (Po)sts</h4>
  <?php $latest = new WP_Query("post_type=post&posts_per_page=8&orderby=date&order=DESC"); ?>
  <?php while ($latest->have_posts()) : $latest->the_post();?>
  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
  <?php endwhile; ?>
</div>


<div class="sort">
  <h4>Popular Tags</h4>
  <?php wp_tag_cloud(array(
  	'smallest' => 100, 
    'largest'  => 100,
    'unit'     => '%', 
    'number'   => 20,
  )); ?>
</div>


<div class="sort">
  <h4>Archive</h4>
  <?php wp_get_archives(); ?> 
</div>
