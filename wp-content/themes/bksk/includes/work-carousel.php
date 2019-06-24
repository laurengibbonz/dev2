<script>
<?php

$options = array();

$options['photographs'] = get_field('photographs');
if ($options['photographs']){
  $count = 0;
  echo "var photographs = [";
  while(has_sub_field('photographs')){
    $count++;
    $image = get_sub_field('image');
    $image = $image['sizes']['carousel'];
    echo "'" . $image . "'";
    if ($count < count($options['photographs'])){
      echo  ",";
    }
  }
  echo "];";
}

$options['context'] = get_field('context');
if ($options['context']){
  $count = 0;
  echo "var context = [";
  while(has_sub_field('context')){
    $count++;
    $image = get_sub_field('image');
    $image = $image['sizes']['carousel'];
    echo "'" . $image . "'";
    if ($count < count($options['context'])){
      echo  ",";
    }
  }
  echo "];";
}

$options['process'] = get_field('process');
if ($options['process']){
  $count = 0;
  echo "var process = [";
  while(has_sub_field('process')){
    $count++;
    $image = get_sub_field('image');
    $image = $image['sizes']['carousel'];
    echo "'" . $image . "'";
    if ($count < count($options['process'])){
      echo  ",";
    }
  }
  echo "];";
}

$options['drawings'] = get_field('drawings');
if ($options['drawings']){
  $count = 0;
  echo "var drawings = [";
  while(has_sub_field('drawings')){
    $count++;
    $image = get_sub_field('image');
    $image = $image['sizes']['carousel'];
    echo "'" . $image . "'";
    if ($count < count($options['drawings'])){
      echo  ",";
    }
  }
  echo "];";
}

$options['data'] = get_field('data');
if ($options['data']){
  $count = 0;
  echo "var data = [";
  while(has_sub_field('data')){
    $count++;
    $image = get_sub_field('image');
    $image = $image['sizes']['carousel'];
    echo "'" . $image . "'";
    if ($count < count($options['data'])){
      echo  ",";
    }
  }
  echo "];";
}

$options = array_filter($options);
$keys = array_keys($options);
$selected = $keys[0];

?>
</script>
<?php if ($options): ?>
  <div id="carousel">

    <a href="#" class="btn-prev nt">Previous</a>
    <a href="#" class="btn-next nt">Next</a>

    <div id="slides">
    </div>
    
    <div class="grid">
      <div class="dropdown">
        <ul class="options">
          <?php 
            foreach ($options as $key => $option) {
              $title = ucfirst($key);
              if ($key == $selected) {
                $display = 'style="display:none"';
              } else {
                $display = '';
              }
              $count = count($option);
                echo "<li date-option='$key' $display>$title ($count)</li>";
            }
          ?>
        </ul><!-- Options -->
        <div class="select <?php echo $selected ?>">
          <span class="selection"><?php echo ucfirst($selected); ?></span> &nbsp;
          <span class="num">1</span>/
          <span class="total"><?php echo count($options[$selected]); ?></span>
          <div class="arrow"></div>
        </div><!-- Select -->
      </div><!-- Dropdown -->
    </div>
  </div>
<?php endif ?>