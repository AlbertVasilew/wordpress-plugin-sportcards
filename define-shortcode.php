<?php
    include plugin_dir_path(__FILE__) . 'wp-enqueue-factory.php';
    include plugin_dir_path(__FILE__) . 'hooks.php';
    include plugin_dir_path(__FILE__) . 'add-to-cart.php';

    function sportcards_shortcode() {
        ob_start();
        include plugin_dir_path(__FILE__) . 'sportcards-configurator.php';
        return ob_get_clean();
    }

    add_shortcode('sportcards_configurator', 'sportcards_shortcode');