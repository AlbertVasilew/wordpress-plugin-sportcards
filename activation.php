<?php
    function sportcards_activate() {
        create_tables();
        create_directories();
        create_system_product();
    }
    
    function create_tables() {
        global $wpdb;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        $charset_collate = $wpdb->get_charset_collate();
        $clubs_table = $wpdb->prefix . "sportcards_clubs";
        $cards_table = $wpdb->prefix . "sportcards_cards";

        if ($wpdb->get_var("SHOW TABLES LIKE '$clubs_table'") != $clubs_table) {
            dbDelta("CREATE TABLE $clubs_table (
                Id INT(11) NOT NULL AUTO_INCREMENT,
                Name VARCHAR(255) NOT NULL,
                Image VARCHAR(255) NOT NULL,
                PRIMARY KEY (Id)
            ) $charset_collate;");
        }

        if ($wpdb->get_var("SHOW TABLES LIKE '$cards_table'") != $cards_table) {
            dbDelta("CREATE TABLE $cards_table (
                Id INT(11) NOT NULL AUTO_INCREMENT,
                Image VARCHAR(255) NOT NULL,
                PRIMARY KEY (Id)
            ) $charset_collate;");
        }
    }

    function create_directories() {
        $assets_dir = plugin_dir_path( __FILE__ ) . 'assets';

        $directories = array(
            $assets_dir,
            $assets_dir . '/clubs',
            $assets_dir . '/cards',
            $assets_dir . '/player-images'
        );
        
        foreach ($directories as $directory) {
            if (!file_exists($directory))
                wp_mkdir_p($directory);
        }
    }

    function create_system_product() {
        global $wpdb;
        
        $product_sku = 'sportcards-customizer-system-product';
        $existing_product = $wpdb->get_var(
            "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='$product_sku'");

        if (!$existing_product) {
            $product_id = wp_insert_post(array(
                'post_title' => 'Персонализирана карта', 'post_status' => 'publish', 'post_type' => 'product'));

            wp_set_object_terms($product_id, 'simple', 'product_type');
            update_post_meta($product_id, '_sku', $product_sku);
            update_post_meta($product_id, '_visibility', 'hidden');
            update_post_meta($product_id, '_price', '0');
            update_post_meta($product_id, '_regular_price', '0');
        }
    }
?>