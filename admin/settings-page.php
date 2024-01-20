<?php
    global $wpdb;
    $clubs_table = $wpdb->prefix . 'sportcards_clubs';
    $cards_table = $wpdb->prefix . 'sportcards_cards';
    $materials_table = $wpdb->prefix . "sportcards_materials";
    $sizes_table = $wpdb->prefix . "sportcards_sizes";
    $prices_table = $wpdb->prefix . "sportcards_prices";

    $clubs = $wpdb->get_results("SELECT * FROM $clubs_table");
    $cards = $wpdb->get_results("SELECT * FROM $cards_table");

    $materials = $wpdb->get_results("SELECT * FROM $materials_table");
    $sizes = $wpdb->get_results("SELECT * FROM $sizes_table");
    $prices = $wpdb->get_results("SELECT * FROM $prices_table");
?>

<div class="wrap">
    <h2>Sportcards Customizer Settings</h2>
    <div class="SectionContainer">
        <div class="modal" id="clubModal">
            <div class="modal-content" style="width: 200px;">
                <h2>Добави нов клуб</h2>
                <form id="clubForm">
                    <label for="clubName">Име на клуб:</label>
                    <input type="text" id="clubName" name="clubName" required>

                    <label for="clubImage">Изображение за клуб:</label>
                    <input type="file" id="clubImage" name="clubImage" accept="image/*" required>

                    <button type="button" id="saveClub">Запази</button>
                </form>
            </div>
        </div>
        <div class="SectionContainerHeader">
            <div class="SectionContainerHeader__title">Управлявай клубове</div>
            <div class="SectionContainerHeader__add-new" id="addNewClubBtn">Добави нов клуб</div>
        </div>
        <div class="SectionContainerItems">
            <?php
                if (!$clubs)
                    echo "There are no added clubs yet";

                foreach ($clubs as $club) {
                    $id = $club->Id;
                    $name = $club->Name;
                    $image = $club->Image;
                    ?>
                    <div class="ItemContainer">
                        <div class="ItemContainer__item-name"><?php echo $name; ?></div>
                        <img
                            loading="lazy"
                            class="ItemContainer__item-image"
                            src="<?php echo $image ?>"
                            alt="<?php echo $name ?>"
                        />
                        <div class="ItemContainer__item-delete" data-club-id="<?php echo $id; ?>">Премахни</div>
                    </div>
                    <?php
                }
            ?>
        </div>  
    </div>
    <div class="SectionContainer">
        <div class="modal" id="cardModal">
            <div class="modal-content" style="width: 200px;">
                <h2>Добави нова карта</h2>
                <form id="cardForm" enctype="multipart/form-data">
                    <label for="cardImages">Изображения за карти:</label>
                    <input type="file" id="cardImages" name="cardImages[]" accept="image/*" multiple required>

                    <button type="button" id="saveCard">Запази</button>
                </form>
            </div>
        </div>
        <div class="SectionContainerHeader">
            <div class="SectionContainerHeader__title">Управлявай карти</div>
            <div class="SectionContainerHeader__add-new" id="addNewCardBtn">Добави нова карта</div>
        </div>
        <div class="SectionContainerItems">
            <?php
                if (!$cards)
                    echo "Няма налични карти";

                foreach ($cards as $card) {
                    $id = $card->Id;
                    $image = $card->Image;
                    ?>
                    <div class="ItemContainer">
                        <img 
                            loading="lazy"
                            class="ItemContainer__item-image"
                            src="<?php echo $image ?>"
                            alt="<?php echo $image ?>"
                        />
                        <div class="ItemContainer__item-delete" data-card-id="<?php echo $id; ?>">Премахни</div>
                    </div>
                    <?php
                }
            ?>
        </div>  
    </div>
    <div class="SectionContainer">
        <div class="SectionContainerHeader">
            <div class="SectionContainerHeader__title">Управлявай цени</div>
            <div class="SectionContainerHeader__add-new" id="updatePrices">Обнови цени</div>
        </div>
        <div class="SectionContainerItems">
            <table id="PricingTable">
                <tr>
                    <th>Размер</th>
                    <th>Материал</th>
                    <th>Цена (<?php echo get_woocommerce_currency_symbol() ?>)</th>
                </tr>
                <?php foreach ($sizes as $size) : ?>
                    <?php foreach ($materials as $material) : ?>
                        <?php
                            $variationPrice = null;

                            foreach ($prices as $price) {
                                if ($price->Size_Id == $size->Id && $price->Material_Id == $material->Id) {
                                    $variationPrice = $price->Price;
                                    break;
                                }
                            }
                        ?>

                        <tr>
                            <td><?= $size->Text ?></td>
                            <td><?= $material->Text ?></td>
                            <td>
                                <input
                                    type="text"
                                    class="PricingTable__price"
                                    value="<?= $variationPrice ?>"
                                    data-size-id="<?= $size->Id ?>"
                                    data-material-id="<?= $material->Id ?>"
                                />
                            </td>
                        </tr>

                    <?php endforeach; ?>
                <?php endforeach; ?>
            </table>
        </div>  
    </div>
</div>