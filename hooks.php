<?php
    include_once(plugin_dir_path(__FILE__) . 'settings-page/settings-page.php');
    include_once(plugin_dir_path(__FILE__) . 'prepare-order.php');

    add_action('wp_ajax_generate_user_sportcard', 'generate_user_sportcard');
    add_action('wp_ajax_nopriv_generate_user_sportcard', 'generate_user_sportcard');
    add_action('wp_ajax_save_club', 'save_club_callback');
    add_action('wp_enqueue_scripts', 'enqueue_scripts');
    
    add_action('woocommerce_checkout_create_order_line_item', 'add_sportcard_data_in_order', 10, 4);
    add_filter('woocommerce_get_item_data', 'add_sportcard_data_in_cart', 10, 2);
    add_action('woocommerce_before_calculate_totals', 'set_sportcard_price');

    add_action('admin_menu', 'your_plugin_add_menu');
    add_filter('plugin_action_links_sportcards/sportcards.php', 'plugin_settings_link');
?>