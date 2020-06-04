<?php

namespace NetmindSiteMods\knowledgecenter;

function kc_loop( $atts ){
  global $post;
  $template = \netmind_get_template('kcloop');

  wp_enqueue_style( 'kcloop' );

  $knowledge_areas = wp_get_object_terms( $post->ID, ['knowledge_area'] );
  if( $knowledge_areas ){
    $meta_knowledge_areas_array = [];
    foreach( $knowledge_areas as $term ){
      $meta_knowledge_areas_array[] = $term->name;
    }
  }

  $search = [
    '{{meta}}',
    '{{title}}',
    '{{thumbnail}}',
    '{{permalink}}',
  ];
  $replace = [
    implode(', ', $meta_knowledge_areas_array ),
    get_the_title( $post->ID ),
    get_the_post_thumbnail_url( $post->ID, 'large' ),
    get_the_permalink( $post->ID ),
  ];
  $template = str_replace( $search, $replace, $template );
  return $template;
}
add_shortcode( 'kcloop', __NAMESPACE__ . '\\kc_loop' );