document.addEventListener('DOMContentLoaded', function () {
    var canvas = document.getElementById("myCanvas");
    var context = canvas.getContext("2d");
    var playerCard = new PlayerCard(context, "black");
    var priceCalculator = new PriceCalculator();

    document.getElementById("SportCardsCustomizerFieldsContainer")
        .addEventListener("change", event => updateVisualization());

    document.querySelectorAll(".CardImage").forEach(thumbnail =>
        thumbnail.addEventListener('click', () => updateVisualization(thumbnail.src)));


    let cropper;

    function openModal() {
        document.getElementById('image-modal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('image-modal').style.display = 'none';
    }

    function handleImageSelection(e) {
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function (readerEvent) {
                const uploadedImage = document.getElementById('uploaded-image');
                uploadedImage.src = readerEvent.target.result;

                // Enable the crop button
                document.getElementById('crop-button').disabled = false;

                // Initialize Cropper
                cropper = new Cropper(uploadedImage, {
                    aspectRatio: 1, // Set the aspect ratio as needed
                    viewMode: 1,    // Set the view mode (0, 1, 2, 3)
                });

                openModal(); // Open the modal when an image is uploaded
            };

            reader.readAsDataURL(file);
        }
    }

    document.getElementById('image-input').addEventListener('change', handleImageSelection);

    document.getElementById('crop-button').addEventListener('click', function () {
        const croppedDataURL = cropper.getCroppedCanvas().toDataURL('image/jpeg');
        const playerImage = new Image();
        
        playerImage.src = croppedDataURL;

        playerImage.onload = () => {
            context.drawImage(playerImage, 165, 90, 180, 180);
        }

        // Close the modal after cropping
        closeModal();
    });

    document.getElementById('image-input').addEventListener('change', handleImageSelection);

    document.getElementById('image-input').addEventListener('change', function (e) {
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function (readerEvent) {
                const uploadedImage = document.getElementById('uploaded-image');
                uploadedImage.src = readerEvent.target.result;

                // Enable the crop button
                document.getElementById('crop-button').disabled = false;

                // Initialize Cropper
                const cropper = new Cropper(uploadedImage, {
                    aspectRatio: 1, // Set the aspect ratio as needed
                    viewMode: 1,    // Set the view mode (0, 1, 2, 3)
                });

                // Handle crop button click
                document.getElementById('crop-button').addEventListener('click', function () {
                    // Get the cropped dataURL
                    const croppedDataURL = cropper.getCroppedCanvas().toDataURL('image/jpeg');
                    const playerImage = new Image();
                    playerImage.src = croppedDataURL;

                    playerImage.onload = () => {
                        context.drawImage(playerImage, 165, 90, 180, 180);
                    }
                });
            };

            reader.readAsDataURL(file);
        }
    });

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
            cardImageUrl : php_vars.cards + `card-design-1.png`;

        cardImage.onload = () => {
            context.drawImage(cardImage, 0, 0, canvas.width, canvas.height);

            playerCard.setClubLogo(php_vars.clubs +
                `${document.getElementById('club').value}.png`);

            playerCard.setCountryFlag(php_vars.countries +
                `${document.getElementById('country').value}.png`);

            playerCard.setMaterial(document.getElementById('material').value);
            playerCard.setSize(document.getElementById('size').value);
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

    jQuery("#addToCartBtn").on("click", () => {
        jQuery.ajax({
            url: php_vars.ajax_url,
            type: 'POST',
            dataType: 'JSON',
            data: { action: 'add_to_cart', card_data: playerCard.getCardData() },
            success: function(response) {
                window.location.href = response.redirect_url;
            }
        });
    })
});