<?php
$featured = get_category_by_slug('featured');
$understanding = get_term_by('name', 'Understanding the Syntax', 'keywords');
$exclude = $featured->term_id.','.$understanding->term_id;
?>
<div class="sort" id="filter-syntax">
  <h4>Syntax</h4>
  <li class="cat-item">
    <a href="<?php echo get_page_link('362'); ?>#keyword-<?php echo $understanding->slug ?>">
      <?php echo $understanding->name ?>
    </a>
  </li>
  <?php $categories = get_categories('taxonomy=syntax&orderby=name&hide_empty=0&exclude='.$exclude); ?>
  <?php foreach ($categories as $category): ?>
  	<li class="cat-item">
  		<a href="<?php echo get_page_link('362'); ?>#syntax-<?php echo $category->slug ?>">
  		<?php echo $category->name ?>
  		</a>
  	</li>
  <?php endforeach ?>
</div>


<div class="sort" id="filter-keyword">
  <h4>Keywords</h4>
  <?php $categories = get_categories('taxonomy=keywords&orderby=name&hide_empty=0&exclude='.$exclude); ?>
  <?php foreach ($categories as $category): ?>
  	<li class="cat-item">
  		<a href="<?php echo get_page_link('362'); ?>#keyword-<?php echo $category->slug ?>">
  		<?php echo $category->name ?>
  		</a>
  	</li>
  <?php endforeach ?>
</div>

<div class="sort">
  <h4>Tools</h4>
                <a href="http://www.bkskarch.com/lab/introducing-the-nyc-strategy-field/">NYC Strategy Field</a>
</div>

