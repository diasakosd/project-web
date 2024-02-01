var rescuer_quantity;

$(document).ready(function() {
    // Function to make AJAX request
    function fetchData(url, callback) {
        $.ajax({
            url: url,
            type: 'GET',
            success: function(data) {
                try {
                    var jsonData = JSON.parse(data);
                    callback(jsonData);
                } catch (e) {
                    console.error('Error parsing JSON:', e);
                    console.log('Raw JSON data:', data);
                }
            },
            error: function(error) {
                console.error('Error fetching data:', error.responseText);
            }
        });
    }

    // Function to populate a table with data
    function populateTable(data, tableId) {
        var table = $('#' + tableId);
        table.empty(); // Clear existing rows

        // Create table header
        var thead = $('<thead>');
        var headerRow = $('<tr>');
        headerRow.html(`
            <th>Fullname</th>
            <th>Telephone</th>
            <th>Created</th>
            <th>Category</th>
            <th>Item</th>
            <th>Quantity</th>
            <th>Finished</th>
            <th>Cancel</th>
        `);
        thead.append(headerRow);
        table.append(thead);

        // Create table body
        var tbody = $('<tbody>');

        // Iterate through the data and append rows to the table
        $.each(data, function(index, row) {
            var newRow = $('<tr>');
            newRow.html(`
                <td>${row.Fullname}</td>
                <td>${row.Telephone}</td>
                <td>${row.Created}</td>
                <td>${row.Category}</td>
                <td>${row.Item}</td>
                <td>${row.Quantity}</td>
                <td><button class="btnFinished" id="btnFinished" data-id="${row.id}" data-table="${tableId}" 
                data-category="${row.Category}" data-item="${row.Item}" data-quantity="${row.Quantity}">Finished</button></td>
                <td><button id="btnCancel" data-id="${row.id}" data-table="${tableId}">Cancel</button></td>

            `);
            tbody.append(newRow);
        });

        table.append(tbody);
    }

    // Fetch data for the first query (offers)
    fetchData('getTasksRescuer.php', function(data) {
        // Populate the offerTable with data
        populateTable(data.offers, 'offerTable');
    });

    // Fetch data for the second query (requests)
    fetchData('getTasksRescuer.php', function(data) {
        // Populate the requestTable with data
        populateTable(data.requests, 'requestTable');
    });


    // Function to get rescuer and task coordinates
function getCoordinates() {
    return new Promise(function (resolve, reject) {
        var rescuerCoordsPromise = $.ajax({
            url: 'get_rescuer_coords.php',
            method: 'GET',
        });

        var taskCoordsPromise = $.ajax({
            url: 'getTasksRescuer.php',
            method: 'GET',
        });

        var tableId = $(this).data('table');
var category = $(this).data('category');
var item = $(this).data('item');


        Promise.all([rescuerCoordsPromise, taskCoordsPromise]).then(function (responses) {
            try {
                // Parse the array of coordinates
                var rescuerCoordsArray = JSON.parse(responses[0]);

                if (rescuerCoordsArray.length > 0) {
                    // Access the first set of coordinates
                    var rescuerCoords = rescuerCoordsArray[0];

                    // Extract latitude and longitude
                    resclat = rescuerCoords.latitude;
                    resclon = rescuerCoords.longitude;
                } else {
                    console.error('No rescuer coordinates found in the array.');
                    reject('No rescuer coordinates found');
                }

                var taskCoords = JSON.parse(responses[1]);
                var foundCargoItem = null;

                // Iterate through the array to find the correct cargo item
                for (let key in taskCoords.offers) {
                    var cargoItem = taskCoords.offers[key];
                    console.log('Cargo Item:', cargoItem);
                    if (cargoItem.Category === category && cargoItem.Item === item) {
                        foundCargoItem = cargoItem;
                        break; // Exit the loop once the item is found
                    }
                }

                if (foundCargoItem) {
                    tasklat = foundCargoItem.latitude;
                    tasklon = foundCargoItem.longitude;
                    resolve(); // Resolve the promise when both coordinates are obtained
                } else {
                    console.error('No matching task coordinates found.');
                    reject('No matching task coordinates found');
                }
            } catch (error) {
                console.error("Error parsing JSON: ", error);
                reject('Error parsing JSON');
            }
        }).catch(function (error) {
            console.error("Error in Promise.all: ", error);
            reject(error);
        });
    });
}


$(document).ready(function () {
    // Call your functions to fetch data and populate tables here

    // Call getCoordinates to get both rescuer and task coordinates
    getCoordinates().then(function () {
        // Call showHideFinishedButton after getting both rescuer and task coordinates
        showHideFinishedButton(resclat, resclon, tasklat, tasklon, tableId);
    }).catch(function (error) {
        console.error('Error getting coordinates:', error);
    });
});
        // Event delegation for Finished buttons
        $(document).on('click', '#btnFinished', function() {
            var id = $(this).data('id');
            var tableId = $(this).data('table');
            var category = $(this).data('category');
            var item = $(this).data('item');
            var quantity = $(this).data('quantity');    
        });});
        // Event delegation for Cancel buttons
        $(document).on('click', '#btnCancel', function() {
            var id = $(this).data('id');
            var tableId = $(this).data('table');
            handleCancelButton(id, tableId);
        });


function handleFinishedButton(id, tableId, category, item, difference) {
    if(tableId == 'offerTable'){
        $.ajax({
            url: 'setTasksRescuer.php',
            method: 'POST',
            data: { ID: id, tableId: tableId, category: category, item: item, difference: difference, actionType: 'Finish' },
            success: function (response) {
                console.log('Rescuer took offer successfully:', response);
                $('#' + tableId + ' button[data-id="' + id + '"]').closest('tr').remove();
                //location.reload();
            },
            error: function (xhr, status, error) {
                console.error('AJAX request error (handleFinishedButton):', status, error);
            }
        });
    }
    else if(tableId == 'requestTable'){
        $.ajax({
            url: 'cargo_table.php',
            type: 'GET',
            success: function(data) {
                try {
                    var jsonData = JSON.parse(data);console.log('Parsed JSON data:', jsonData);
                    var foundCargoItem = null;

                    // Iterate through the array to find the correct cargo item
                    for (var i = 0; i < jsonData.length; i++) {
                        var cargoItem = jsonData[i];
                        if (cargoItem.Category === category && cargoItem.Item === item) {
                            foundCargoItem = cargoItem;
                            break; // Exit the loop once the item is found
                        }
                    }
                    var rescuer_quantity = foundCargoItem.Quantity;

                    if (rescuer_quantity - difference >= 0) {
                        alert('Task Finished successfully!'+difference);
                        $.ajax({
                            url: 'setTasksRescuer.php',
                            method: 'POST',
                            data: { ID: id, tableId: tableId, category: category, item: item, difference: difference, actionType: 'Finish' },
                            success: function (response) {
                                console.log('Rescuer took request successfully:', response);
                                $('#' + tableId + ' button[data-id="' + id + '"]').closest('tr').remove();
                                //location.reload();
                            },
                            error: function (xhr, status, error) {
                                console.error('AJAX request error (handleFinishedButton):', status, error);
                            }
                        });
                    } else {
                        alert("You can't offer that much quantity of this item yet!\nPlease visit the Base to update your cargo."+rescuer_quantity);
                    }
                } catch (e) {
                    console.error('Error parsing JSON:', e);
                    console.log('Raw JSON data:', data);
                }
            },
            error: function(error) {
                console.error('Error fetching data:', error.responseText);
            }
        });
    }
}


function handleCancelButton(id, tableId) {
    alert('Task Canceled successfully!');
    const accepted = 'NO';

    $.ajax({
        url: 'setTasksRescuer.php',
        method: 'POST',
        data: { Accepted: accepted, ID: id, tableId: tableId, actionType: 'Cancel' },
        success: function (response) {
            console.log('Rescuer took request successfully:', response);
            $('#' + tableId + ' button[data-id="' + id + '"]').closest('tr').remove();
            //location.reload();
        },
        error: function (xhr, status, error) {
            console.error('AJAX request error (handleCancelButton):', status, error);
        }
    });
}

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