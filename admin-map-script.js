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
        var markers_rescuer_request = [];
        for (var i = 0; i < markers_rescuer_request_Data.length; i++) {
            var marker_rescuer_request = eval(markers_rescuer_request_Data[i]);
            markers_rescuer_request.push(marker_rescuer_request);
        }

        var rescuers_request = L.layerGroup(markers_rescuer_request);


        // Use markersData variable for creating markers
        var markers_rescuer_offer = [];
        for (var i = 0; i < markers_rescuer_offer_Data.length; i++) {
            var marker_rescuer_offer = eval(markers_rescuer_offer_Data[i]);
            markers_rescuer_offer.push(marker_rescuer_offer);
        }

        var rescuers_offer = L.layerGroup(markers_rescuer_offer);

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


        
        
        var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        });

        var map = L.map('map', {
            center: [38.2521, 21.7591],
            zoom: 13,
            layers: [osm, rescuers_request]
        });

        var overlayMaps = {
            "Rescuers Active": rescuers_request
        };

        var baseMaps = {
            "OpenStreetMap": osm
        };

        var layerControl = L.control.layers(baseMaps, overlayMaps).addTo(map);
    
    
        layerControl.addOverlay(rescuers_offer, "Rescuers Non-Active");
        layerControl.addOverlay(requests_no, "Requests Pending");
        layerControl.addOverlay(offers_no, "Offers Pending");
        layerControl.addOverlay(requests_yes, "Requests Accepted");
        layerControl.addOverlay(offers_yes, "Offers Accepted");

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
