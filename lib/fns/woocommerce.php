<?php

namespace NetmindSiteMods\woocommerce;

/**
 * Remove breadcrumbs
 */
//remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

/**
 * Removes `order-date` column from My Account > Orders table
 *
 * @param      array  $columns  The columns
 *
 * @return     array  Filtered columns.
 */
function filter_account_orders_columns( $columns ){
    $columns = array_slice( $columns, 0, 1 ) + ['order-items' => __( 'Order/Items', 'woocommerce')] + array_slice( $columns, 1, count( $columns ) - 1, true );
    unset( $columns['order-number'], $columns['order-date'] );
    return $columns;
}
add_filter( 'woocommerce_account_orders_columns', __NAMESPACE__ . '\\filter_account_orders_columns' );

/**
 * Rebuilds the WooCommerce Product Category display on the
 * main shop page. It works by discarding the original
 * content and rebuilding it from scratch
 *
 * @param      <string>  $content  The content
 *
 * @return     string  Rebuilt WooCommerce Product Category list
 */
function filter_product_loop_start( $content ){
  if( ! is_shop() )
    return $content;

  $term = get_term_by( 'slug', 'uncategorized', 'product_cat' );

  $terms = get_terms([
    'taxonomy'=>'product_cat',
    'parent' => 0,
    'exclude' => $term->term_id,
  ]);
    $col = 1;
    foreach ($terms as $term) {
        $classes = [];
        if( 1 === $col )
          $classes[] = 'first';
        if( 4 === $col )
          $classes[] = 'last';


        $thumbnail_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
        $image = wp_get_attachment_url( $thumbnail_id );
        $html.= '<li class="product-category product ' . implode( ' ', $classes ) . '"><a href="' . get_term_link( $term ) . '"><img src="' . $image . '" alt="' . esc_attr( $term->name ) . '" /><h2 class="woocommerce-loop-category__title">'.$term->name.'</h2></a></li>';

        if( 4 === $col ){
          $col = 1;
        } else {
          $col++;
        }
    }
    return '<ul class="products columns-4">'.$html.'</ul>';
}
//add_filter( 'woocommerce_product_loop_start', __NAMESPACE__ . '\\filter_product_loop_start' );

/**
 * Content for the order-items column.
 *
 * @param      <type>  $order  The order
 */
function order_items_column( $order ){
?>
    <a href="<?php echo esc_url( $order->get_view_order_url() ); ?>">
        <?php echo _x( '#', 'hash before order number', 'woocommerce' ) . $order->get_order_number(); ?>
    </a> &ndash;
    <time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><?php echo esc_html( date( 'M j, Y', strtotime( $order->get_date_created() ) ) ); ?></time>
<?php
    $items = $order->get_items();
    foreach( $items as $item ){
        $items_array[] = $item['name'] . ' x ' . $item['qty'];
    }
    echo '<ul><li>' . implode( '</li><li>', $items_array ) . '</li></ul>';
}
add_action( 'woocommerce_my_account_my_orders_column_order-items', __NAMESPACE__ . '\\order_items_column' );

/**
 * Filters titles for product tabs
 *
 * @param      string  $title  The title
 * @param      string  $key    The key
 *
 * @return     string  Filtered title
 */
function filter_tab_titles( $title, $key ){
    switch ( $key ) {
        case 'reviews':
            $title = 'Reviews';
            break;
    }

    return $title;
}
add_filter( 'woocommerce_product_reviews_tab_title', __NAMESPACE__ . '\\filter_tab_titles', 15, 2 );


function hide_category_count() {
    // No count
    // Ref: https://docs.woocommerce.com/document/hide-sub-category-product-count-in-product-archives/
}
add_filter( 'woocommerce_subcategory_count_html', __NAMESPACE__ . '\\hide_category_count' );

/**
 * Adds a Register form note.
 */
function add_register_form_note(){
    echo '<p><strong>Important:</strong> If you are creating an account, please note:</p><ul style="line-height: 1.25rem; margin: 1rem 0; padding-bottom: 0;"><li>The email address you enter above must match the email address we have on file with your certification records.</li></ul><p>If you create your account and find that your certification records are not published (classes/exams, badge and certification status), please <a href="mailto:certification@b2ttraining.com">email us</a> to update your primary email address to match your certification record associated address.</p>';
}
add_action( 'woocommerce_register_form', __NAMESPACE__ . '\\add_register_form_note' );

/**
 * Reverses the order of reviews on WC Product pages.
 *
 * @param      array  $args{
 *      @type   bool    $reverse_top_level  Set to TRUE to show reviews in DESC chronological order.
 * }
 *
 * @return     array  Arguments for the product review list.
 */
function reverse_review_order( $args ){
    $args['reverse_top_level'] = true;
    return $args;
}
add_filter( 'woocommerce_product_review_list_args', __NAMESPACE__ . '\\reverse_review_order', 999 );
