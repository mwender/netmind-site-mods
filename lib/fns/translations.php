<?php

namespace NetmindSiteMods\translations;

function translations( $translated, $original, $domain ){
  switch ( $original ) {
    case 'Title':
      if( 'es_ES' == NETMIND_LOCALE && 'andalu_woo_courses' == $domain )
        $translated = 'Cargo';
      break;

    default:
      // nothing
      break;
  }

  return $translated;
}
add_filter( 'gettext', __NAMESPACE__ . '\\translations', 9999, 3 );