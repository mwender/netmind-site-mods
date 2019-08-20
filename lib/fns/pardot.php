<?php

namespace NetmindSiteMods\pardot;

function pardot_form_filter( $args, $record ){
  $form_name = $record->get_form_settings( 'form_name' );
  if( ! stristr( strtolower( $form_name ), 'pardot' ) )
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
