<?php
    global $wpdb;

    $clubs_table = $wpdb->prefix . 'sportcards_clubs';
    $cards_table = $wpdb->prefix . 'sportcards_cards';
    $materials_table = $wpdb->prefix . 'sportcards_materials';
    $sizes_table = $wpdb->prefix . 'sportcards_sizes';

    $clubs = $wpdb->get_results("SELECT * FROM $clubs_table");
    $cards = $wpdb->get_results("SELECT * FROM $cards_table");
    $materials = $wpdb->get_results("SELECT * FROM $materials_table");
    $sizes = $wpdb->get_results("SELECT * FROM $sizes_table");

    if (!$cards || !$clubs) {
        if (current_user_can('manage_options')) {
            echo 'You must configure the sportcards customizer at first.<br/>' .
                '<a href="' . home_url('wp-admin/admin.php?page=sportcards-settings') . '" target="_blank">' .
                'Go to settings</a>';
        }

        return;
    }
?>

<div id="SportCardsCustomizerWrapper">
    <canvas id="myCanvas" width="400" height="500"></canvas>
    <div id="SportCardsCustomizerFieldsContainer">
        <div class="FieldContainer">
            <div class="FieldContainer__label">Материал</div>
            <div id="material" class="FieldContainer__field MaterialField">
                <?php foreach ($materials as $key => $material) : ?>
                    <div
                        class="material-option <?= ($key === 0) ? 'selected' : '' ?>"
                        data-value="<?= $material->Id ?>"
                        data-text="<?= $material->Text ?>"
                    >
                        <?= $material->Text ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="FieldContainer">
            <div class="FieldContainer__label">Размер</div>
            <div id="size" class="FieldContainer__field SizeField">
                <?php foreach ($sizes as $key => $size) : ?>
                    <div
                        class="size-option <?= ($key === 0) ? 'selected' : '' ?>"
                        data-value="<?= $size->Id ?>"
                        data-text="<?= $size->Text ?>"
                    >
                        <?= $size->Text ?>
                    </div>
                <?php endforeach; ?>
            </div>
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
        
        <div id="skills-inputs-container"></div>

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
                <option value="RWB">RWB</option>
                <option value="RB">RB</option>
                <option value="CB">CB</option>
                <option value="LM">LM</option>
                <option value="LW">LW</option>
                <option value="CDM">CDM</option>
                <option value="CM">CM</option>
                <option value="CAM">CAM</option>
                <option value="RM">RM</option>
                <option value="RW">RW</option>
                <option value="ST">ST</option>
                <option value="CF">CF</option>
                <option value="LF">LF</option>
                <option value="RF">RF</option>
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
        <button id="addToCartBtn">Купи</button>
    </div>
</div>