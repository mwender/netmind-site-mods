# Netmind Site Mods #
**Contributors:** [TheWebist](https://profiles.wordpress.org/TheWebist)  
**Tags:** elementor  
**Requires at least:** 4.5  
**Tested up to:** 5.6  
**Stable tag:** 1.1.3  
**License:** GPLv2 or later  
**License URI:** https://www.gnu.org/licenses/gpl-2.0.html  

This plugin provides upgrade tolerant modifications to the Netmind Elementor-powered website.

# "Related Posts" Shortcode

Display a listing of "related posts" in a Slick JS carousel.

Usage: `[netmind_related_posts numberposts="30" orderby="date" order="DESC" taxonomy="null" term="null"]`

```
/**
 * Callback for the [netmind_related_posts /] shortcode.
 *
 * @param      array  $atts   {
 *     Optional. An array of arguments.
 *
 *     @type int $numberposts Number of posts to display. Default 30.
 *     @type str $orderby     The field to order the results by. Default 'date'.
 *     @type str $order       ASC or DESC. Default DESC.
 *     @type str $taxonomy    Comma separated list of taxonomies used to filter
 *                            the results. Used on a single post view, these
 *                            will filter the results by taxonomy terms of the
 *                            current post. Default: null.
 *     @type str $term        Comma separated list of terms to filter the results.
 *                            Must be used with one, and only one, taxonomy.
 *                            Default: null.
 * }
 *
 * @return     string  HTML for the Related Posts display.
 */
```

# Various Mods

Miscellaneous modifications to other plugins and WP Core:

## Autoptimize Modifications

The code in `lib/fns/autoptimize.php` excludes specified pages from optimization.

## AMP Modifications

The code in `lib/fns/amp.php` prevents an empty 'srcset' attribute from appearing thereby preventing a common error when running an AMP page through a validation service.

## Changelog ##

### 1.1.3 ###
* Removing `outline-style` for Related Posts clickable area.
* Adding admin "Sample" rendering for `[netmind_related_posts]`.

### 1.1.2 ###
* Adding `term` attribute to `[netmind_related_posts]`.
* Renaming `filter` to `taxonomy` in `[netmind_related_posts]`.

### 1.1.1 ###
* BUGFIX: Checking for array inside `related_posts()`.

### 1.1.0 ###
* Adding `filter` attribute to `[netmind_related_posts]` shortcode.
* Adding `.ribbon` styling for Related Posts shortcode.
* Updating documentation.

### 1.0.0 ###
* Initial implementation of `[netmind_related_posts]`.

### 0.2.0 ###
* Adding [GitHub Updater](https://github.com/afragen/github-updater) integration.
* Merging code from "Mods for Elementor by Netmind" plugin.

### 0.1.0 ###
* Initial release.
