<?php
    function enqueue_scripts() {
        $localization_data = array(
            'cards' => plugins_url('/assets/cards/', __FILE__),
            'ajax_url' => admin_url('admin-ajax.php'),
            'currency' => get_woocommerce_currency_symbol(),
        );

        wp_enqueue_style('sportcards-css', plugin_dir_url(__FILE__) . 'styles.css');
        wp_enqueue_style('cropper-css', 'https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css');
        wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');

        wp_enqueue_script('player-card-js', plugin_dir_url(__FILE__) . 'scripts/player-card.js');
        wp_enqueue_script('cropper-manager-js', plugin_dir_url(__FILE__) . 'scripts/cropper-manager.js');
        wp_enqueue_script('cropper-js', 'https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js', array('jquery'), '2.0.0', true);
        wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js');
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