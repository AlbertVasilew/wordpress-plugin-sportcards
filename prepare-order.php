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

    function add_sportcard_to_cart($image_path)
    {
        $card_data = $_POST["card_data"];

        $cart_item_key = WC()->cart->add_to_cart(14, 1, 0, array(), array('card_data' => array(
            'Материал' => $card_data['material'],
            'Позиция' => $card_data['position'],
            'Снимка' => $image_path,
            'price' => $_POST["price"]
        )));
    }

    function set_sportcard_price($cart_object) {
        foreach ($cart_object->get_cart() as $cart_item_key => $cart_item) {
            if (isset($cart_item['card_data']['price']))
                $cart_item['data']->set_price(floatval($cart_item['card_data']['price']));
        }
    }

    function upload_player_image() {
        $image_data = $_POST['image_data'];
        $image_data = str_replace('data:image/png;base64,', '', $image_data);
        $image_data = str_replace(' ', '+', $image_data);
        $image_data = base64_decode($image_data);

        $image_path = plugin_dir_path(__FILE__) . 'assets/player-images/player_image_' . uniqid() . '.png';
        file_put_contents($image_path, $image_data);

        return $image_path;
    }

    function generate_user_sportcard() {
        $image_path = upload_player_image();
        add_sportcard_to_cart($image_path);

        wp_send_json(array('redirect_url' => wc_get_cart_url()));
        exit;
    }
?>