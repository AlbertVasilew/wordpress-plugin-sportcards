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
        $materials_table = $wpdb->prefix . "sportcards_materials";
        $sizes_table = $wpdb->prefix . "sportcards_sizes";
        $prices_table = $wpdb->prefix . "sportcards_prices";

        if ($wpdb->get_var("SHOW TABLES LIKE '$clubs_table'") != $clubs_table) {
            dbDelta("CREATE TABLE $clubs_table (
                Id INT NOT NULL AUTO_INCREMENT,
                Name VARCHAR(50) NOT NULL,
                Image VARCHAR(500) NOT NULL,
                PRIMARY KEY (Id)
            ) $charset_collate;");
        }

        if ($wpdb->get_var("SHOW TABLES LIKE '$cards_table'") != $cards_table) {
            dbDelta("CREATE TABLE $cards_table (
                Id INT NOT NULL AUTO_INCREMENT,
                Image VARCHAR(500) NOT NULL,
                PRIMARY KEY (Id)
            ) $charset_collate;");
        }

        if ($wpdb->get_var("SHOW TABLES LIKE '$materials_table'") != $materials_table) {
            dbDelta("CREATE TABLE $materials_table (
                Id INT NOT NULL AUTO_INCREMENT, 
                Text VARCHAR(50) NOT NULL,
                PRIMARY KEY (Id)
            ) $charset_collate;");
        }

        if ($wpdb->get_var("SHOW TABLES LIKE '$sizes_table'") != $sizes_table) {
            dbDelta("CREATE TABLE $sizes_table (
                Id INT NOT NULL AUTO_INCREMENT,
                Text VARCHAR(50) NOT NULL,
                Proportion VARCHAR(50) NOT NULL,
                PRIMARY KEY (Id)
            ) $charset_collate;");
        }

        if ($wpdb->get_var("SHOW TABLES LIKE '$prices_table'") != $prices_table) {
            dbDelta("CREATE TABLE $prices_table (
                Id INT NOT NULL AUTO_INCREMENT, 
                Material_Id INT NOT NULL,
                Size_Id INT NOT NULL,
                Price INT NOT NULL,
                PRIMARY KEY (Id),
                UNIQUE KEY unique_size_material (Size_Id, Material_Id),
                FOREIGN KEY (Material_Id) REFERENCES wp_sportcards_materials(Id),
                FOREIGN KEY (Size_Id) REFERENCES wp_sportcards_sizes(Id)
            ) $charset_collate;");
        }
    }

    function create_directories() {
        $assets_dir = plugin_dir_path( __FILE__ ) . 'assets';

        $directories = array(
            $assets_dir,
            $assets_dir . '/clubs',
            $assets_dir . '/cards',
            $assets_dir . '/player-images',
            $assets_dir . '/customized-cards',
            $assets_dir . '/custom-clubs-logos'
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