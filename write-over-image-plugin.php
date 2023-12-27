<?php
    wp_enqueue_script(
        'write-over-image-script', plugin_dir_url(__FILE__) . 'player-card.js', array(), null, true);
?>

<script type="module">
    document.addEventListener('DOMContentLoaded', function () {
        var canvas = document.getElementById("myCanvas");
        var context = canvas.getContext("2d");
        var playerCard = new PlayerCard(context, "black");

        document.getElementById("SportCardsCustomizerFieldsContainer")
            .addEventListener("change", event => updateCanvasValues());

        document.querySelectorAll(".CardImage").forEach(thumbnail =>
            thumbnail.addEventListener('click', () => updateCanvasValues(thumbnail.src)));

        const updateCanvasValues = cardImageUrl => {
            context.clearRect(0, 0, canvas.width, canvas.height);

            const cardImage = new Image();
            cardImage.src = cardImageUrl ?
                cardImageUrl : '<?php echo plugins_url('/assets/cards/', __FILE__); ?>' + `card-design-1.png`;

            cardImage.onload = () => {
                context.drawImage(cardImage, 0, 0, canvas.width, canvas.height);

                playerCard.setClubLogo('<?php echo plugins_url('/assets/clubs/', __FILE__); ?>' +
                    `${document.getElementById('club').value}.png`);

                playerCard.setCountryFlag('<?php echo plugins_url('/assets/countries/', __FILE__); ?>' +
                    `${document.getElementById('country').value}.png`);

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
        }

        updateCanvasValues();
    });
</script>