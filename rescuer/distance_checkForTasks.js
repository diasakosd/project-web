var tasklat, tasklon, resclat, resclon;

    // Function to calculate the distance between two coordinates using Haversine formula
    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371; // Radius of the Earth in kilometers
        const dLat = (lat2 - lat1) * (Math.PI / 180);
        const dLon = (lon2 - lon1) * (Math.PI / 180);
        const a =
            Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(lat1 * (Math.PI / 180)) * Math.cos(lat2 * (Math.PI / 180)) * Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        const distance = R * c; // Distance in kilometers
        const distanceInMeters = distance * 1000; // Convert distance to meters
        return distanceInMeters;
    }

    function showHideFinishedButton(resclat, resclon, tasklat, tasklon, tableId) {
        console.log('Rescuer Latitude:', resclat);
        console.log('Rescuer Longitude:', resclon);
        console.log('Task Latitude:', tasklat);
        console.log('Task Longitude:', tasklon);

        if (resclat && resclon && tasklat && tasklon) {
            const distance = calculateDistance(resclat, resclon, tasklat, tasklon);
            console.log('Calculated Distance:', distance);

            if (distance > 50) {
                $('.btnFinished[data-table="' + tableId + '"]').hide();
            } else {
                $('.btnFinished[data-table="' + tableId + '"]').show();
            }
        }
    }
function a(category, item, tableId){


    $.ajax({
        url: 'get_rescuer_coords.php',
        method: 'GET',
        success: function (response) {
            try {
                // Parse the array of coordinates
                var rescuerCoordsArray = JSON.parse(response);
    
                // Check if there's at least one set of coordinates in the array
                if (rescuerCoordsArray.length > 0) {
                    // Access the first set of coordinates
                    var rescuerCoords = rescuerCoordsArray[0];
    
                    // Extract latitude and longitude
                    resclat = rescuerCoords.latitude;
                    resclon = rescuerCoords.longitude;
    
                    
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

    if(tableId =='offerTable'){
        $.ajax({
            url: 'getTasksRescuer.php',
            method: 'GET',
            success: function (response) {
                try {
                    var taskCoords = JSON.parse(response);
                    var foundCargoItem = null;
                        // Iterate through the array to find the correct cargo item
                        for (let key in taskCoords.offers) {
                            var cargoItem = taskCoords.offers[key];
                            if (cargoItem.Category === category && cargoItem.Item === item) {
                                foundCargoItem = cargoItem;
                                break; // Exit the loop once the item is found
                            }
                        }                
    
                    tasklat = foundCargoItem.latitude;
                    tasklon = foundCargoItem.longitude;
                } catch (error) {
                    console.error("Error parsing JSON: ", error);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX request error (Task Coords): ", status, error);
            }
        });showHideFinishedButton(resclat, resclon, tasklat, tasklon, tableId);
    } else if(tableId =='requestTable'){
        $.ajax({
            url: 'getTasksRescuer.php',
            method: 'GET',
            success: function (response) {
                try {
                    var taskCoords = JSON.parse(response);
                    var foundCargoItem = null;
                        // Iterate through the array to find the correct cargo item
                        for (let key in taskCoords.requests) {
                            var cargoItem = taskCoords.requests[key];
                            if (cargoItem.Category === category && cargoItem.Item === item) {
                                foundCargoItem = cargoItem;
                                break; // Exit the loop once the item is found
                            }
                        }                
    
                    tasklat = foundCargoItem.latitude;
                    tasklon = foundCargoItem.longitude;
                } catch (error) {
                    console.error("Error parsing JSON: ", error);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX request error (Task Coords): ", status, error);
            }
        });
    }showHideFinishedButton(resclat, resclon, tasklat, tasklon, tableId);
}