<?php
    function sportcards_shortcode() {
        ob_start();
        include_once(plugin_dir_path(__FILE__) . 'sportcards-configurator.php');
        return ob_get_clean();
    }

    add_shortcode('sportcards_configurator', 'sportcards_shortcode');
?>