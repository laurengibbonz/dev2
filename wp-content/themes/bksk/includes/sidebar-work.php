<div class="sort work-sort" id="filter-type">
  <h4>Project Type</h4>
  <?php wp_list_categories('taxonomy=project_type&hide_empty=0&title_li=&orderby=name'); ?>
  <a href="#" class="btn-all btn-clear">All Projects</a>
</div>


<div class="sort work-sort" id="filter-focus">
  <h4>Project Focus</h4>
  <?php wp_list_categories('taxonomy=focus&hide_empty=0&title_li=&orderby=name'); ?>
  <a href="#" class="btn-clear">Clear All</a>
</div>
