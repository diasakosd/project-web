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
        success: function(response){
            console.log("Response received", response);
            try {
                var cargoData = JSON.parse(response);
                console.log("Parsed cargoData:", cargoData); // Check parsed cargoData

                // Loop through the data and create markers
                for (let key in cargoData) {
                    const rescuer = cargoData[key];

                    const lat = parseFloat(rescuer.latitude);
                    const lon = parseFloat(rescuer.longitude);

                    L.marker([lat, lon], {
                        title: 'rescuer.title',
                        icon: rescuerIcon
                    })
                    .addTo(map);
                }
            } catch (error) {
                console.error("Error parsing JSON: ", error);
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX request error: ", status, error);
        }
    });
});
