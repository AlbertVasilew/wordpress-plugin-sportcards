<?php
    global $wpdb;
    $clubs_table = $wpdb->prefix . 'sportcards_clubs';
    $cards_table = $wpdb->prefix . 'sportcards_cards';

    $clubs = $wpdb->get_results("SELECT * FROM $clubs_table");
    $cards = $wpdb->get_results("SELECT * FROM $cards_table");

    if (!$cards || !$clubs) {
        if (current_user_can('manage_options')) {
            echo 'You must configure the sportcards customizer at first.<br/>' .
                '<a href="' . home_url('wp-admin/admin.php?page=sportcards-settings') . '" target="_blank">' .
                'Go to Sportcards Customizer Settings</a>';
        }

        return;
    }
?>

<div id="SportCardsCustomizerWrapper">
    <canvas id="myCanvas" width="400" height="500"></canvas>
    <div id="SportCardsCustomizerFieldsContainer">
        <div class="FieldContainer">
            <div class="FieldContainer__label">Материал</div>
            <select id="material" class="FieldContainer__field">
                <option value="pvc">PVC</option>
                <option value="metal">Метал</option>
            </select>
        </div>
        <div class="FieldContainer">
            <div class="FieldContainer__label">Размер</div>
            <select id="size" class="FieldContainer__field">
                <option value="small">Малък - 24x15</option>
                <option value="medium">Среден - 30x19</option>
                <option value="large">Голям - 40x25</option>
            </select>
        </div>

        <div class="FieldContainer">
            <div class="FieldContainer__label">Име</div>
            <input type="text" id="name" class="FieldContainer__field"/>
        </div>
        
        <div class="FieldContainer">
            <div class="FieldContainer__label">Отбор</div>
            <select id="club" class="FieldContainer__field">
                <?php
                    foreach ($clubs as $club) {
                        echo "<option value='" . $club->Image ."'>" . $club->Name . "</option>";
                    }
                ?>
            </select>
        </div>
        <div class="skills-inputs-container" style="display: flex;">
            <div class="stat-inputs-container">
                <div class="stat-input-container">
                    <label>PAC</label>
                    <input type="number" min="0" max="99" id="pac" value="99" class="stat-input">
                </div>
                <div class="stat-input-container">
                    <label>SHO</label>
                    <input type="number" min="0" max="99" id="sho" value="99" class="stat-input">
                </div>
                <div class="stat-input-container">
                    <label>PAS</label>
                    <input type="number" min="0" max="99" id="pas" value="99" class="stat-input">
                </div>
            </div>
            <div class="stat-inputs-container">
                <div class="stat-input-container">
                    <label>DRI</label>
                    <input type="number" min="0" max="99" id="dri" value="99" class="stat-input">
                </div>
                <div class="stat-input-container">
                    <label>DEF</label>
                    <input type="number" min="0" max="99" id="def" value="99" class="stat-input">
                </div>
                <div class="stat-input-container">
                    <label>PHY</label>
                    <input type="number" min="0" max="99" id="phy" value="99" class="stat-input">
                </div>
            </div>
        </div>

        <div class="FieldContainer">
            <div class="FieldContainer__label">Рейтинг</div>
            <input type="text" id="rating" class="FieldContainer__field"/>
        </div>

        <div class="FieldContainer">
            <div class="FieldContainer__label">Позиция</div>
            <select id="position" class="FieldContainer__field">
                <option value="GK">GK</option>
                <option value="LB">LB</option>
                <option value="LWB">LWB</option>
            </select>
        </div>

        <div class="FieldContainer">
            <div class="FieldContainer__label">Държава</div>
            <select id="country" class="FieldContainer__field"></select>
        </div>

        <div class="FieldContainer">
            <div class="FieldContainer__label">Дизайн</div>
            <div class="FieldContainer__field--cards">
            <?php
                foreach ($cards as $card)
                    echo '<img loading="lazy" class="CardImage" src="' . $card->Image . '" alt="' . $card->Image . '">';
            ?>
            </div>
        </div>

        <div class="price-color-picker">
            <div class="image-input-wrap">
                <label id="image-input-label" for="image-input">
                    Изберете снимка
                    <input id="image-input" type="file" accept="image/*" name="player-image-input" style="display: none;">
                </label>
                
                <div id="image-modal">
                    <img id="cropped-image" src="#" alt="Cropped Image">
                    <div id="modal-close">Приложи</div>
                </div>
            </div>
    
            <div class="color-input-wrap">
                <div class="">Цвят на текста</div>
                <input type="color" id="selectedColor" class="FieldContainer__field" value="#ffffff">
            </div>
        </div>
        
        <div id="PriceContainer">
            Крайна цена:
            <div id="PriceContainer__price"></div>
        </div>
        <button id="addToCartBtn">Add to Cart</button>
    </div>
</div>