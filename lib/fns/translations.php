<?php

namespace NetmindSiteMods\translations;

function translations( $translated, $original, $domain ){
  if( ! 'es_ES' == NETMIND_LOCALE )
    return;

  switch ( $original ) {
    case 'Title':
      if( 'andalu_woo_courses' == $domain )
        $translated = 'Cargo';
      break;

    default:
      // nothing
      break;
  }

  return $translated;
}
add_filter( 'gettext', __NAMESPACE__ . '\\translations', 9999, 3 );