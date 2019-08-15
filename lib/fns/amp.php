<?php

namespace NetmindSiteMods\amp;

/**
 * Prevents an empty 'srcset' attribute from appearing.
 *
 * This fixes the AMP error "Missing URL for attribute `srcset`
 * in tag `amp-img`" by not adding the `srcset` when that
 * attribute is empty.
 *
 * @param array  $attributes Image attributes.
 * @return array $attributes Filtered image attributes.
 */
add_filter( 'wp_get_attachment_image_attributes', function( $attributes ) {
  if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() && empty( $attributes['srcset'] ) ) {
    unset( $attributes['srcset'] );
  }
  return $attributes;
} );