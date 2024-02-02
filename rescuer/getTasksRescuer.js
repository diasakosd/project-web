var rescuer_quantity;

$(document).ready(function() {
    // Fetch task coordinates
    $.ajax({
        url: 'getTasksRescuer.php',
        method: 'GET',
        success: function (response) {
            try {
                // Parse the JSON response
                var taskData = JSON.parse(response);

                // Check if there's at least one set of coordinates in the array
                if (taskData.offers.length > 0) {
                    // Access the first set of coordinates for offers
                    var offerCoords = taskData.offers[0];
                    // Extract latitude and longitude
                    offertasklat = offerCoords.latitude;
                    offertasklon = offerCoords.longitude;
                }

                if (taskData.requests.length > 0) {
                    // Access the first set of coordinates for requests
                    var requestCoords = taskData.requests[0];
                    // Extract latitude and longitude
                    tasklat = requestCoords.latitude;
                    tasklon = requestCoords.longitude;
                }

                // Fetch rescuer coordinates
                $.ajax({
                    url: 'get_rescuer_coords.php',
                    method: 'GET',
                    success: function (rescuerResponse) {
                        try {
                            // Parse the JSON response for rescuer coordinates
                            var rescuerCoordsArray = JSON.parse(rescuerResponse);

                            // Check if there's at least one set of coordinates in the array
                            if (rescuerCoordsArray.length > 0) {
                                // Access the first set of coordinates for the rescuer
                                var rescuerCoords = rescuerCoordsArray[0];

                                // Extract latitude and longitude
                                resclat = rescuerCoords.latitude;
                                resclon = rescuerCoords.longitude;
                                var tableId = 'offerTable';

                                // Show/hide finished buttons based on coordinates
                                showHideFinishedButton(resclat, resclon, offertasklat, offertasklon, tableId);
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

            } catch (error) {
                console.error("Error parsing JSON (Task Coords): ", error);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX request error (Task Coords): ", status, error);
        }
    });

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
            newRow.attr('id', 'row_' + row.id); // Set a unique id for each row
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


        // Event delegation for Finished buttons
        $(document).on('click', '#btnFinished', function() {
            var id = $(this).data('id');
            var tableId = $(this).data('table');
            var category = $(this).data('category');
            var item = $(this).data('item');
            var quantity = $(this).data('quantity');  
            handleFinishedButton(id, tableId, category, item, quantity);  
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



function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371; 
    const dLat = (lat2 - lat1) * (Math.PI / 180);
    const dLon = (lon2 - lon1) * (Math.PI / 180);
    const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(lat1 * (Math.PI / 180)) * Math.cos(lat2 * (Math.PI / 180)) * Math.sin(dLon / 2) * Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    const distance = R * c; 
    const distanceInMeters = distance * 1000; 

    console.log('Coordinates:', lat1, lon1, lat2, lon2);
    console.log('Calculated Distance:', distanceInMeters);

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

        // Iterate over each row and hide/show btnFinished based on the row's id
        $('#' + tableId + ' tbody tr').each(function () {
            var rowId = $(this).attr('id');
            var button = $('#' + rowId + ' button.btnFinished');

            console.log('Row ID:', rowId);
            console.log('Button:', button);

            if (distance > 50) { // Update the threshold to 50 meters
                button.hide();console.log('Hiding button');
            } else {
                button.show();
                console.log('Showing button');
            }
        });
    }
}
