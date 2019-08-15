<?php

namespace NetmindSiteMods\admin;

function admin_init(){
  global $pagenow;

  /**
   * Add a "Developer's site' link under the plugin description.
   */
  if ( 'plugins.php' == $pagenow ) {
    add_filter( 'plugin_row_meta', __NAMESPACE__ . '\\plugin_row_meta', 10, 2 );
  }

}
add_action( 'admin_init', __NAMESPACE__ . '\\admin_init' );

/**
 * Filter hook to add a new link under the plugin description.
 *
 * @param array $plugin_meta List of HTML links.
 * @param string $plugin_file slug for the plugin
 * @return array Filtered HTML links for the plugin page for this plugin.
 *
 * @since 1.0.0
 */
function plugin_row_meta( $plugin_meta, $plugin_file ) {
  if ( false !== strpos( $plugin_file, '/netmind-site-mods.php' ) ) {
    $link_text     = __( "Visit developer's site", 'netmindsitemods' );
    $plugin_meta[] = "<a href=\"https://mwender.com/about\" target=\"_blank\">{$link_text}</a>";
  }
  return $plugin_meta;
}