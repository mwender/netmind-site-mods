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

function pardot_script(){
?>
<script type="text/javascript">
/* Pardot Tracking */
piAId = '541272';
piCId = '12208';
piHostname = 'pi.pardot.com';

(function() {
    function async_load(){
        var s = document.createElement('script'); s.type = 'text/javascript';
        s.src = ('https:' == document.location.protocol ? 'https://pi' : 'http://cdn') + '.pardot.com/pd.js';
        var c = document.getElementsByTagName('script')[0]; c.parentNode.insertBefore(s, c);
    }
    if(window.attachEvent) { window.attachEvent('onload', async_load); }
    else { window.addEventListener('load', async_load, false); }
})();
</script>
<?php
}
add_action( 'wp_footer', __NAMESPACE__ . '\\pardot_script', 999 );
