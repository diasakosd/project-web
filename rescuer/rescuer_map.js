$(document).ready(function(){
    const map = L.map('rescuer_map');
    map.setView([38.2468, 21.7352], 16);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 39,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
    map.zoomControl.setPosition('topright');
    map.attributionControl.setPrefix('');

    // Define a custom icon for the rescuer
    const rescuerIcon = L.icon({
        iconUrl: 'rescuer_icon.svg', // Change this to the path of your rescuer icon
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

    $.ajax({
        url: 'location_resc.php',
        method: 'GET',
        success: function(response) {
            console.log("Rescuer response received", response);
            try {
                var cargoData = JSON.parse(response);
                console.log("Parsed rescuer data:", cargoData);
    
                // Loop through the data and create markers for rescuers
                for (let key in cargoData) {
                    const rescuer = cargoData[key];
                    const lat = parseFloat(rescuer.latitude);
                    const lon = parseFloat(rescuer.longitude);
    
                    L.marker([lat, lon], {
                        title: 'Rescuer',
                        icon: rescuerIcon
                    }).bindPopup("<h2>You</h2><p>Location: " + lat + ', ' + lon + "</p>")
                    .addTo(map);
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

// AJAX for Offers(yes) and Offers(no)
$.ajax({
    url: 'offers_and_requests.php',
    method: 'GET',
    success: function(response) {
        console.log("Offers response received", response);
        try {
            var combinedData = JSON.parse(response);

            console.log("Parsed combined data:", combinedData);

            // Function to add a marker to the map if it doesn't already exist
            function addMarkerIfNotExists(lat, lon, icon, coordinatesSet) {
                const coordinates = lat + ',' + lon;
                if (!coordinatesSet.has(coordinates)) {
                    coordinatesSet.add(coordinates);
                    L.marker([lat, lon], {
                        title: 'Offer',
                        icon: icon
                    }).bindPopup("<h2>Offer</h2><p>Location: " + lat + ', ' + lon + "</p>")
                    .addTo(map);
                }
            }

            // Sets for unique coordinates
            const uniqueCoordinatesYes = new Set();
            const uniqueCoordinatesNo = new Set();

            // Loop through the data and create markers for Offers(yes)
            for (let key in combinedData.offersYes) {
                const offers_y = combinedData.offersYes[key];
                const lat = parseFloat(offers_y.latitude);
                const lon = parseFloat(offers_y.longitude);

                addMarkerIfNotExists(lat, lon, offerYesIcon, uniqueCoordinatesYes);
            }

            // Loop through the data and create markers for Offers(no)
            for (let key in combinedData.offersNo) {
                const offers_n = combinedData.offersNo[key];
                const lat = parseFloat(offers_n.latitude);
                const lon = parseFloat(offers_n.longitude);

                addMarkerIfNotExists(lat, lon, offerNoIcon, uniqueCoordinatesNo);
            }

        } catch (error) {
            console.error("Error parsing JSON: ", error);
        }
    },
    error: function(xhr, status, error) {
        console.error("AJAX request error (Offers): ", status, error);
    }
});


});