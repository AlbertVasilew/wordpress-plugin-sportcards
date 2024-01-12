document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById("myCanvas");
    const context = canvas.getContext("2d");
    const playerCard = new PlayerCard(canvas, context, "black");
    const priceCalculator = new PriceCalculator();

    const cropperManager = new CropperManager(
        document.getElementById('image-modal'), document.getElementById('cropped-image'), context);

    jQuery("#SportCardsCustomizerFieldsContainer").on("change", () => updateVisualization());
    jQuery(".CardImage").on("click", event => updateVisualization(jQuery(event.currentTarget).attr("src")));
    jQuery("#image-input").on("change", event => cropperManager.open(event.target.files[0]));
    jQuery("#modal-close").on("click", () => cropperManager.close());

    jQuery("#addToCartBtn").on("click", () => {
        jQuery.ajax({
            url: dependencies.ajax_url,
            type: 'POST',
            dataType: 'JSON',
            data: {
                action: 'generate_user_sportcard',
                card_data: playerCard.getCardData(),
                image_data: cropperManager.getImageData()
            },
            success: response => window.location.href = response.redirect_url
        });
    });

    const countrySelect = jQuery("#country");

    fetch("https://flagcdn.com/en/codes.json").then(response => response.json()).then(countries => {
        for (let key in countries)
            countrySelect.append(`<option value="${key}">${countries[key]}</option>`)
    });

    const updatePrice = () => {
        const material = document.getElementById('material');
        const size = document.getElementById('size');
        const sizes = Array.from(size.options);

        sizes.forEach(size => {
            const price = priceCalculator.calculatePrice(size.value, material.value);
            const baseText = size.text.replace(/\s?\([^)]+\)/g, '');
            size.text = `${baseText} (${price} ${priceCalculator.getCurrency()})`;
        });

        priceCalculator.setPrice(size.value, material.value);
        document.getElementById('PriceContainer__price').innerText = priceCalculator.getPrice();
    };

    const updateVisualization = cardImageUrl => {
        updateCard(cardImageUrl);
        updatePrice();
    }

    const updateCard = cardImageUrl => {
        context.clearRect(0, 0, canvas.width, canvas.height);
        const cardImage = playerCard.getCardImage();

        if (cardImage.src)
            playerCard.setCardImage(cardImageUrl ?? cardImage.src);
        else
            playerCard.setCardImage(dependencies.cards + `card-design-1.png`);

        cardImage.onload = () => {
            context.drawImage(cardImage, 0, 0, canvas.width, canvas.height);

            playerCard.setClubLogo(document.getElementById('club').value);
            playerCard.setCountryFlag(`https://flagcdn.com/h24/${document.getElementById('country').value}.png`);
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
});