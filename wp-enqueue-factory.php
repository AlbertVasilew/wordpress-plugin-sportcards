<?php
    wp_enqueue_style('sportcards_styles', plugin_dir_url(__FILE__) . 'styles.css');
    wp_enqueue_style('cropper-_styles', 'https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css');

    wp_enqueue_script(
        'player-card-script', plugin_dir_url(__FILE__) . 'scripts/player-card.js', array(), null, true);

    wp_enqueue_script(
        'price-calculator-script', plugin_dir_url(__FILE__) . 'scripts/price-calculator.js', array(), null, true);

    wp_enqueue_script('cropper-js', 'https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js', array('jquery'), '2.0.0', true);

    wp_enqueue_script(
        'sportcards-configurator-script', plugin_dir_url(__FILE__) . 'scripts/sportcards-configurator.js', array(), null, true);

    wp_localize_script('sportcards-configurator-script', 'php_vars', array(
        'cards' => plugins_url('/assets/cards/', __FILE__),
        'clubs' => plugins_url('/assets/clubs/', __FILE__),
        'countries' => plugins_url('/assets/countries/', __FILE__),
        'ajax_url' => admin_url( 'admin-ajax.php' )
    ));
?>