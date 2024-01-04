const map = L.map('rescuer_map');
map.setView([38.2468, 21.7352], 16);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 39,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);
map.zoomControl.setPosition('topright');map.attributionControl.setPrefix('');

const baseIcon = L.icon({
    iconUrl: 'house.png',
    iconSize: [60,60]
});

L.marker([38.2468, 21.7352],{
    title: "Base",
    icon: baseIcon
}).bindPopup('<h2>Base</h2><p>This is our Base.<br>Location: 38.2468, 21.7352</p>')
.addTo(map);

    // AJAX call to fetch marker data from the server
    fetch('location_resc.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(location => {
                L.marker([location.latitude, location.longitude]).addTo(map)
                    .bindPopup(`<p>Location: ${location.latitude}, ${location.longitude}</p>`);
            });
        })
        .catch(error => {
            console.error('Error fetching marker data:', error);
        });