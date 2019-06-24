<?php
if(isset($_GET['search-type'])) {
    $type = $_GET['search-type'];
    if($type == 'post') {
        load_template(TEMPLATEPATH . '/search-post.php');
    } 
} else {
        load_template(TEMPLATEPATH . '/search-global.php');
}
?>