<?php
while (have_posts()) : the_post();
$feat_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'grid-thumb'); ?>  

<div class="loop-entry">
	<p class="date"><?php the_time('F j, Y') ?></p>
	<a href="<?php echo esc_url( get_permalink(get_the_ID()) ); ?>">
	<h2> 
	<?php $title = get_the_title(); 
    echo substr($title, 0, 130);
    if(strlen($title) > 130) {
        echo '...';
    } ?>
	</h2>
	</a>
	<?php the_content('Read More'); ?>
</div><!-- loop-entry -->

<?php endwhile; ?>