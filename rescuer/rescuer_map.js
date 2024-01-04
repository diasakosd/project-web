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