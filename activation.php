<?php
    function sportcards_activate() {
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
?>