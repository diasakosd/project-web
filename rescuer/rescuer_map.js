// Define a function to handle the button click
function handleOfferButton() {
    alert('Offer received!');
}

function handleRequestButton() {
    alert('Request taken!');
}

$(document).ready(function(){
    const map = L.map('rescuer_map');
    map.setView([38.2468, 21.7352], 12);

    var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 39,
        attribution: '© OpenStreetMap'
    }).addTo(map);
    map.zoomControl.setPosition('topright');
    map.attributionControl.setPrefix('');

    var baseMaps = {
        "OpenStreetMap": osm
    };


    // Create layer groups for OfferYes, OfferNo, RequestYes, and RequestNo
const offerYesGroup = L.layerGroup().addTo(map);
const offerNoGroup = L.layerGroup().addTo(map);
const requestYesGroup = L.layerGroup().addTo(map);
const requestNoGroup = L.layerGroup().addTo(map);
// Create an object to hold your overlays
    const overlays = {
        "Offer Yes": offerYesGroup,
        "Offer No": offerNoGroup,
        "Request Yes": requestYesGroup,
        "Request No": requestNoGroup
    };

    // Define a custom icon for the rescuer
    const rescuerIcon = L.icon({
        iconUrl: 'rescuer_icon.svg', // Change this to the path of your rescuer icon
        iconSize: [60, 60]
    });

    const otherRescuerIcon = L.icon({
        iconUrl: 'rescuer_icon-green.svg', // Change this to the path of your rescuer icon
        iconSize: [60, 60]
    });

    const baseIcon = L.icon({
        iconUrl: 'house.png',
        iconSize: [60, 60]
    });

    const offerYesIcon = L.icon({
        iconUrl: 'offer_taken.svg',
        iconSize: [60, 60]
    });

    const offerNoIcon = L.icon({
        iconUrl: 'offer_waiting.svg',
        iconSize: [60, 60]
    });

    const requestsYesIcon = L.icon({
        iconUrl: 'request_taken.svg',
        iconSize: [60, 60]
    });

    const requestsNoIcon = L.icon({
        iconUrl: 'request_waiting.svg',
        iconSize: [60, 60]
    });

    let rescuerCoordinates = [];
    let rescuerMarker;

    $.ajax({
        url: 'location_resc.php',
        method: 'GET',
        success: function(response) {
            console.log("Rescuer response received", response);
            try {
                var combinedRescuers = JSON.parse(response);
                console.log("Parsed rescuer data:", combinedRescuers);
    
                // Loop through the data and create markers for rescuers
                for (let key in combinedRescuers.currResc) {
                    const rescuer = combinedRescuers.currResc[key];
                    const lat = parseFloat(rescuer.latitude);
                    const lon = parseFloat(rescuer.longitude);
                    rescuerCoordinates.push([lat, lon]);
    
                    rescuerMarker = L.marker([lat, lon], {
                        title: 'Rescuer',
                        icon: rescuerIcon,
                        draggable: true
                    }).bindPopup("<h2>You</h2><p>Location: " + lat + ', ' + lon + "</p>")
                    .addTo(map);
                }

                // Loop through the data and create markers for other rescuers
                for (let key in combinedRescuers.otherResc) {
                    const rescuer2 = combinedRescuers.otherResc[key];
                    const lat = parseFloat(rescuer2.latitude);
                    const lon = parseFloat(rescuer2.longitude);
    
                    L.marker([lat, lon], {
                        title: 'Rescuer',
                        icon: otherRescuerIcon
                    }).bindPopup("<h2>Other</h2><p>Location: " + lat + ', ' + lon + "</p>")
                    .addTo(map);
                }

                // Bind the dragend event to update the rescuer's position
                rescuerMarker.on('dragend', function (event) {
                    const newLatLng = event.target.getLatLng();
                    const newLat = newLatLng.lat;
                    const newLng = newLatLng.lng;

                    // Update rescuer's position in the database using AJAX
                    updateRescuerPosition(newLat, newLng);
                });

                // Function to update rescuer's position in the database
                function updateRescuerPosition(lat, lon) {
                    // Send the new position to the server using AJAX
                    $.ajax({
                        url: 'upd_resc_pos.php', 
                        method: 'POST',
                        data: { latitude: lat, longitude: lon },
                        success: function(response) {
                            console.log('Rescuer position updated successfully:', response);
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX request error (updateRescuerPosition):', status, error);
                        }
                    });
                }

                //test markers for requests
                var marker = L.marker([38.2466, 21.7346]).bindPopup("<h3>Request waiting demo</h3>").addTo(map);
                marker.setIcon(L.icon({
                    iconUrl: 'request_waiting.svg',
                    iconSize: [60, 60],
                }));

                var marker = L.marker([38.2461, 21.73525]).bindPopup("<h3>Request taken demo</h3>").addTo(map);
                marker.setIcon(L.icon({
                    iconUrl: 'request_taken.svg',
                    iconSize: [60, 60]
                }));

                //test markers for offers
                var marker = L.marker([38.24614, 21.73615]).bindPopup("<h3>Offer waiting demo</h3>").addTo(map);
                marker.setIcon(L.icon({
                    iconUrl: 'offer_waiting.svg',
                    iconSize: [60, 60]
                }));

                var marker = L.marker([38.24655, 21.73582]).bindPopup("<h3>Offer taken demo</h3>").addTo(map);
                marker.setIcon(L.icon({
                    iconUrl: 'offer_taken.svg',
                    iconSize: [60, 60]
                }));
            } catch (error) {
                console.error("Error parsing JSON: ", error);
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX request error (rescuers): ", status, error);
        }
    });

    $.ajax({
        url: 'base_map.php',
        method: 'GET',
        success: function(response2) {
            console.log("Base response received", response2);
            try {
                var cargoData2 = JSON.parse(response2);
                console.log("Parsed base coordinates data:", cargoData2);
    
                // Loop through the data and create markers for base coordinates
                for (let key in cargoData2) {
                    const base = cargoData2[key];
                    const lat = parseFloat(base.latitude);
                    const lon = parseFloat(base.longitude);
    
                    L.marker([lat, lon], {
                        title: 'Base',
                        icon: baseIcon
                    }).bindPopup("<h2>Base</h2><p>Location: " + lat + ', ' + lon + "</p>")
                    .addTo(map);
                }
            } catch (error) {
                console.error("Error parsing JSON: ", error);
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX request error (base coordinates): ", status, error);
        }
    });

let ballonDetailsRegT = [];
let ballonDetailsRegW = [];
let ballonDetailsOffT = [];
let ballonDetailsOffW = [];

//AJAX for Offers/Requests(yes) and Offers/Requests(no) details
$.ajax({
    url: 'PopupBalloons.php',
    method: 'GET',
    success: function(response) {
        console.log("Details response received", response);
        try{
            var Details = JSON.parse(response);
            console.log("Parsed details:", Details);

            //req
            for (let key in Details.reqT) {
                const details = Details.reqT[key];
                const fullname = details.full_name;
                const phone = parseFloat(details.phone);
                const Tcreated = details.formatted_time_created;
                const item = details.item;
                const quantity = parseFloat(details.quantity);
                const Taccepted = details.formatted_time_accepted;
                const Rusername = details.rescuer_username;
                ballonDetailsRegT.push([fullname, phone, Tcreated, item, quantity, Taccepted, Rusername]);
            }

            for (let key in Details.reqW) {
                const details = Details.reqW[key];
                const fullname = details.full_name;
                const phone = parseFloat(details.phone);
                const Tcreated = details.formatted_time_created;
                const item = details.item;
                const quantity = parseFloat(details.quantity);
                ballonDetailsRegW.push([fullname, phone, Tcreated, item, quantity]);
            }

            //offers
            for (let key in Details.offT) {
                const details = Details.offT[key];
                const fullname = details.full_name;
                const phone = parseFloat(details.phone);
                const Tcreated = details.formatted_time_created;
                const item = details.item;
                const quantity = parseFloat(details.quantity);
                const Taccepted = details.formatted_time_accepted;
                const Rusername = details.rescuer_username;
                ballonDetailsOffT.push([fullname, phone, Tcreated, item, quantity, Taccepted, Rusername]);
            }

            for (let key in Details.offW) {
                const details = Details.offW[key];
                const fullname = details.full_name;
                const phone = parseFloat(details.phone);
                const Tcreated = details.formatted_time_created;
                const item = details.item;
                const quantity = parseFloat(details.quantity);
                ballonDetailsOffW.push([fullname, phone, Tcreated, item, quantity]);
            }

        } catch (error) {
            console.error("Error parsing JSON: ", error);
        }
    },
    error: function(xhr, status, error) {
        console.error("AJAX request error (Offers): ", status, error);
    }
});



            // Function to add a marker to the map if it doesn't already exist
            function addMarkerIfNotExists(lat, lon, icon, layerGroup, coordinatesSet, type) {
                const coordinates = lat + ',' + lon;
                if (!coordinatesSet.has(coordinates)) {
                    coordinatesSet.add(coordinates);

                    let title, popupContent;
                    if (type === 'offerYes') {
                        const details = ballonDetailsOffT.shift(); // Take the first element
                        title = 'Offer Taken';
                        popupContent = "<h2><b>Offer taken</b></h2><p><b>Citizen name:</b> " + details[0] + "</p>" +
                            "<p><b>Citizen phone:</b> " + details[1] + "</p>" +
                            "<p><b>Time created:</b> " + details[2] + "</p>" +
                            "<p><b>Item:</b> " + details[3] + "</p>" +
                            "<p><b>Quantity:</b> " + details[4] + "</p>" +
                            "<p><b>Time accepted:</b> " + details[5] + "</p>" +
                            "<p><b>Rescuer's username:</b> " + details[6] + "</p>";
                    
                    } else if (type === 'offerNo') {
                        const details = ballonDetailsOffW.shift(); // Take the first element
                        title = 'Offer Waiting';
                        popupContent = "<h2><b>Offer waiting</b></h2><p id='citizenName'><b>Citizen name:</b> " + details[0] + "</p>" +
                        "<p id='citizenPhone'><b>Citizen phone:</b> " + details[1] + "</p>" +
                        "<p id='timeCreated'><b>Time created:</b> " + details[2] + "</p>" +
                        "<p id='item'><b>Item:</b> " + details[3] + "</p>" +
                        "<p id='quantity'><b>Quantity:</b> " + details[4] + "</p>" +
                        "<button onclick='handleOfferButton()'>Receive offer</button>";

                    
                    } else if (type === 'requestYes') {
                        const details = ballonDetailsRegT.shift(); // Take the first element
                        title = 'Request Taken';
                        popupContent = "<h2><b>Request taken</b></h2><p><b>Citizen name:</b> " + details[0] + "</p>" +
                            "<p><b>Citizen phone:</b> " + details[1] + "</p>" +
                            "<p><b>Time created:</b> " + details[2] + "</p>" +
                            "<p><b>Item:</b> " + details[3] + "</p>" +
                            "<p><b>Quantity:</b> " + details[4] + "</p>" +
                            "<p><b>Time accepted:</b> " + details[5] + "</p>" +
                            "<p><b>Rescuer's username:</b> " + details[6] + "</p>";
                    
                    } else if (type === 'requestNo') {
                        const details = ballonDetailsRegW.shift(); // Take the first element
                        title = 'Request Waiting';
                        popupContent = "<h2><b>Request waiting</b></h2><p><b>Citizen name:</b> " + details[0] + "</p>" +
                            "<p><b>Citizen phone:</b> " + details[1] + "</p>" +
                            "<p><b>Time created:</b> " + details[2] + "</p>" +
                            "<p><b>Item:</b> " + details[3] + "</p>" +
                            "<p><b>Quantity:</b> " + details[4] + "</p>"+
                            "<button onclick='handleRequestButton()'>Take Request</button>";
                    }
                    

                    const marker = L.marker([lat, lon], {
                        title: title,
                        icon: icon
                    }).bindPopup(popupContent).addTo(map);

                    
                    // Add the marker to the specified layer group
                    marker.addTo(layerGroup);
                }
            }



            // Sets for unique coordinates
            const uniqueoffYes = new Set();
            const uniqueoffNo = new Set();
            const uniqueReYes = new Set();
            const uniqueReNo = new Set();




            

// AJAX for Offers/Requests(yes) and Offers/Requests(no)
$.ajax({
    url: 'offers_and_requests.php',
    method: 'GET',
    success: function(response) {
        console.log("Offers response received", response);
        try {
            var combinedData = JSON.parse(response);

            console.log("Parsed combined data:", combinedData);



            // Loop through the data and create markers for Offers(yes)
            for (let key in combinedData.offersYes) {
                const offers_y = combinedData.offersYes[key];
                const lat = parseFloat(offers_y.latitude);
                const lon = parseFloat(offers_y.longitude);

                addMarkerIfNotExists(lat, lon, offerYesIcon, offerYesGroup, uniqueoffYes, 'offerYes');

                // Draw a line between each rescuer and the offer
                rescuerCoordinates.forEach(rescuerCoord => {
                    const polyline = L.polyline([rescuerCoord, [lat, lon]], { color: 'green' }).addTo(map);
                });
            }

            // Loop through the data and create markers for Offers(no)
            for (let key in combinedData.offersNo) {
                const offers_n = combinedData.offersNo[key];
                const lat = parseFloat(offers_n.latitude);
                const lon = parseFloat(offers_n.longitude);

                addMarkerIfNotExists(lat, lon, offerNoIcon, offerNoGroup, uniqueoffNo, 'offerNo');
            }

            // Loop through the data and create markers for Requests(yes)
            for (let key in combinedData.requestsYes) {
                const requests_y = combinedData.requestsYes[key];
                const lat = parseFloat(requests_y.latitude);
                const lon = parseFloat(requests_y.longitude);

                addMarkerIfNotExists(lat, lon, requestsYesIcon, requestYesGroup, uniqueReYes, 'requestYes');

                // Draw a line between each rescuer and the offer
                rescuerCoordinates.forEach(rescuerCoord => {
                    const polyline = L.polyline([rescuerCoord, [lat, lon]], { color: 'green' }).addTo(map);
                });

            }

            // Loop through the data and create markers for Requests(no)
            for (let key in combinedData.requestsNo) {
                const requests_n = combinedData.requestsNo[key];
                const lat = parseFloat(requests_n.latitude);
                const lon = parseFloat(requests_n.longitude);

                addMarkerIfNotExists(lat, lon, requestsNoIcon, requestNoGroup, uniqueReNo, 'requestNo');
            }


            var layerControl = L.control.layers(baseMaps, overlayMaps).addTo(map);
            layerControl.addOverlay(offerYesGroup, "Offer Yes");
            layerControl.addOverlay(offerNoGroup, "Offer No");
            layerControl.addOverlay(requestYesGroup, "Request Yes");
            layerControl.addOverlay(requestNoGroup, "Request No");




        } catch (error) {
            console.error("Error parsing JSON: ", error);
        }
    },
    error: function(xhr, status, error) {
        console.error("AJAX request error (Offers): ", status, error);
    }
});

});