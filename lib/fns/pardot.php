<?php

namespace NetmindSiteMods\pardot;

/**
 * Adds form fields to the `body` of the form submission.
 *
 * @param      array  $args     Arguments passed from the filter.
 * @param      array  $record   The form submission.
 *
 * @return     array  The filtered arguments.
 */
function pardot_form_filter( $args, $record ){

  // Check form name to see if we should process it:
  $form_name = $record->get_form_settings( 'form_name' );
  $process_form = false;
  $strings_to_check = [ 'pardot', 'newsletter', 'onsite' ];
  foreach( $strings_to_check as $string ){
    if( stristr( strtolower( $form_name ), $string ) )
      $process_form = true;
  }
  if( ! $process_form )
    return $args;

	$raw_fields = $record->get( 'fields' );
	$fields = [];
	foreach ( $raw_fields as $id => $field ) {
		$fields[ $id ] = $field['value'];
  }
  $args['body'] = $fields;

  return $args;
}
add_filter( 'elementor_pro/forms/webhooks/request_args', __NAMESPACE__ . '\\pardot_form_filter', 10, 2 );

/**
 * Adds Pardot tracking to pages.
 */
function pardot_script(){
  $locale = get_locale();

  switch ($locale) {
    case 'es_ES':
      ?>
<script type='text/javascript'>
 piAId = '914921';
 piCId = '';
 piHostname = 'es.netmind.net';

(function() {
 function async_load(){
 var s = document.createElement('script'); s.type = 'text/javascript';
 s.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + piHostname + '/pd.js';
 var c = document.getElementsByTagName('script')[0]; c.parentNode.insertBefore(s, c);
 }
 if(window.attachEvent) { window.attachEvent('onload', async_load); }
 else { window.addEventListener('load', async_load, false); }
 })();
 </script>
      <?php
      break;

    default:
      ?>
<script type='text/javascript'>
 piAId = '914921';
 piCId = '';
 piHostname = 'en.netmind.net';

(function() {
 function async_load(){
 var s = document.createElement('script'); s.type = 'text/javascript';
 s.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + piHostname + '/pd.js';
 var c = document.getElementsByTagName('script')[0]; c.parentNode.insertBefore(s, c);
 }
 if(window.attachEvent) { window.attachEvent('onload', async_load); }
 else { window.addEventListener('load', async_load, false); }
 })();
 </script>
      <?php
      break;
  }
}
add_action( 'wp_footer', __NAMESPACE__ . '\\pardot_script', 999 );
