<?php
    include_once(plugin_dir_path(__FILE__) . 'admin/settings-page-setup.php');
    include_once(plugin_dir_path(__FILE__) . 'prepare-order.php');

    add_action('wp_ajax_generate_user_sportcard', 'generate_user_sportcard');
    add_action('wp_ajax_nopriv_generate_user_sportcard', 'generate_user_sportcard');
    add_action('wp_ajax_save_club', 'save_club');
    add_action('wp_ajax_save_card', 'save_card');
    add_action('wp_ajax_delete_club', 'delete_club');
    add_action('wp_ajax_delete_card', 'delete_card');
    add_action('wp_ajax_update_prices', 'update_prices');
    add_action('wp_ajax_upload_custom_club_logo', 'upload_custom_club_logo');
    add_action('wp_enqueue_scripts', 'enqueue_scripts');
    add_action('admin_enqueue_scripts', 'enqueue_scripts_admin');
    
    add_action('woocommerce_checkout_create_order_line_item', 'add_sportcard_data_in_order', 10, 4);
    add_filter('woocommerce_get_item_data', 'add_sportcard_data_in_cart', 10, 2);
    add_action('woocommerce_before_calculate_totals', 'set_sportcard_price');
    add_filter('woocommerce_cart_item_thumbnail', 'custom_card_design_as_thumbnail', 10, 3);
    add_action( 'woocommerce_before_mini_cart_contents',  'recalculateMiniCartOnAjaxRefresh' );

    add_action('admin_menu', 'add_sportcards_settings_menu');
    add_filter('plugin_action_links_sportcards/sportcards.php', 'sportcards_settings_link');
?>