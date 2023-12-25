<?php
    function enqueue_write_over_image_script() {
        wp_enqueue_script(
            'write-over-image-script',
            plugin_dir_url(__FILE__) . 'player-card.js',
            array(),
            null,
            true
        );
    }

    add_action('wp_enqueue_scripts', 'enqueue_write_over_image_script');
?>

<script type="module">
    document.addEventListener('DOMContentLoaded', function () {
        var canvas = document.getElementById("myCanvas");
        var context = canvas.getContext("2d");
        var playerCard = new PlayerCard(context, "black");

        var img = new Image();
        img.src = '<?php echo plugins_url('/assets/card.png', __FILE__); ?>';

        const flag = new Image();
        flag.src = '<?php echo plugins_url('/assets/flag.png', __FILE__); ?>';

        const club = new Image();
        club.src = '<?php echo plugins_url('/assets/club.png', __FILE__); ?>';

        var ratingInput = document.getElementById("rating");

        document.getElementById("SportCardsCustomizerFieldsContainer")
            .addEventListener("input", event => updateCanvasValues());

        const updateCanvasValues = () => {
            context.clearRect(0, 0, canvas.width, canvas.height);

            context.drawImage(img, 0, 0, canvas.width, canvas.height);
            context.drawImage(flag, 90, 165, 40, 25);
            context.drawImage(club, 90, 210, 40, 50);

            playerCard.setPosition("ST");

            playerCard.setRating(document.getElementById('rating').value);
            playerCard.setName(document.getElementById('name').value);
            playerCard.setPac(document.getElementById('pac').value);
            playerCard.setSho(document.getElementById('sho').value);
            playerCard.setPas(document.getElementById('pas').value);
            playerCard.setDri(document.getElementById('dri').value);
            playerCard.setDef(document.getElementById('def').value);
            playerCard.setPhy(document.getElementById('phy').value);
        }

        img.onload = function () {
            updateCanvasValues();
        };
    });
</script>