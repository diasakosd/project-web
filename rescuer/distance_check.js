$(document).ready(function () {
    let resclat, resclon;
    let baselat, baselon;

    //Distance between two coordinates using Haversine formula
    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371; //Radius of the earth in kilometers
        const dLat = (lat2 - lat1) * (Math.PI / 180);
        const dLon = (lon2 - lon1) * (Math.PI / 180);
        const a =
            Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(lat1 * (Math.PI / 180)) * Math.cos(lat2 * (Math.PI / 180)) * Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        const distance = R * c; //Distance in kilometers
        const distanceInMeters = distance * 1000; //Convert distance to meters
        return distanceInMeters;
    }

    function showHideLoadButton() {
        console.log('Rescuer Latitude:', resclat);
        console.log('Rescuer Longitude:', resclon);
        console.log('Base Latitude:', baselat);
        console.log('Base Longitude:', baselon);

        if (resclat && resclon && baselat && baselon) {
            const distance = calculateDistance(resclat, resclon, baselat, baselon);
            console.log('Calculated Distance:', distance);

            if (distance > 100) {
                $('.cargo').hide();
            } else {
                $('.cargo').show();
            }
        }
    }

    $.ajax({
        url: 'get_base_coords.php',
        method: 'GET',
        success: function (response) {
            try {
                var baseCoords = JSON.parse(response);
                baselat = baseCoords.latitude;
                baselon = baseCoords.longitude;
                showHideLoadButton();
            } catch (error) {
                console.error("Error parsing JSON: ", error);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX request error (Base Coords): ", status, error);
        }
    });

$.ajax({
    url: 'get_rescuer_coords.php',
    method: 'GET',
    success: function (response) {
        try {
            var rescuerCoordsArray = JSON.parse(response);

            if (rescuerCoordsArray.length > 0) {

                var rescuerCoords = rescuerCoordsArray[0];

                resclat = rescuerCoords.latitude;
                resclon = rescuerCoords.longitude;

                showHideLoadButton();
            } else {
                console.error('No rescuer coordinates found in the array.');
            }
        } catch (error) {
            console.error("Error parsing JSON (Rescuer Coords): ", error);
        }
    },
    error: function (xhr, status, error) {
        console.error("AJAX request error (Rescuer Coords): ", status, error);
    }
});

});
