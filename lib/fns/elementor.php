<?php

namespace NetmindSiteMods\elementor;

/**
 * Custom `Related Posts` query for `knowledge_area` taxonomy.
 *
 * @param      object  $query  The query
 *
 * @return     object  Modified query.
 */
function knowledge_area_related_posts_query( $query ) {
  global $post;

  $terms = wp_get_post_terms( $post->ID, 'knowledge_area' );
  if( ! $terms )
    return $query;

  $term_id = $terms[0]->term_id;

  $args['tax_query'] = [
    [
      'taxonomy' => 'knowledge_area',
      'field' => 'term_id',
      'terms' => $term_id,
    ]
  ];
  $args['post__not_id'] = [$post->ID];

  $query->set('tax_query', $args['tax_query'] );
  $query->set('post__not_id', $args['post__not_id']);
};
add_action( 'elementor/query/knowledge_area_related_posts', __NAMESPACE__ . '\\knowledge_area_related_posts_query' );

/**
 * Gets related posts for a resource_type query
 *
 * @param      object  $query  The query
 *
 * @return     object  Modified query.
 */
function resource_type_related_posts_query( $query ) {
  global $post;

  $terms = wp_get_post_terms( $post->ID, 'resource_type' );
  if( ! $terms )
    return $query;

  $term_id = $terms[0]->term_id;

  $args['tax_query'] = [
    [
      'taxonomy' => 'resource_type',
      'field' => 'term_id',
      'terms' => $term_id,
    ]
  ];

  $query->set('post__not_in', [$post->ID] );
  $query->set('tax_query', $args['tax_query'] );
}
add_action( 'elementor/query/resource_type_related_posts', __NAMESPACE__ . '\\resource_type_related_posts_query' );