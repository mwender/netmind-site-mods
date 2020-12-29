<?php

namespace NetmindSiteMods\relatedposts;

function related_posts( $atts ){
  $args = shortcode_atts([
    'numberposts' => 30,
    'orderby'     => 'date',
    'order'       => 'DESC',
  ], $atts );

  $alert = \netmind_get_alert([
    'type' => 'info',
    'title' => '`netmind_related_posts` shortcode',
    'description' => 'The <code>netmind_related_posts</code> shortcode will be output here.'
  ]);

  $query_args = [
    'numberposts' => $args['numberposts'],
  ];
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
        $terms = wp_get_post_terms( $post->ID, $taxonomy );
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

  $template = netmind_get_template( 'list-item' );

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
add_shortcode( 'netmind_related_posts', __NAMESPACE__ . '\\related_posts' );