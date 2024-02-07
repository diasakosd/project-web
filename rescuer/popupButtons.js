function handleOfferButton(id) {
    const accepted = 'YES';

    try {
        $.ajax({
            url: 'popupButtons.php',
            method: 'POST',
            data: { AcceptedOffer: accepted, offerID: id, action_type: 'offer' },
            success: function (response) {
                alert('Offer received!');
                console.log('Rescuer received offer successfully:', response);
                location.reload();
            },
            error: function (xhr, status, error) {
                console.error('AJAX request error (updateRescuerPosition):', status, error);
            }
        });
    } catch (error) {
        console.error("Error parsing JSON: ", error);
    }
}


function handleRequestButton(id) {
    const accepted = 'YES';

    try {
        $.ajax({
            url: 'popupButtons.php',
            method: 'POST',
            data: { AcceptedRequest: accepted, requestID: id, action_type: 'request' },
            success: function (response) {
                alert('Request taken!');
                console.log('Rescuer took request successfully:', response);
                location.reload();
            },
            error: function (xhr, status, error) {
                console.error('AJAX request error (updateRescuerPosition):', status, error);
            }
        });
    } catch (error) {
        console.error("Error parsing JSON: ", error);
    }
}

