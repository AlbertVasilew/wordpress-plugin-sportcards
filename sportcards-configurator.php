<?php
    global $wpdb;
    $table_name = $wpdb->prefix . 'sportcards_clubs';

    $query = "SELECT * FROM $table_name";
    $results = $wpdb->get_results($query);
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
            <div class="FieldContainer__label">Позиция</div>
            <select id="position" class="FieldContainer__field">
                <option value="GK">GK</option>
                <option value="LB">LB</option>
                <option value="LWB">LWB</option>
            </select>
        </div>
        <div class="FieldContainer">
            <div class="FieldContainer__label">Отбор</div>
            <select id="club" class="FieldContainer__field">
                <?php
                    foreach ($results as $club) {
                        echo "<option value='" . $club->Image ."'>" . $club->Name . "</option>";
                    }
                ?>
            </select>
        </div>
        <div class="FieldContainer">
            <div class="FieldContainer__label">Държава</div>
            <select id="country" class="FieldContainer__field"></select>
        </div>
        <div class="FieldContainer">
            <div class="FieldContainer__label">Рейтинг</div>
            <input type="text" id="rating" class="FieldContainer__field"/>
        </div>
        <div class="FieldContainer">
            <div class="FieldContainer__label">Име</div>
            <input type="text" id="name" class="FieldContainer__field"/>
        </div>
        <div class="FieldContainer">
            <div class="FieldContainer__label">PAC</div>
            <input type="text" id="pac" class="FieldContainer__field"/>
        </div>
        <div class="FieldContainer">
            <div class="FieldContainer__label">SHO</div>
            <input type="text" id="sho" class="FieldContainer__field"/>
        </div>
        <div class="FieldContainer">
            <div class="FieldContainer__label">PAS</div>
            <input type="text" id="pas" class="FieldContainer__field"/>
        </div>
        <div class="FieldContainer">
            <div class="FieldContainer__label">DRI</div>
            <input type="text" id="dri" class="FieldContainer__field"/>
        </div>
        <div class="FieldContainer">
            <div class="FieldContainer__label">DEF</div>
            <input type="text" id="def" class="FieldContainer__field"/>
        </div>
        <div class="FieldContainer">
            <div class="FieldContainer__label">PHY</div>
            <input type="text" id="phy" class="FieldContainer__field"/>
        </div>
        <div class="FieldContainer">
            <div class="FieldContainer__label">Дизайн</div>
            <div class="FieldContainer__field--cards">
            <?php
                $imageFolder = plugin_dir_path(__FILE__) . 'assets/cards';
                $allowedExtensions = ["jpg", "jpeg", "png", "gif"];
                $files = scandir($imageFolder);

                foreach ($files as $file) {
                    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    if (in_array($extension, $allowedExtensions)) {
                        $imageUrl = plugins_url('/assets/cards/', __FILE__) . $file;
                        echo '<img class="CardImage" src="' . $imageUrl . '" alt="' . $file . '">';
                    }
                }
            ?>
            </div>
        </div>
        <div class="FieldContainer">
            <div class="FieldContainer__label">Цвят на текста</div>
            <input type="color" id="selectedColor" class="FieldContainer__field" value="#ffffff">
        </div>
        <div class="FieldContainer">
            <div class="FieldContainer__label">Снимка на футболист</div>

            <input type="file" id="image-input" accept="image/*">
            
            <div id="image-modal">
                <img id="cropped-image" src="#" alt="Cropped Image">
                <div id="modal-close">Приложи</div>
            </div>
        </div>
        <div id="PriceContainer">
            Крайна цена:
            <div id="PriceContainer__price"></div>
        </div>
        <button id="addToCartBtn">Add to Cart</button>
    </div>
</div>