<?php
    include_once(plugin_dir_path(__FILE__) . 'methods.php');
    
    function sportcards_settings_link($links) {
        $settings_link = '<a href="admin.php?page=sportcards-settings">Settings</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    function add_sportcards_settings_menu() {
        add_submenu_page(null, null, null, 'manage_options', 'sportcards-settings', 'settings_page_content');
    }

    function settings_page_content() {
        include_once(plugin_dir_path(__FILE__) . 'settings-page.php');
    }
?>