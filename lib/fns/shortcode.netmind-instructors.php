<?php

namespace NetmindSiteMods\instructors;

/**
 * Displays a listing of Netmind Instructor CPTs.
 *
 * When using the taxonomy and term parameters with multiple
 * taxonomies and terms, you must specify your taxonomies
 * and terms in the same order within the attribute so that
 * the corresponding taxonomies and terms will be used with
 * one another in the query. Additional, due to this
 * constraint, you may only use one term per taxonomy.
 *
 * @param      array  $atts   {
 *     Optional. An array of arguments.
 *
 *     @type int $columns     Currently not working due to Elementor CSS class
 *                            names in the underlying Handlebars template. Default 4.
 *     @type int $numberposts Limit the number of Instructors displayed. Default -1 (display all).
 *     @type str $orderby     Accepts any standard `orderby` parameters. Additionally accepts
 *                            `lastname` to order by the "Last Name" meta field.
 *     @type str $order       Can be `ASC` or `DESC`. Default ASC.
 *     @type str $taxonomy    Comma separated list of taxonomies to query by. Example
 *                            "best_practice". Default null.
 *     @type str $term        Comma separated list of terms to use with the taxonomy attribute.
 *                            Default null.
 * }
 *
 * @return     string  ( description_of_the_return_value )
 */
function instructors( $atts ){
  $args = shortcode_atts([
    'columns'     => 4,
    'numberposts' => -1,
    'orderby'     => 'title',
    'order'       => 'ASC',
    'taxonomy'    => null,
    'term'        => null,
  ], $atts );

  $query_args = [
    'numberposts' => $args['numberposts'],
    'post_type'   => 'instructor',
    'order'       => $args['order'],
  ];
  if( $args['taxonomy'] ){
    $taxonomies = ( stristr( $args['taxonomy'], ',' ) )? explode( ',', $args['taxonomy'] ) : [ $args['taxonomy'] ] ;
    $terms = ( stristr( $args['term'], ',' ) )? explode( ',', $args['term'] ) : [ $args['term'] ] ;
    foreach( $taxonomies as $key => $taxonomy ){
      $query_args['tax_query'][] = [
        'taxonomy'  => $taxonomy,
        'field'     => 'slug',
        'terms'     => $terms[$key],
      ];
    }
  }

  if( 'title' == $args['orderby'] ){
    $query_args['orderby'] = $args['orderby'];
  } else if( 'lastname' == $args['orderby'] ){
    $query_args['meta_key'] = 'lastname';
    $query_args['orderby'] = 'meta_value';
  }

  $posts = get_posts( $query_args );

  $html = '';
  if( $posts ){
    $rows = [];
    $row = 1;
    $x = 1;
    $col = 1;
    foreach( $posts as $post ){
      $thumbnail_id = get_post_thumbnail_id( $post->ID );
      $instructor = [
        'name'      => $post->post_title,
        'thumbnail' => get_the_post_thumbnail_url( $post->ID, 'large' ),
        'srcset'    => wp_get_attachment_image_srcset( $thumbnail_id, 'large' ),
        'title'     => get_post_meta( $post->ID, 'title', true ),
      ];
      $rows[$row]['instructors'][$col] = $instructor;
      if( $col == $args['columns'] ){
        $col = 1;
        $row++;
      } else {
        $col++;
      }
    }
    $html = \NetmindSiteMods\handlebars\render_template( 'instructors', [ 'rows' => $rows ] );
  } else {
    $html = netmind_get_alert([
      'type'        => 'warning',
      'title'       => 'No Instructors Found',
      'description' => 'No instructors found when taxonomy="' . $args['taxonomy'] . '" and term="' . $args['term'] . '"',
    ]);
  }

  //uber_log('🔔 $rows = ' . print_r( $rows, true ) );

  wp_reset_postdata();
  return $html;
}
add_shortcode( 'netmind_instructors', __NAMESPACE__ . '\\instructors' );