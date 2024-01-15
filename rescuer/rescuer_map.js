const map = L.map('rescuer_map');
map.setView([38.2468, 21.7352], 16);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 39,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);
map.zoomControl.setPosition('topright');map.attributionControl.setPrefix('');


// Define a custom icon for the rescuer
const rescuerIcon = L.icon({
    iconUrl: 'icons8-marker-r-50-1.png', // Change this to the path of your rescuer icon
    iconSize: [60, 60]
});

const baseIcon = L.icon({
    iconUrl: 'house.png',
    iconSize: [60,60]
});


const data = {
    base: {
        coords: [38.2468, 21.7352],
        title: "Base",
        icon: baseIcon,
        bindPopup: "<h2>Base</h2><p>This is our Base.<br>Location: 38.2468, 21.7352</p>"
    },
    resquer1: {
        coords: [38.2631, 21.7442],
        title: "resquer1",
        icon: rescuerIcon,
        bindPopup: "<h2>resquer1</h2><p>Location: 38.2631, 21.7442</p>"
    },
    resquer2: {
        coords: [38.2418, 21.7311],
        title: "resquer2",
        icon: rescuerIcon,
        bindPopup: "<h2>resquer2</h2><p>Location: 38.2418, 21.7311</p>"
    },
    rescuer3: {
        coords: [38.2568, 21.7417],
        title: "rescuer3",
        icon: rescuerIcon,
        bindPopup: "<h2>rescuer3</h2><p>Location: 38.2568, 21.7417</p>"
    },
    rescuer4: {
        coords: [38.2479, 21.7406],
        title: "rescuer4",
        icon: rescuerIcon,
        bindPopup: "<h2>rescuer4</h2><p>Location: 38.2479, 21.7406</p>"
    } 
}

for (let key in data){
    const rescuer = data[key];
    
    L.marker(rescuer.coords,{
        title: rescuer.title,
        icon: rescuer.icon
    }).bindPopup(rescuer.bindPopup)
    .addTo(map);
}



