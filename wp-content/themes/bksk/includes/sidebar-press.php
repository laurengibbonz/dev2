<div class="sort">
  <h4>Press Archive</h4>
  <?php
  $archive = wp_get_archives(array('post_type' => 'press', 'echo' => '0'));
  $blog_url = get_bloginfo('url');
  echo str_replace($blog_url, ($blog_url . '/press/#'), $archive);
  ?>
  <li class="clear-all"><a href="#">Clear All</a></li>
</div>




