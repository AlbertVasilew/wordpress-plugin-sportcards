<?php
    wp_enqueue_style('sportcards_styles', plugin_dir_url(__FILE__) . 'styles.css');

    function sportcards_hello_world_shortcode() {
        ?>
            <div id="SportCardsCustomizerWrapper">
                <canvas id="myCanvas" width="400" height="500"></canvas>
                <div id="SportCardsCustomizerFieldsContainer">
                    <div>
                        <label for="rating">Rating</label>
                        <input type="text" id="rating" name="rating"/>
                    </div>
                    <div>
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name"/>
                    </div>
                    <div>
                        <label for="pac">Pac</label>
                        <input type="text" id="pac" name="pac"/>
                    </div>
                    <div>
                        <label for="sho">Sho</label>
                        <input type="text" id="sho" name="sho"/>
                    </div>
                    <div>
                        <label for="pas">Pas</label>
                        <input type="text" id="pas" name="pas"/>
                    </div>
                    <div>
                        <label for="dri">Dri</label>
                        <input type="text" id="dri" name="dri"/>
                    </div>
                    <div>
                        <label for="def">Def</label>
                        <input type="text" id="def" name="def"/>
                    </div>
                    <div>
                        <label for="phy">Phy</label>
                        <input type="text" id="phy" name="phy"/>
                    </div>
                </div>
            </div>
        <?php

        include plugin_dir_path(__FILE__) . 'write-over-image-plugin.php';
    }

    add_shortcode('sportcards_hello_world', 'sportcards_hello_world_shortcode');