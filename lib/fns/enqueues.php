<?php

namespace NetmindSiteMods\enqueues;

function enqueue_scripts(){
  wp_register_style( 'kcloop', plugin_dir_url( __FILE__ ) . '../css/kcloop.css', null, plugin_dir_url( __FILE__ ) . '../css/kcloop.css' );
}
add_action( 'wp_head', __NAMESPACE__ . '\\enqueue_scripts' );