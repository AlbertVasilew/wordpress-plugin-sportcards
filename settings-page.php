<?php
    function your_plugin_settings_page() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'sportcards_clubs';

        if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['club_id'])) {
            $club_id = intval($_GET['club_id']);
            $wpdb->delete($table_name, array('Id' => $club_id));
            wp_redirect(admin_url('admin.php?page=sportcards-settings'));
            exit;
        }

        $query = "SELECT * FROM $table_name";
        $results = $wpdb->get_results($query);
        ?>
            <div class="wrap">
                <h2>Sportcards Customizer Settings</h2>
                <div class="SectionContainer">
                    <div class="modal" id="clubModal">
                        <div class="modal-content" style="width: 200px;">
                            <span class="close-modal" onclick="closeModal()">&times;</span>
                            <h2>Add New Club</h2>
                            <form id="clubForm">
                                <label for="clubName">Club Name:</label>
                                <input type="text" id="clubName" name="clubName" required>

                                <label for="clubImage">Club Image:</label>
                                <input type="file" id="clubImage" name="clubImage" accept="image/*" required>

                                <button type="button" onclick="saveClub()">Save</button>
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

            <script>
                jQuery(document).ready(function ($) {
                    $('.ItemContainer__item-delete').click(function () {
                        var clubId = $(this).data('club-id');

                        if (confirm('Are you sure you want to delete this record?')) {
                            window.location.href = '<?php echo admin_url('admin.php?page=sportcards-settings&action=delete&club_id='); ?>' + clubId;
                        }
                    });
                });
            </script>

            <script>
                var modal = document.getElementById('clubModal');
                var addNewClubBtn = document.getElementById('addNewClubBtn');

                addNewClubBtn.onclick = function () {
                    modal.style.display = 'block';
                };

                window.onclick = function (event) {
                    if (event.target === modal) {
                        closeModal();
                    }
                };

                function closeModal() {
                    modal.style.display = 'none';
                }

                function saveClub() {
                    var clubName = document.getElementById('clubName').value;
                    var clubImage = document.getElementById('clubImage').files[0];

                    if (clubName && clubImage) {
                        var formData = new FormData();
                        formData.append('action', 'save_club');
                        formData.append('clubName', clubName);
                        formData.append('clubImage', clubImage);

                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', ajaxurl, true);
                        xhr.onreadystatechange = function () {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                location.reload();
                            }
                        };
                        xhr.send(formData);
                    } else {
                        alert('Please enter club name and select an image.');
                    }
                }
            </script>
        <?php
    }
?>