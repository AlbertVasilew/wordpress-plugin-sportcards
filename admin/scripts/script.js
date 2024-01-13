jQuery(document).ready(() => {
    jQuery('.ItemContainer__item-delete').click(function () {
        if (confirm('Are you sure you want to delete this record?')) {
            const clubId = jQuery(this).data('club-id');
            const cardId = jQuery(this).data('card-id');
            const type = cardId ? "card" : "club";

            jQuery.ajax({
                url: ajaxurl,
                type: 'POST',
                dataType: 'JSON',
                data: {
                    action: type == 'card' ? 'delete_card' : 'delete_club',
                    id: type === 'card' ? cardId : clubId
                },
                success: () => location.reload()
            });
        }
    });

    jQuery('#saveClub').on('click', () => {
        const clubName = jQuery('#clubName').val();
        const clubImage = jQuery('#clubImage').prop('files')[0];

        if (!clubName || !clubImage) {
            alert('Please enter club name and select an image.');
            return;
        }
    
        var formData = new FormData();
        formData.append('action', 'save_club');
        formData.append('clubName', clubName);
        formData.append('clubImage', clubImage);
    
        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: () => location.reload()
        });
    })

    jQuery('#saveCard').on('click', () => {
        const cardImages = jQuery('#cardImages').prop('files');

        if (cardImages?.length === 0) {
            alert('Please select one or more images.');
            return;
        }
    
        var formData = new FormData();
        formData.append('action', 'save_card');
        
        for (let i = 0; i < cardImages.length; i++)
            formData.append('cardImages[]', cardImages[i]);
    
        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: () => location.reload()
        });
    });

    var modal = document.getElementById('clubModal');
    var addNewClubBtn = document.getElementById('addNewClubBtn');

    var cardModal = jQuery('#cardModal');
    jQuery('#addNewCardBtn').on('click', () => cardModal.css('display', 'block'));
    
    addNewClubBtn.onclick = function () {
        modal.style.display = 'block';
    };
    
    window.onclick = function (event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
        if (event.target === cardModal) {
            cardModal.css('display', 'none');
        }
    };
});

