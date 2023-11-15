var map = L.map('map');
map.setView([38.2521, 21.7591], 13);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

var popup = L.popup();

map.on('click', function (e) {
    var clickedLatitude = e.latlng.lat;
    var clickedLongitude = e.latlng.lng;

    popup
        .setLatLng(e.latlng)
        .setContent("You clicked the map at " + e.latlng.toString())
        .openOn(map);

    // Set the latitude and longitude in hidden form fields
    document.getElementById('clickedLatitude').value = clickedLatitude;
    document.getElementById('clickedLongitude').value = clickedLongitude;
});

// Add a function to validate the form before submission
function validateForm() {
    // Check if latitude and longitude are set
    var clickedLatitude = document.getElementById('clickedLatitude').value;
    var clickedLongitude = document.getElementById('clickedLongitude').value;

    if (!clickedLatitude || !clickedLongitude) {
        alert("You need to select a location on the map.");
        return false;
    }

    // The form is valid, allow submission
    return true;
}
