<?php
    function save_club() {
        global $wpdb;
        
        $uploaded_image = $_FILES['clubImage'];
        $file_name = uniqid() . '_' . basename($uploaded_image['name']);
        $dest_path = plugin_dir_path(dirname(__FILE__)) . 'assets/clubs/' . $file_name;

        if (move_uploaded_file($uploaded_image['tmp_name'], $dest_path)) {
            $wpdb->insert(
                $wpdb->prefix . 'sportcards_clubs',
                array(
                    'Name'  => sanitize_text_field($_POST['clubName']),
                    'Image' => plugin_dir_url(dirname(__FILE__)) . 'assets/clubs/' . $file_name,
                ),
                array('%s', '%s')
            );
        }

        die();
    }

    function delete_club() {
        global $wpdb;
        $wpdb->delete($wpdb->prefix . 'sportcards_clubs', array('Id' => intval($_POST['id'])));
        die();
    }

    function save_card() {
        global $wpdb;
        $uploaded_images = $_FILES['cardImages'];
        
        foreach ($uploaded_images['name'] as $key => $value) {
            $file_name = uniqid() . '_' . basename($uploaded_images['name'][$key]);
            $dest_path = plugin_dir_path(dirname(__FILE__)) . 'assets/cards/' . $file_name;
    
            if (move_uploaded_file($uploaded_images['tmp_name'][$key], $dest_path)) {
                $wpdb->insert(
                    $wpdb->prefix . 'sportcards_cards',
                    array('Image' => plugin_dir_url(dirname(__FILE__)) . 'assets/cards/' . $file_name),
                    array('%s')
                );
            }
        }
    
        die();
    }

    function delete_card() {
        global $wpdb;
        $wpdb->delete($wpdb->prefix . 'sportcards_cards', array('Id' => intval($_POST['id'])));
        die();
    }
?>