<?php
    wp_enqueue_script(
        'player-card-script', plugin_dir_url(__FILE__) . 'player-card.js', array(), null, true);

    wp_enqueue_script(
        'price-calculator-script', plugin_dir_url(__FILE__) . 'price-calculator.js', array(), null, true);
?>

<script type="module">
    document.addEventListener('DOMContentLoaded', function () {
        var canvas = document.getElementById("myCanvas");
        var context = canvas.getContext("2d");
        var playerCard = new PlayerCard(context, "black");
        var priceCalculator = new PriceCalculator();

        document.getElementById("SportCardsCustomizerFieldsContainer")
            .addEventListener("change", event => updateVisualization());

        document.querySelectorAll(".CardImage").forEach(thumbnail =>
            thumbnail.addEventListener('click', () => updateVisualization(thumbnail.src)));

        const calculateMaterialAndSizePrice = () => {
            const material = document.getElementById('material');
            const size = document.getElementById('size');
            const sizeValue = size.value;

            const createOption = (select, optionValue, optionText) => {
                const newOption = document.createElement("option");
                newOption.value = optionValue;
                newOption.text = optionText;

                select.appendChild(newOption);
            };

            const setPriceBasedOnSize = (value) => {
                switch (value) {
                    case 'small':
                        return material.value === 'pvc' ? 40 : 60;
                    case 'medium':
                        return material.value === 'pvc' ? 50 : 80;
                    case 'large':
                        return material.value === 'pvc' ? 65 : 85;
                    default:
                        return 0; // Default price or handle as needed
                }
            };

            const updateOptionsAndPrice = () => {
                const materialType = material.value;

                Array.from(size.options).forEach(option => option.remove());

                const sizesData = {
                    'pvc': ['small', 'Малък - 24x15 (40 лв)', 'medium', 'Среден - 30x19 (50 лв)', 'large', 'Голям - 40x25 (65 лв)'],
                    'metal': ['small', 'Малък - 24x15 (60 лв)', 'medium', 'Среден - 30x19 (80 лв)', 'large', 'Голям - 40x25 (85 лв)'],
                };

                for (let i = 0; i < sizesData[materialType].length; i += 2) {
                    createOption(size, sizesData[materialType][i], sizesData[materialType][i + 1]);
                }

                size.value = sizeValue;
                priceCalculator.setPrice(setPriceBasedOnSize(size.value));
            };

            updateOptionsAndPrice();
        };

        const setPrice = price => document.getElementById('PriceContainer__price').innerText = `${price} лв.`;

        const updateVisualization = cardImageUrl => {
            updateCard(cardImageUrl);
            calculateMaterialAndSizePrice();
            setPrice(priceCalculator.getPrice());
        }

        const updateCard = cardImageUrl => {
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

                playerCard.setColor(document.getElementById('selectedColor').value);
                playerCard.setPosition(document.getElementById('position').value);
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

        updateVisualization();
    });
</script>