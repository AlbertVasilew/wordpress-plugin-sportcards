<?php
    global $wpdb;
    $default_card_design = $wpdb->get_var("SELECT Image FROM {$wpdb->prefix}sportcards_cards LIMIT 1");
    $prices = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}sportcards_prices");

    function enqueue_scripts() {
        global $default_card_design;
        global $prices;

        $localization_data = array(
            'default_card' => $default_card_design,
            'cards' => plugins_url('/assets/cards/', __FILE__),
            'ajax_url' => admin_url('admin-ajax.php'),
            'currency' => get_woocommerce_currency_symbol(),
            'prices' => $prices 
        );

        wp_enqueue_style('sportcards-css', plugin_dir_url(__FILE__) . 'styles.css');
        wp_enqueue_style('cropper-css', 'https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css');

        wp_enqueue_script('player-card-js', plugin_dir_url(__FILE__) . 'scripts/player-card.js');
        wp_enqueue_script('cropper-manager-js', plugin_dir_url(__FILE__) . 'scripts/cropper-manager.js');
        wp_enqueue_script('cropper-js', 'https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js', array('jquery'), '2.0.0', true);
        wp_enqueue_script('sportcards-configurator-js', plugin_dir_url(__FILE__) . 'scripts/sportcards-configurator.js');
        wp_enqueue_script('price-calculator-js', plugin_dir_url(__FILE__) . 'scripts/price-calculator.js');

        wp_localize_script('sportcards-configurator-js', 'dependencies', $localization_data);
        wp_localize_script('price-calculator-js', 'dependencies', $localization_data);
    }

    function enqueue_scripts_admin() {
        wp_enqueue_style('sportcards-admin-css', plugin_dir_url(__FILE__) . 'admin/styles.css');
        wp_enqueue_script('script-js', plugin_dir_url(__FILE__) . 'admin/scripts/script.js');
    }
?>