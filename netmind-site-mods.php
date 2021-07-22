<?php
/**
 * Plugin Name:     Netmind Site Mods
 * Description:     Miscellaneous site mods to the Netmind site. Instead of adding code to the site's theme functions.php, we're adding it here since our theme isn't under version control. Mods stored here include mods to amp, autoptimize, woocommerce, etc.
 * Author:          Michael Wender
 * Author URI:      https://mwender.com
 * Text Domain:     netmind-site-mods
 * Domain Path:     /languages
 * Version:         1.3.6
 * GitHub Plugin URI: mwender/netmind-site-mods
 * GitHub Plugin URI: https://github.com/mwender/netmind-site-mods
 *
 * @package         Netmind_Site_Mods
 */
define( 'NETMIND_SITE_MOD_DIR', dirname( __FILE__ ) );
define( 'NETMIND_DEV_ENV', stristr( site_url(), '.local' ) );
define( 'NETMIND_CSS_DIR', ( NETMIND_DEV_ENV )? 'css' : 'dist' );
define( 'NETMIND_LOCALE', get_locale() );

// Load Composer dependencies
require_once('vendor/autoload.php');

// Your code starts here.
require_once( 'lib/fns/admin.php' );
require_once( 'lib/fns/amp.php' );
require_once( 'lib/fns/autoptimize.php' );
require_once( 'lib/fns/elementor.php' );
require_once( 'lib/fns/enqueues.php' );
require_once( 'lib/fns/handlebars.php' );
require_once( 'lib/fns/pardot.php' );
require_once( 'lib/fns/utilities.php' );
require_once( 'lib/fns/shortcode.netmind-instructors.php' );
require_once( 'lib/fns/shortcode.netmind-related-posts.php' );
require_once( 'lib/fns/shortcode.netmind-text.php' );
require_once( 'lib/fns/translations.php' );
require_once( 'lib/fns/woocommerce.php' );


/**
 * Enhanced logging.
 *
 * @param      string  $message  The log message
 */
if( ! function_exists( 'uber_log') ){
  function uber_log( $message = null ){
    static $counter = 1;

    $bt = debug_backtrace();
    $caller = array_shift( $bt );

    if( 1 == $counter )
      error_log( "\n\n" . str_repeat('-', 25 ) . ' STARTING DEBUG [' . date('h:i:sa', current_time('timestamp') ) . '] ' . str_repeat('-', 25 ) . "\n\n" );
    error_log( "\n" . $counter . '. ' . basename( $caller['file'] ) . '::' . $caller['line'] . "\n" . $message . "\n---\n" );
    $counter++;
  }
}