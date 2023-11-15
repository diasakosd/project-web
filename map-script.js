var map = L.map('map');
map.setView([51.505, -0.09], 13);

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

    // Store the latitude and longitude in session variables
    sessionStorage.setItem('clickedLatitude', clickedLatitude);
    sessionStorage.setItem('clickedLongitude', clickedLongitude);
});

// Add a function to validate the form before submission
function validateForm() {
    // Check if latitude and longitude are set
    var clickedLatitude = sessionStorage.getItem('clickedLatitude');
    var clickedLongitude = sessionStorage.getItem('clickedLongitude');

    if (!clickedLatitude || !clickedLongitude) {
        alert("You need to select a location on the map.");
        return false;
    }

    // The form is valid, allow submission
    return true;
}
