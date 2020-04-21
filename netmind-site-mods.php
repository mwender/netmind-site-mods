<?php
/**
 * Plugin Name:     Netmind Site Mods
 * Description:     Miscellaneous site mods to the Netmind site. Instead of adding code to the site's theme functions.php, we're adding it here since our theme isn't under version control. Mods stored here include mods to amp, autoptimize, woocommerce, etc.
 * Author:          Michael Wender
 * Author URI:      https://mwender.com
 * Text Domain:     netmind-site-mods
 * Domain Path:     /languages
 * Version:         0.2.0
 * GitHub Plugin URI: mwender/netmind-site-mods
 * GitHub Plugin URI: https://github.com/mwender/netmind-site-mods
 *
 * @package         Netmind_Site_Mods
 */

// Your code starts here.
require_once( 'lib/fns/admin.php' );
require_once( 'lib/fns/amp.php' );
require_once( 'lib/fns/autoptimize.php');
require_once( 'lib/fns/elementor.php' );
require_once( 'lib/fns/pardot.php' );
require_once( 'lib/fns/woocommerce.php' );
