var LeafIcon = L.Icon.extend({
    options: {
        shadowUrl: 'marker-shadow.png',
        iconSize: [38, 42],
        shadowSize: [41, 41],
        iconAnchor: [19, 42],  // Adjusted icon anchor
        shadowAnchor: [4, 41], // Adjusted shadow anchor
        popupAnchor: [0, -42]  // Adjusted popup anchor
    }
});




var offers_noIcon = new LeafIcon({iconUrl: 'icons8-marker-o-50-1.png'}),
offers_yesIcon = new LeafIcon({iconUrl: 'icons8-marker-o-50.png'}),
requests_yesIcon = new LeafIcon({iconUrl: 'icons8-marker-r-50-1.png'}),
requests_noIcon = new LeafIcon({iconUrl: 'icons8-marker-r-50.png'});


var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
        // Include the markers directly as JavaScript code
        eval(xhr.responseText);





        // Use markersData variable for creating markers
        var markers_rescuer_active = [];
        for (var i = 0; i < markers_rescuer_active_Data.length; i++) {
            var marker_rescuer_active = eval(markers_rescuer_active_Data[i]);
            markers_rescuer_active.push(marker_rescuer_active);
        }

        var rescuers_active = L.layerGroup(markers_rescuer_active);


        // Use markersData variable for creating markers
        var markers_rescuer_noactive = [];
        for (var i = 0; i < markers_rescuer_noactive_Data.length; i++) {
            var marker_rescuer_noactive = eval(markers_rescuer_noactive_Data[i]);
            markers_rescuer_noactive.push(marker_rescuer_noactive);
        }

        var rescuers_noactive = L.layerGroup(markers_rescuer_noactive);

        // Use markersData variable for creating markers
        var markers_citizen_request_no = [];
        for (var i = 0; i < markers_citizen_request_Data_no.length; i++) {
            var marker_citizen_request_no = eval(markers_citizen_request_Data_no[i]);
            markers_citizen_request_no.push(marker_citizen_request_no);
        }        
        
        var requests_no = L.layerGroup(markers_citizen_request_no);


        // Use markersData variable for creating markers
        var markers_citizen_offer_no = [];
        for (var i = 0; i < markers_citizen_offer_Data_no.length; i++) {
            var marker_citizen_offer_no = eval(markers_citizen_offer_Data_no[i]);
            markers_citizen_offer_no.push(marker_citizen_offer_no);
        }        
        
        var offers_no = L.layerGroup(markers_citizen_offer_no);


        // Use markersData variable for creating markers
        var markers_citizen_request_yes = [];
        for (var i = 0; i < markers_citizen_request_Data_yes.length; i++) {
            var marker_citizen_request_yes = eval(markers_citizen_request_Data_yes[i]);
            markers_citizen_request_yes.push(marker_citizen_request_yes);
        }        
        
        var requests_yes = L.layerGroup(markers_citizen_request_yes);


        // Use markersData variable for creating markers
        var markers_citizen_offer_yes = [];
        for (var i = 0; i < markers_citizen_offer_Data_yes.length; i++) {
            var marker_citizen_offer_yes = eval(markers_citizen_offer_Data_yes[i]);
            markers_citizen_offer_yes.push(marker_citizen_offer_yes);
        }        
        
        var offers_yes = L.layerGroup(markers_citizen_offer_yes);



        var lines_request_yes = [];
        for (var i = 0; i < lines_request_yes_Data.length; i++) {
            var line_request_yes = eval(lines_request_yes_Data[i]);
            lines_request_yes.push(line_request_yes);
        }
        
        // Create a layer group for all the polylines and add it to the map
        var lines_request_group = L.layerGroup(lines_request_yes);



            var lines_offer_yes = [];
            for (var i = 0; i < lines_offer_yes_Data.length; i++) {
                var line_offer_yes = eval(lines_offer_yes_Data[i]);
                lines_offer_yes.push(line_offer_yes);
            }
            
            // Create a layer group for all the polylines and add it to the map
            var lines_offer_group = L.layerGroup(lines_offer_yes);

            
        
        
        var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        });

        var map = L.map('map', {
            center: [38.2521, 21.7591],
            zoom: 13,
            layers: [osm]
        });

        var overlayMaps = {
            
        };

        var baseMaps = {
            "OpenStreetMap": osm
        };


                  // Assuming you have a Leaflet map object named 'map'
var baseIcon = L.icon({
    iconUrl: 'house.png',
    iconSize: [50, 50],
    iconAnchor: [25, 25],
    shadowUrl: 'marker-shadow.png',
    shadowSize: [41, 41],
    shadowAnchor: [20.5, 25],
    popupAnchor: [0, -25],
});

        var baseMarker = L.marker([baseLocation.lat, baseLocation.lng], { icon: baseIcon, draggable: 'true' }).addTo(map);

        // Set the initial popup content
        baseMarker.bindPopup('Base Location at: ' + baseLocation.lat + ', ' + baseLocation.lng).openPopup();

        baseMarker.on('dragend', function (event) {
            var marker = event.target;
            var position = marker.getLatLng();

            // Update the marker's position in the popup content
            marker.setPopupContent('Base Location at: ' + position.lat + ', ' + position.lng);

            // Send the new location to the server using AJAX
            updateBaseLocation(position.lat, position.lng);
        });

        function updateBaseLocation(latitude, longitude) {
            // Create an XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            // Define the PHP script URL
            var url = 'update_location.php';

            // Create the data to be sent in the request
            var data = 'latitude=' + latitude + '&longitude=' + longitude;

            // Configure the request
            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            // Set up the callback function to handle the response
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Handle the response (if needed)
                    console.log(xhr.responseText);
                }
            };

            // Send the request with the data
            xhr.send(data);
        }



        var layerControl = L.control.layers(baseMaps, overlayMaps).addTo(map);
        
       

        layerControl.addOverlay(rescuers_active, "Rescuers Active");
        layerControl.addOverlay(rescuers_noactive, "Rescuers Non-Active");
        layerControl.addOverlay(requests_no, "Requests Pending");
        layerControl.addOverlay(offers_no, "Offers Pending");
       layerControl.addOverlay(requests_yes, "Requests Accepted");
       layerControl.addOverlay(offers_yes, "Offers Accepted");
     
       // Create an overlay map for the line

       layerControl.addOverlay(lines_offer_group, "Lines - Offers");
       layerControl.addOverlay(lines_request_group, "Lines - Requests");

        var openTopoMap = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: 'Map data: © OpenStreetMap contributors, SRTM | Map style: © OpenTopoMap (CC-BY-SA)'
        });
    }
    
};

// Open the AJAX request
xhr.open("GET", "markers_admin.php", true);
// Send the request
xhr.send();
