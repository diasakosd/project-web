// Define a function to handle the button click


function handleOfferButton() {
    alert('Offer received!');
    const accepted = 'YES';

    $.ajax({
        url: 'offers_and_requests.php', 
        method: 'GET',
        success: function(response) {
            try {
                combinedData = JSON.parse(response); let offer_id;
                
                for (let key in combinedData.offersNo) {
                    const offers_n = combinedData.offersNo[key];
                    offer_id = parseInt(offers_n.id);
                }
                console.log("Citizen Offer ID:", offer_id);

                // Make the second AJAX request inside the success callback
                $.ajax({
                    url: 'popupButtons.php', 
                    method: 'POST',
                    data: { AcceptedOffer: accepted, offerID: offer_id, action_type: 'offer' },
                    success: function(response) {
                        console.log('Rescuer received offer successfully:', response);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX request error (updateRescuerPosition):', status, error);
                    }
                });
            } catch (error) {
                console.error("Error parsing JSON: ", error);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX request error: ", status, error);
        }
    });
}


function handleRequestButton() {
    alert('Request taken!');
    const accepted = 'YES';

    $.ajax({
        url: 'offers_and_requests.php', 
        method: 'GET',
        success: function(response) {
            try {
                combinedData = JSON.parse(response); 
                let request_id;

                for (let key in combinedData.requestsNo) {
                    const requests_n = combinedData.requestsNo[key];
                    request_id = parseInt(requests_n.id);
                }
                console.log("Citizen Request ID:", request_id);

                $.ajax({
                    url: 'popupButtons.php', 
                    method: 'POST',
                    data: { AcceptedRequest: accepted, requestID: request_id, action_type: 'request' },
                    success: function(response) {
                        console.log('Rescuer took request successfully:', response);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX request error (updateRescuerPosition):', status, error);
                    }
                });
            } catch (error) {
                console.error("Error parsing JSON: ", error);
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX request error: ", status, error);
        }
    });
}

