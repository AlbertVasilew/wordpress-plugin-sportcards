<?php
    global $wpdb;
    $clubs_table = $wpdb->prefix . 'sportcards_clubs';
    $cards_table = $wpdb->prefix . 'sportcards_cards';

    $clubs = $wpdb->get_results("SELECT * FROM $clubs_table");
    $cards = $wpdb->get_results("SELECT * FROM $cards_table");
?>

<div class="wrap">
    <h2>Sportcards Customizer Settings</h2>
    <div class="SectionContainer">
        <div class="modal" id="clubModal">
            <div class="modal-content" style="width: 200px;">
                <h2>Add New Club</h2>
                <form id="clubForm">
                    <label for="clubName">Club Name:</label>
                    <input type="text" id="clubName" name="clubName" required>

                    <label for="clubImage">Club Image:</label>
                    <input type="file" id="clubImage" name="clubImage" accept="image/*" required>

                    <button type="button" id="saveClub">Save</button>
                </form>
            </div>
        </div>
        <div class="SectionContainerHeader">
            <div class="SectionContainerHeader__title">Manage clubs</div>
            <div class="SectionContainerHeader__add-new" id="addNewClubBtn">Add new club</div>
        </div>
        <div class="SectionContainerItems">
            <?php
                foreach ($clubs as $club) {
                    $id = $club->Id;
                    $name = $club->Name;
                    $image = $club->Image;
                    ?>
                    <div class="ItemContainer">
                        <div class="ItemContainer__item-name"><?php echo $name; ?></div>
                        <img class="ItemContainer__item-image" src="<?php echo $image ?>" alt="<?php echo $name ?>">
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
                <h2>Add New Card</h2>
                <form id="cardForm">
                    <label for="cardImage">Card Image:</label>
                    <input type="file" id="cardImage" name="cardImage" accept="image/*" required>

                    <button type="button" id="saveCard">Save</button>
                </form>
            </div>
        </div>
        <div class="SectionContainerHeader">
            <div class="SectionContainerHeader__title">Manage cards</div>
            <div class="SectionContainerHeader__add-new" id="addNewCardBtn">Add new card</div>
        </div>
        <div class="SectionContainerItems">
            <?php
                foreach ($cards as $card) {
                    $id = $card->Id;
                    $image = $card->Image;
                    ?>
                    <div class="ItemContainer">
                        <img class="ItemContainer__item-image" src="<?php echo $image ?>" alt="<?php echo $image ?>">
                        <div class="ItemContainer__item-delete" data-card-id="<?php echo $id; ?>">Премахни</div>
                    </div>
                    <?php
                }
            ?>
        </div>  
    </div>
</div>