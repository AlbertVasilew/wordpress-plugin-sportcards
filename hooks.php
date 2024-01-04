<?php
    add_action ('wp_ajax_add_to_cart', 'add_to_cart') ;
    add_action ('wp_ajax_nopriv_add_to_cart', 'add_to_cart') ;
    add_action( 'woocommerce_checkout_create_order_line_item', 'save_cart_item_custom_meta_as_order_item_meta', 10, 4 );
    add_filter( 'woocommerce_get_item_data', 'display_cart_item_custom_meta_data', 10, 2 );
?>