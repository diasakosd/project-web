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
        iconUrl: 'icons8-marker-r-50-1.png', // Change this to the path of your rescuer icon
        iconSize: [60, 60]
    });

    const baseIcon = L.icon({
        iconUrl: 'house.png',
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

});