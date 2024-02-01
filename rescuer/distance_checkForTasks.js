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
    function a(category, item, tableId) {
        // Function to get rescuer coordinates
        function getRescuerCoords() {
            return new Promise(function (resolve, reject) {
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
                                resolve();
                            } else {
                                console.error('No rescuer coordinates found in the array.');
                                reject('No rescuer coordinates found');
                            }
                        } catch (error) {
                            console.error("Error parsing JSON (Rescuer Coords): ", error);
                            reject('Error parsing JSON (Rescuer Coords)');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX request error (Rescuer Coords): ", status, error);
                        reject('AJAX request error (Rescuer Coords)');
                    }
                });
            });
        }
    
        // Function to get task coordinates
        function getTaskCoords() {
            return new Promise(function (resolve, reject) {
                $.ajax({
                    url: 'getTasksRescuer.php',
                    method: 'GET',
                    success: function (response) {
                        try {
                            var taskCoords = JSON.parse(response);
                            var foundCargoItem = null;
    
                            for (let key in taskCoords.offers) {
                                var cargoItem = taskCoords.offers[key];
                                if (cargoItem.Category === category && cargoItem.Item === item) {
                                    foundCargoItem = cargoItem;
                                    break;
                                }
                            }
    
                            if (foundCargoItem) {
                                tasklat = foundCargoItem.latitude;
                                tasklon = foundCargoItem.longitude;
                                resolve();
                            } else {
                                console.error('No matching task coordinates found.');
                                reject('No matching task coordinates found');
                            }
                        } catch (error) {
                            console.error("Error parsing JSON (Task Coords): ", error);
                            reject('Error parsing JSON (Task Coords)');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX request error (Task Coords): ", status, error);
                        reject('AJAX request error (Task Coords)');
                    }
                });
            });
        }
    
        // Using promises to ensure that both rescuer and task coordinates are obtained
        getRescuerCoords().then(function () {
            if (tableId == 'offerTable') {
                return getTaskCoords();
            } else if (tableId == 'requestTable') {
                return getTaskCoords();
            }
        }).then(function () {
            // Call showHideFinishedButton after getting both rescuer and task coordinates
            showHideFinishedButton(resclat, resclon, tasklat, tasklon, tableId);
        }).catch(function (error) {
            console.error('Error:', error);
        });
    }
    
    