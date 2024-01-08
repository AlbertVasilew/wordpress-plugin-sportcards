<?php
    add_action ('wp_ajax_add_to_cart', 'add_to_cart') ;
    add_action ('wp_ajax_nopriv_add_to_cart', 'add_to_cart') ;
    add_action('wp_ajax_save_club', 'save_club_callback');
    add_action( 'woocommerce_checkout_create_order_line_item', 'save_cart_item_custom_meta_as_order_item_meta', 10, 4 );
    add_filter( 'woocommerce_get_item_data', 'display_cart_item_custom_meta_data', 10, 2 );
    add_action('admin_menu', 'your_plugin_add_menu');
    add_filter('plugin_action_links_sportcards/sportcards.php', 'plugin_settings_link');
    register_activation_hook(__FILE__, 'sportcards_activate');

    include plugin_dir_path(__FILE__) . 'settings-page.php';

    function plugin_settings_link($links) {
        $settings_link = '<a href="admin.php?page=sportcards-settings">Settings</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    function your_plugin_add_menu() {
        add_submenu_page(null, null, null, 'manage_options', 'sportcards-settings', 'your_plugin_settings_page');
    }

    function display_cart_item_custom_meta_data( $item_data, $cart_item ) {
        if ( isset($cart_item['card_data']) && is_array($cart_item['card_data']) ) {
            foreach ($cart_item['card_data'] as $key => $value) {
                $item_data[] = array(
                    'key'   => $key,
                    'value' => $value,
                );
            }
        }

        return $item_data;
    }

    function save_cart_item_custom_meta_as_order_item_meta( $item, $cart_item_key, $values, $order ) {
        if ( isset($values['card_data']) && is_array($values['card_data']) ) {
            foreach ($values['card_data'] as $key => $value) {
                $item->update_meta_data( $key, $value );
            }
        }
    }

    function add_to_cart ()
    {
        $image_data = $_POST['imageData'];
            
        $image_data = str_replace('data:image/png;base64,', '', $image_data);
        $image_data = str_replace(' ', '+', $image_data);
        $image_data = base64_decode($image_data);

        $file_path = plugin_dir_path(__FILE__) . 'assets/user-players/user_image_' . uniqid() . '.png';
        file_put_contents($file_path, $image_data);

        $card_data1 = $_POST["card_data"];

        $cart_item_key = WC()->cart->add_to_cart(14, 1, 0, array(), array('card_data' => array(
            'Материал' => $card_data1['material'],
            'Позиция' => $card_data1['position'],
            'Снимка' => $file_path
        )));

        wp_send_json(array('redirect_url' => wc_get_cart_url()));
        exit;
    }

    function sportcards_activate() {
        if (!get_option('sportcards_plugin_version')) {
            sportcards_create_table();
            update_option('sportcards_plugin_version', '1.0');
        }
    }

    function sportcards_create_table() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'sportcards_clubs';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            Id INT(11) NOT NULL AUTO_INCREMENT,
            Name VARCHAR(255) NOT NULL,
            Image VARCHAR(255) NOT NULL,
            PRIMARY KEY (Id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    function save_club_callback() {
        global $wpdb;
    
        $table_name = $wpdb->prefix . 'sportcards_clubs';
    
        $club_name = sanitize_text_field($_POST['clubName']);

        $uploaded_image = $_FILES['clubImage'];
        $file_name = uniqid() . '_' . basename($uploaded_image['name']);
        $dest_path = plugin_dir_path(__FILE__) . 'assets/clubs/' . $file_name;
    
        if (move_uploaded_file($uploaded_image['tmp_name'], $dest_path)) {
            $image_url = plugins_url('assets/clubs/' . $file_name, __FILE__);
    
            $wpdb->insert(
                $table_name,
                array(
                    'Name'  => $club_name,
                    'Image' => $image_url,
                ),
                array('%s', '%s')
            );
        }

        die();
    }
?>