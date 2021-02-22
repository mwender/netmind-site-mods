<?php

/**
 * Returns an HTML alert message
 *
 * @param      array  $atts {
 *   @type  string  $type         The alert type (defaults to `warning`).
 *   @type  string  $title        The title of the alert.
 *   @type  string  $description  The content of the alert.
 * }
 *
 * @return     html  The alert.
 */
function netmind_get_alert( $atts ){
  $args = shortcode_atts([
   'type'         => 'warning',
   'title'        => 'Alert Title Goes Here',
   'description'  => 'Alert description goes here.',
  ], $atts );

  $html = \NetmindSiteMods\handlebars\render_template( 'alert', $args );
  return $html;
}
