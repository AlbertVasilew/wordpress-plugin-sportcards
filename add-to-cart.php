<?php   
    function display_cart_item_custom_meta_data( $item_data, $cart_item ) {
        if ( isset($cart_item['card_data']) && is_array($cart_item['card_data']) ) {
            foreach ($cart_item['card_data'] as $key => $value) {
                $item_data[] = array(
                    'key'   => $key,
                    'value' => $value,
                );
            }
        }

        return $item_data;
    }

    function save_cart_item_custom_meta_as_order_item_meta( $item, $cart_item_key, $values, $order ) {
        if ( isset($values['card_data']) && is_array($values['card_data']) ) {
            foreach ($values['card_data'] as $key => $value) {
                $item->update_meta_data( $key, $value );
            }
        }
    }

    function add_to_cart ()
    {
        $card_data1 = $_POST["card_data"];

        $cart_item_key = WC()->cart->add_to_cart(32, 1, 0, array(), array('card_data' => array(
            'Материал' => $card_data1['material'],
            'Позиция' => $card_data1['position']
        )));

        wp_send_json(array('redirect_url' => wc_get_cart_url()));
        exit;
    }
?>