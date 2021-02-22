<?php

namespace NetmindSiteMods\relatedposts;

/**
 * Callback for the [netmind_related_posts /] shortcode.
 *
 * @param      array  $atts   {
 *     Optional. An array of arguments.
 *
 *     @type int $numberposts Number of posts to display. Default 30.
 *     @type str $orderby     The field to order the results by. Default 'date'.
 *     @type str $order       ASC or DESC. Default DESC.
 *     @type str $post_type   The WordPress `post_type`. Default `post`.
 *     @type str $taxonomy    Comma separated list of taxonomies used to filter
 *                            the results. Used on a single post view, these
 *                            will filter the results by taxonomy terms of the
 *                            current post. Default: null.
 *     @type str $term        Comma separated list of terms to filter the results.
 *                            Must be used with one, and only one, taxonomy.
 *                            Default: null.
 * }
 *
 * @return     string  HTML for the Related Posts display.
 */
function related_posts( $atts ){
  $args = shortcode_atts([
    'numberposts' => 30,
    'orderby'     => 'date',
    'order'       => 'DESC',
    'post_type'   => 'post',
    'taxonomy'    => null,
    'term'        => null,
  ], $atts );

  $edit_mode = ( strpos($_SERVER['REQUEST_URI'], 'elementor') !== false )? true : false ;

  $query_args = [
    'numberposts' => $args['numberposts'],
    'post_type'   => $args['post_type'],
  ];
  if( $edit_mode )
    $query_args['numberposts'] = 3;

  // If we have ONE taxonomy and term is set, we can select
  // related posts which have the same taxonomy term.
  if(
    ! is_null( $args['term'] ) &&
    ! is_null( $args['taxonomy'] )
  ){
    if( stristr( $args['taxonomy'], ',' ) ){
      return '<p>ERROR: When using the <code>term</code> attribute, you can not have multiple taxonomies. Either remove your <code>term(s)</code> to filter by multiple taxonomies, or set your <code>taxonomy</code> attribute to one taxonomy.</p>';
    }

    $term_ids = [];
    $terms = ( stristr( $args['term'], ',' ) )? explode( ',', $args['term'] ) : [ $args['term'] ];
    foreach( $terms as $slug ){
      $term = get_term_by( 'slug', $slug, $args['taxonomy'] );
      if( $term )
        $term_ids[] = $term->term_id;
    }
    $query_args['tax_query'][] = [ 'taxonomy' => $args['taxonomy'], 'terms' => implode(',', $term_ids ) ];
  } else if(
    is_null( $args['term'] ) &&
    ! is_null( $args['taxonomy'] ) &&
    is_single()
  ){
    global $post;
    $taxonomies = ( stristr( $args['taxonomy'], ',' ) )? explode( ',', $args['taxonomy'] ) : [ $args['taxonomy'] ];
    foreach ($taxonomies as $taxonomy ) {
      $terms = get_the_terms( $post->ID, $taxonomy );
      if( $terms ){
        $term_ids = array_column( $terms, 'term_id' );
        $query_args['tax_query'][] = [ 'taxonomy' => $taxonomy, 'terms' => implode(',', $term_ids ) ];
      }
    }
  }


  $posts = get_posts( $query_args );
  if( $posts ){
    $x = 0;
    foreach ( $posts as $post ) {
      $data[$x] = [
        'title'     => $post->post_title,
        'permalink' => get_the_permalink( $post->ID ),
        'date'      => $post->post_date,
        'thumbnail' => get_the_post_thumbnail_url( $post->ID, 'large' ),
      ];
      $taxonomies = ['knowledge_area','resource_type'];
      foreach( $taxonomies as $taxonomy ){
        $terms = get_the_terms( $post->ID, $taxonomy ); // wp_get_post_terms
        if( $terms ){
          $terms_array = [];
          foreach( $terms as $term ){
            $terms_array[] = $term->name;
          }
          $data[$x]['terms'][$taxonomy] = implode( ', ', $terms_array );
        }
      }
      $x++;
    } // foreach
    wp_reset_postdata(); // Restore $post global
  }

  $html = '';

  if( $edit_mode ){
    $css = file_get_contents( NETMIND_SITE_MOD_DIR . '/lib/css/relatedposts.css' );
    $html.= '<style>' . $css . '.list-item{width: 33%;padding: 0 8px;}.related-posts{display:flex;justify-content:space-between;}</style>';
  } else {
    wp_enqueue_style( 'relatedposts' );
    wp_enqueue_script( 'relatedposts' );
  }
  $html.= \NetmindSiteMods\handlebars\render_template( 'list-item', [ 'items' => $data ] );

  return $html;
}
add_shortcode( 'netmind_related_posts', __NAMESPACE__ . '\\related_posts' );