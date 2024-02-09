function handleOfferButton(id) {
    const accepted = 'YES';

    try {
        $.ajax({
            url: 'popupButtons.php',
            method: 'POST',
            data: { AcceptedOffer: accepted, offerID: id, action_type: 'offer' },
            success: function (response) {
                var jsonResponse = JSON.parse(response);
                if (jsonResponse.error) {
                    alert('Error completing offer: ' + jsonResponse.error);
                } else {
                    alert('Offer received!');
                    console.log('Rescuer received offer successfully:', response);
                    location.reload();
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX request error (handleOfferButton):', status, error);
                alert('Error completing offer: ' + error.responseText); // Show an alert with the error message
            }
        });
    } catch (error) {
        console.error("Error parsing JSON: ", error);
        alert('Error completing offer: ' + error.responseText); // Show an alert with the error message
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
                var jsonResponse = JSON.parse(response);
                if (jsonResponse.error) {
                    alert('Error completing request: ' + jsonResponse.error);
                } else {
                    alert('Request taken!');
                    console.log('Rescuer took request successfully:', response);
                    location.reload();
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX request error (handleRequestButton):', status, error);
                alert('Error completing request: ' + error.responseText); // Show an alert with the error message
            }
        });
    } catch (error) {
        console.error("Error parsing JSON: ", error);
        alert('Error completing request: ' + error.responseText); // Show an alert with the error message
    }
}
