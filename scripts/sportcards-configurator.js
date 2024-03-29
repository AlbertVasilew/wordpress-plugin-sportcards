document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById("myCanvas");
    const context = canvas.getContext("2d");
    const playerCard = new PlayerCard(canvas, context);
    const priceCalculator = new PriceCalculator();

    const cropperManager = new CropperManager(
        document.getElementById('image-modal'), document.getElementById('cropped-image'));

    jQuery(".mini_cart_item a[data-product_sku='sportcards-customizer-system-product']")
        .parent().find('.quantity').hide();

    jQuery("#SportCardsCustomizerFieldsContainer").on("change", () => updateVisualization());
    jQuery(".CardImage").on("click", event => updateVisualization(jQuery(event.currentTarget).attr("src")));
    jQuery("#image-input").on("change", event => cropperManager.open(event.target.files[0]));

    const customClubLogo = jQuery("#custom_club_logo");
    const customClubLogoLoader = jQuery("#custom_club_logo_loader");

    const setCustomClubRequestLoadingState = (loading = true) => {
        if (loading) {
            customClubLogoLoader.show();
            customClubLogo.prop('disabled', true);
        }
        else {
            customClubLogoLoader.hide();
            customClubLogo.prop('disabled', false);
        }
    }

    const errorMessage = "Възникна проблем с качването на избраното от Вас лого. Пробвайте с друг линк.";

    customClubLogo.on("change", () => {
        const logoUrl = customClubLogo.val();
        playerCard.setCustomClubLogoExternal(logoUrl);

        if (window.location.host !== new URL(logoUrl).host) {
            setCustomClubRequestLoadingState();

            jQuery.ajax({
                url: dependencies.ajax_url,
                type: 'POST',
                dataType: 'JSON',
                data: {
                    action: 'upload_custom_club_logo',
                    logoUrl: logoUrl
                },
                success: response => {
                    setCustomClubRequestLoadingState(false);

                    if (response.data.uploaded_club_logo_url)
                        customClubLogo.val(response.data.uploaded_club_logo_url);
                    else {
                        alert(errorMessage);
                        customClubLogo.val();
                    }

                    updateCard();
                },
                error: () => {
                    setCustomClubRequestLoadingState(false);
                    customClubLogo.val();
                    alert(errorMessage);
                }
            });
        }
    });
    
    const applySelectElementHandler = selector => {
        jQuery(selector).on("click", event => {
            jQuery(selector).removeClass("selected");
            jQuery(event.currentTarget).addClass("selected");
            updateVisualization();
        });
    }

    applySelectElementHandler(".material-option");
    applySelectElementHandler(".size-option");
    
    jQuery("#modal-close").on("click", () => {
        cropperManager.close();
        updateVisualization();
    });

    jQuery("#addToCartBtn").on("click", () => {
        const cardData = playerCard.getCardData();

        if (Object.values(cardData).some(value => value === null || value === "")) {
            alert("Трябва да попълните всички полета");
            return;
        }

        jQuery("#addToCartBtn").prop('disabled', true);
        jQuery("#addToCartBtn").html('Зареждане...');

        jQuery.ajax({
            url: dependencies.ajax_url,
            type: 'POST',
            dataType: 'JSON',
            data: {
                action: 'generate_user_sportcard',
                card_data: cardData,
                price: priceCalculator.getPrice()
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
        const materialValue = jQuery('.material-option.selected').data('value');
        const sizeValue = jQuery('.size-option.selected').data('value');
        const sizes = jQuery('.size-option');
    
        sizes.each(function() {
            const size = jQuery(this);
            const price = priceCalculator.calculatePrice(size.data('value'), materialValue);
            const baseText = size.html().replace(/\s?\([^)]+\)/g, '');
    
            size.html(`${baseText}<p>(${price} ${priceCalculator.getCurrency()})</p>`);
        });
    
        priceCalculator.setPrice(sizeValue, materialValue);
        document.getElementById('PriceContainer__price').innerText = priceCalculator.getPriceWithCurrency();
    };

    const position = jQuery("#position");
    let lastPosition;

    const updateStats = () => {
        if (lastPosition == position.val())
            return;

        lastPosition = position.val();

        const skillsContainer = jQuery("#skills-inputs-container");
        skillsContainer.empty();

        const goalKeeperStats = ['div', 'han', 'kic', 'ref', 'spe', 'pos'];
        const nonGoalKeeperStats = ['pac', 'sho', 'pas', 'dri', 'def', 'phy'];
        const statsArray = position.val() == 'GK' ? goalKeeperStats : nonGoalKeeperStats;

        statsArray.forEach((stat, index) => {
            if (index % 3 === 0) {
                const statInputsContainer = jQuery('<div>').addClass('stat-inputs-container');
                skillsContainer.append(statInputsContainer);
            }
    
            const statContainer = jQuery('<div>').addClass('stat-input-container');
            const label = jQuery('<label>').text(stat.toUpperCase());

            const input = jQuery('<input>')
                .attr({type: 'number', min: 0, max: 99, id: stat, value: 99})
                .addClass('stat-input');

            statContainer.append(label, input);
            skillsContainer.find('.stat-inputs-container:last').append(statContainer);
        });
    };

    const updateVisualization = cardImageUrl => {
        updateStats();
        updateCard(cardImageUrl);
        updatePrice();
    }

    const updateCard = cardImageUrl => {
        context.clearRect(0, 0, canvas.width, canvas.height);
        const cardImage = playerCard.getCardImage();

        if (cardImage.src)
            playerCard.setCardImage(cardImageUrl ?? cardImage.src);
        else
            playerCard.setCardImage(dependencies.default_card);

        cardImage.onload = () => {
            context.drawImage(cardImage, 0, 0, canvas.width, canvas.height);

            playerCard.setPlayerImage(cropperManager.getImageData());
            playerCard.setCountryFlag(`https://flagcdn.com/h24/${document.getElementById('country').value}.png`);
            playerCard.setMaterial(jQuery('.material-option.selected').data('text'));
            playerCard.setSize(jQuery('.size-option.selected').data('text'));
            playerCard.setColor(document.getElementById('selectedColor').value);
            playerCard.setPosition(document.getElementById('position').value);
            playerCard.setRating(document.getElementById('rating').value);
            playerCard.setName(document.getElementById('name').value);

            const customClubLogo = jQuery('#custom_club_logo').val();
            playerCard.setClubLogo(customClubLogo ? customClubLogo : jQuery('#club').val());

            if (position.val() == "GK") {
                playerCard.setDiv(document.getElementById('div').value);
                playerCard.setHan(document.getElementById('han').value);
                playerCard.setKic(document.getElementById('kic').value);
                playerCard.setRef(document.getElementById('ref').value);
                playerCard.setSpe(document.getElementById('spe').value);
                playerCard.setPos(document.getElementById('pos').value);
            }
            else {
                playerCard.setPac(document.getElementById('pac').value);
                playerCard.setSho(document.getElementById('sho').value);
                playerCard.setPas(document.getElementById('pas').value);
                playerCard.setDri(document.getElementById('dri').value);
                playerCard.setDef(document.getElementById('def').value);
                playerCard.setPhy(document.getElementById('phy').value);
            }
        }
    }

    updateVisualization();
});