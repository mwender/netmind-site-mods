<?php

namespace NetmindSiteMods\netmindtext;

/**
 * Returns the specified text string.
 *
 * We use this shortcode for situations where we need to insert
 * special text strings inside the WordPress text editor. Our
 * original use-case was for inserting a link to the
 * Cookiebot cookie dialog. This link required JavaScript to be
 * added to the `href` attribute of the link, and since
 * WordPress filters out JavaScript in the text editor, we
 * created this shortcode to get around that limitation.
 *
 * @param      array  $atts {
 *     Optional. An array of attributes.
 *
 *     @type string  $string A string for selecting the text string displayed. Default null.
 *     @type string  $lang   The language of the returned text string. Default en.
 * }
 *
 * @return     string  The text string.
 */
function netmind_text( $atts ){
  $args = shortcode_atts([
    'string' => null,
    'lang'   => 'en',
  ], $atts );

  switch( $args['string'] ){
    case 'cookie-policy':
      $cookie_policy = [
        'en'  => 'Cookie Policy',
        'es'  => 'Política de Cookies',
      ];
      $string = '<a style="font-weight: bold;" href="javascript: Cookiebot.renew();">' . $cookie_policy[ $args['lang'] ] . '</a>';
      break;

    default:
      $string = '<code>No string defined for `' . $args['string'] . '`.</code>';
  }

  return $string;
}
add_action( 'netmind_text', __NAMESPACE__ . '\\netmind_text' );