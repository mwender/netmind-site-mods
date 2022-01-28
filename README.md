# Netmind Site Mods #
**Contributors:** [TheWebist](https://profiles.wordpress.org/TheWebist)  
**Tags:** elementor  
**Requires at least:** 4.5  
**Tested up to:** 5.7  
**Stable tag:** 1.3.9  
**License:** GPLv2 or later  
**License URI:** https://www.gnu.org/licenses/gpl-2.0.html  

This plugin provides upgrade tolerant modifications to the Netmind Elementor-powered website.

# "Instructors" Shortcode

Display a listing of Netmind Instructor CPTs.

Usage: `[netmind_instructors taxonomy="best_practice" term="safe" /]`

```
/**
 * Displays a listing of Netmind Instructor CPTs.
 *
 * When using the taxonomy and term parameters with multiple
 * taxonomies and terms, you must specify your taxonomies
 * and terms in the same order within the attribute so that
 * the corresponding taxonomies and terms will be used with
 * one another in the query. Additional, due to this
 * constraint, you may only use one term per taxonomy.
 *
 * @param      array  $atts   {
 *     Optional. An array of arguments.
 *
 *     @type int $columns     Currently not working due to Elementor CSS class
 *                            names in the underlying Handlebars template. Default 4.
 *     @type int $numberposts Limit the number of Instructors displayed. Default -1 (display all).
 *     @type str $orderby     Accepts any standard `orderby` parameters. Additionally accepts
 *                            `lastname` to order by the "Last Name" meta field.
 *     @type str $order       Can be `ASC` or `DESC`. Default ASC.
 *     @type str $taxonomy    Comma separated list of taxonomies to query by. Example
 *                            "best_practice". Default null.
 *     @type str $term        Comma separated list of terms to use with the taxonomy attribute.
 *                            Default null.
 * }
 *
 * @return     string  ( description_of_the_return_value )
 */
 ```

# "Netmind Text" Shortcode

Display the specified text string.

Useage: `[netmind_text string="cookie-policy" lang="es"]`

```
/**
 * Returns the specified text string.
 *
 * We use this shortcode for situations where we need to insert
 * special text strings inside the WordPress text editor. Our
 * original use-case was for inserting a link to the
 * Cookiebot cookie dialog. This link required JavaScript to be
 * added to the `href` attribute of the link, and since
 * WordPress filters out JavaScript in the text editor, we
 * created this shortcode to get around that limitation.
 *
 * @param      array  $atts {
 *     Optional. An array of attributes.
 *
 *     @type string  $string A string for selecting the text string displayed. Default null.
 *     @type string  $lang   The language of the returned text string. Default en.
 * }
 *
 * @return     string  The text string.
 */
```

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
 *     @type str $post_type   The WordPress `post_type`. Default `post`.
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

### 1.3.9 ###
* Updating `pardot_form_filter()` form name check.

### 1.3.8 ###
* Updating `pardot_form_filter()` to allow for forms which have "newsletter" in their name.

### 1.3.7 ###
* Enqueuing `slick.css`.

### 1.3.6 ###
* Applying translation of "Title" to "Cargo" only to `es_ES` locale.

### 1.3.5 ###
* Hide dots responsive `js/relatedposts.js`

### 1.3.4 ###
* Add responsive from slider `js/relatedposts.js`

### 1.3.3 ###
* Adding `lib/fns/translations.php` for translation related functions.
* Translating "Title" to "Cargo" in Andalu Woo Courses plugin.

### 1.3.2 ###
* Updating Pardot code.

### 1.3.1 ###
* Bugfix: Hooking `[netmind_text]` shortcode via `add_shortcode()` rather than `add_action()`.

### 1.3.0 ###
* Adding `[netmind_text]` shortcode for adding text strings to the WordPress editor.

### 1.2.5 ###
* Adjusting `:focus` outline style to `thin dotted` for `[netmind_related_posts]` `div.list-item` elements.

### 1.2.4 ###
* Setting `justify-content: center;` for Netmind Instructor rows.

### 1.2.3 ###
* Updating "Netminder Interviews" and "Events" icons to match the icons we're using in the ShuffleJS Post Filter plugin.

### 1.2.2 ###
* Compiling CSS for production.

### 1.2.1 ###
* Updating `[netmind_related_posts/]` to handle "News" posts.

### 1.2.0 ###
* Adding `[netmind_instructors/]` shortcode.
* Converting template handling to Handlebars.
* Adding `post_type` attribute to `[netmind_related_posts/]`.

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
