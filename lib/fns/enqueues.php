<?php

namespace NetmindSiteMods\enqueues;

function enqueue_scripts(){
  wp_register_script( 'slickslider', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', ['jquery'], '1.8.1', true );
  wp_register_script( 'relatedposts', plugin_dir_url( __FILE__ ) . '../js/relatedposts.js', ['jquery','slickslider'], filemtime( plugin_dir_path( __FILE__ ) . '../js/relatedposts.js' ), true );
  wp_register_style( 'relatedposts', plugin_dir_url( __FILE__ ) . '../' . NETMIND_CSS_DIR . '/relatedposts.css', null, filemtime(plugin_dir_path( __FILE__ ) . '../' . NETMIND_CSS_DIR . '/relatedposts.css') );
}
add_action( 'wp_head', __NAMESPACE__ . '\\enqueue_scripts' );
