<?php

namespace NetmindSiteMods\relatedposts;

/**
 * Gets the post html.
 *
 * @param      array   $data   The data
 *
 * @return     string  The post html.
 */
function get_post_html( $data = [] ){
  $template = netmind_get_template( 'list-item' );

  if( empty( $data ) )
    return '<p>NO DATA!</p>';

  $html[] = '<div class="related-posts">';
  foreach( $data as $item ){

    $listItem = str_replace([
      '{resource_type}',
      '{resource_type_lc}',
      '{title}',
      '{meta}',
      '{permalink}',
      '{thumbnail}'
    ], [
      $item['terms']['resource_type'],
      strtolower( $item['terms']['resource_type'] ),
      $item['title'],
      $item['terms']['knowledge_area'],
      $item['permalink'],
      $item['thumbnail'],
    ], $template );

    $html[] = $listItem;
  }
  $html[] = '</div>';
  if( \Elementor\Plugin::$instance->editor->is_edit_mode() ){
    $relatedposts_js = file_get_contents( plugin_dir_path( __FILE__ ) . '../js/relatedposts.js' );
    $html[] = '<script type="text/javascript">' . $relatedposts_js . '</script>';
  }

  return implode( '', $html );
}

/**
 * Callback for the [netmind_related_posts /] shortcode.
 *
 * @param      array  $atts   {
 *     Optional. An array of arguments.
 *
 *     @type int $numberposts Number of posts to display. Default 30.
 *     @type str $orderby     The field to order the results by. Default 'date'.
 *     @type str $order       ASC or DESC. Default DESC.
 *     @type str $filter      Comma separated list of taxonomies used to filter
 *                            the results. Used on a single post view, these
 *                            will filter the results by taxonomy terms of the
 *                            current post. Default: null.
 * }
 *
 * @return     string  HTML for the Related Posts display.
 */
function related_posts( $atts ){
  $args = shortcode_atts([
    'numberposts' => 30,
    'orderby'     => 'date',
    'order'       => 'DESC',
    'filter'      => null,
  ], $atts );

  $alert = \netmind_get_alert([
    'type' => 'info',
    'title' => '`netmind_related_posts` shortcode',
    'description' => 'The <code>netmind_related_posts</code> shortcode will be output here.'
  ]);

  $query_args = [
    'numberposts' => $args['numberposts'],
  ];

  if( ! is_null( $args['filter'] ) && is_single() ){
    global $post;
    $filters = ( stristr( $args['filter'], ',' ) )? explode( ',', $args['filter'] ) : [ $args['filter'] ];
    foreach ($filters as $taxonomy ) {
      $terms = get_the_terms( $post->ID, $taxonomy );
      $term_ids = array_column( $terms, 'term_id' );
      $query_args['tax_query'][] = [ 'taxonomy' => $taxonomy, 'terms' => implode(',', $term_ids ) ];
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
  }

  wp_enqueue_style( 'relatedposts' );
  wp_enqueue_script( 'relatedposts' );
  $html = get_post_html( $data );

  return $html;
}
add_shortcode( 'netmind_related_posts', __NAMESPACE__ . '\\related_posts' );