<?php
    function add_sportcard_data_in_cart($item_data, $cart_item) {
        if (isset($cart_item['card_data'])) {
            foreach ($cart_item['card_data'] as $key => $value) {
                if ($key != 'price')
                    $item_data[] = array('key' => $key, 'value' => $value);
            }
        }

        return $item_data;
    }

    function add_sportcard_data_in_order($item, $cart_item_key, $cart_item, $order) {
        if (isset($cart_item['card_data'])) {
            foreach ($cart_item['card_data'] as $key => $value) {
                if ($key != 'price')
                    $item->update_meta_data($key, $value);
            }
        }
    }

    function add_sportcard_to_cart($player_image_url, $customized_card_url)
    {
        global $wpdb;
        $product_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND " .
            "meta_value='sportcards-customizer-system-product'");

        $card_data = $_POST["card_data"];

        $cart_item_key = WC()->cart->add_to_cart($product_id, 1, 0, array(), array('card_data' => array(
            'Материал' => $card_data['material'],
            'Размер' => $card_data['size'],
            'Цвят' => $card_data['color'],
            'Рейтинг' => $card_data['rating'],
            'Позиция' => $card_data['position'],
            'Име' => $card_data['name'],
            'PAC' => $card_data['pac'],
            'SHO' => $card_data['sho'],
            'PAS' => $card_data['pas'],
            'DEF' => $card_data['def'],
            'DRI' => $card_data['dri'],
            'PHY' => $card_data['phy'],
            'Дизайн' => $card_data['cardImageUrl'],
            'Държава' => $card_data['countryFlagUrl'],
            'Отбор' => $card_data['clubLogoUrl'],
            'Снимка на играч' => $player_image_url,
            'Завършен дизайн' => $customized_card_url,
            'price' => $_POST["price"]
        )));
    }

    function set_sportcard_price($cart_object) {
        foreach ($cart_object->get_cart() as $cart_item_key => $cart_item) {
            if (isset($cart_item['card_data']['price']))
                $cart_item['data']->set_price(floatval($cart_item['card_data']['price']));
        }
    }

    function upload_image($image_source, $path_and_prefix) {
        $image = str_replace('data:image/png;base64,', '', $image_source);
        $image = str_replace(' ', '+', $image);
        $image = base64_decode($image);

        $image_path = $path_and_prefix . uniqid() . '.png';
        file_put_contents(plugin_dir_path(__FILE__) . $image_path, $image);

        return plugin_dir_url(__FILE__) . $image_path;
    }

    function generate_user_sportcard() {
        add_sportcard_to_cart(
            upload_image($_POST['player_image'], 'assets/player-images/player_image_'),
            upload_image($_POST['customized_card_image'], 'assets/customized-cards/customized_card_'));

        wp_send_json(array('redirect_url' => wc_get_cart_url()));
        exit;
    }
?>