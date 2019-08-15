<?php

namespace NetmindSiteMods\autoptimize;

/**
 * Excludes specified pages from Autoptimize
 */
function do_not_optimize() {
  // Array of pages we don't want to autoptize
  $do_not_optimize = ['course','my-account','no-access'];

  foreach ($do_not_optimize as $page ) {
    if ( strpos( $_SERVER['REQUEST_URI'], $page ) )
      return true;
  }

  return false;
}
add_filter( 'autoptimize_filter_noptimize', __NAMESPACE__ . '\\do_not_optimize' );
