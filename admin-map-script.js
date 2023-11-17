var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
        // Include the markers directly as JavaScript code
        eval(xhr.responseText);

        // Use markersData variable for creating markers
        var markers_rescuer = [];
        for (var i = 0; i < markers_rescuer_Data.length; i++) {
            var marker_rescuer = eval(markers_rescuer_Data[i]);
            markers_rescuer.push(marker_rescuer);
        }

        var rescuers = L.layerGroup(markers_rescuer);

        var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        });

        var map = L.map('map', {
            center: [38.2521, 21.7591],
            zoom: 13,
            layers: [osm, rescuers]
        });

        var overlayMaps = {
            "Rescuers": rescuers
        };

        var baseMaps = {
            "OpenStreetMap": osm
        };

        var layerControl = L.control.layers(baseMaps, overlayMaps).addTo(map);

        var openTopoMap = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: 'Map data: © OpenStreetMap contributors, SRTM | Map style: © OpenTopoMap (CC-BY-SA)'
        });
    }
};

// Open the AJAX request
xhr.open("GET", "markers.php", true);
// Send the request
xhr.send();
