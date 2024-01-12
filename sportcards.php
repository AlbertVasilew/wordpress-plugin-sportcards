<?php
    /*
        Plugin Name:  Sportcards Customizer
        Description:  Allows users to customize & order sportcards
        Version:      1.0
        Author:       Albert & Bojidar
    */

    include_once(plugin_dir_path(__FILE__) . 'activation.php');
    include_once(plugin_dir_path(__FILE__) . 'enqueues.php');
    include_once(plugin_dir_path(__FILE__) . 'hooks.php');
    include_once(plugin_dir_path(__FILE__) . 'create-shortcode.php');

    register_activation_hook(__FILE__, 'sportcards_activate');
?>