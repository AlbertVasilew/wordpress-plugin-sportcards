<?php
    global $wpdb;
    $table_name = $wpdb->prefix . 'sportcards_clubs';

    $query = "SELECT * FROM $table_name";
    $results = $wpdb->get_results($query);
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
                foreach ($results as $club) {
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
</div>