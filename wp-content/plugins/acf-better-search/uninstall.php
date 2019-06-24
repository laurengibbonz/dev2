<?php

  if (!defined('WP_UNINSTALL_PLUGIN'))
    die;

  delete_option('acfbs_fields_types');
  delete_option('acfbs_whole_phrases');
  delete_option('acfbs_lite_mode');
  delete_transient('acf_better_search_notice');