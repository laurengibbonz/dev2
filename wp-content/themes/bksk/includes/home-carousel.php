<div id="home-carousel">

  <a href="#" class="btn-prev nt">Previous</a>
  <a href="#" class="btn-next nt">Next</a>
  
  <div id="home-slides">
    <?php
    $slides = get_field('slideshow');
    if ($slides){
      while(has_sub_field('slideshow')){
        $image = get_sub_field('image');
        $image = $image['sizes']['carousel'];
        $text = get_sub_field('text');
        $url = get_sub_field('url');
        echo "<div class='home-slide' data-link='$url' data-img='$image'>";
        echo "<span>$text</span>";
        echo "</div>";
      }
    }
    ?>
  </div><!-- Slides -->
  
</div><!-- Home Carousel -->