var rescuer_quantity;
var resclat; 
var resclon; 

$(document).ready(function() {

$.ajax({
    url: 'getTasksRescuer.php',
    method: 'GET',
    success: function (response) {
        try {
            var taskData = JSON.parse(response);

            $.ajax({
                url: 'get_rescuer_coords.php',
                method: 'GET',
                success: function (rescuerResponse) {
                    try {
                        var rescuerCoordsArray = JSON.parse(rescuerResponse);

                        if (rescuerCoordsArray.length > 0) {
                            var rescuerCoords = rescuerCoordsArray[0];

                            resclat = rescuerCoords.latitude;
                            resclon = rescuerCoords.longitude;

                            //showHideFinishedButton for each offer row 
                            if (taskData.offers.length > 0) {
                                for (let key in taskData.offers) {
                                    const offerDetails = taskData.offers[key];

                                    //latitude and longitude for each offer
                                    const offertasklat = offerDetails.latitude;
                                    const offertasklon = offerDetails.longitude;

                                    showHideFinishedButton(resclat, resclon, offertasklat, offertasklon, 'offerTable');
                                }
                            }

                            if (taskData.requests.length > 0) {
                                for (let key in taskData.requests) {
                                    const requestDetails = taskData.requests[key];

                                    //latitude and longitude for each request
                                    const requesttasklat = requestDetails.latitude;
                                    const requesttasklon = requestDetails.longitude;

                                    showHideFinishedButton(resclat, resclon, requesttasklat, requesttasklon, 'requestTable');
                                }
                            }
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

    function populateTable(data, tableId) {
        var table = $('#' + tableId);
        table.empty(); 

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

        var tbody = $('<tbody>');

        $.each(data, function(index, row) {
            var newRow = $('<tr>');
            newRow.attr('id', 'row_' + row.id); 
            newRow.html(`
                <td>${row.Fullname}</td>
                <td>${row.Telephone}</td>
                <td>${row.Created}</td>
                <td>${row.Category}</td>
                <td>${row.Item}</td>
                <td>${row.Quantity}</td>
                <td><button class="btnFinished" id="btnFinished" data-id="${row.id}" data-table="${tableId}" 
                data-category="${row.Category}" data-item="${row.Item}" data-quantity="${row.Quantity}"
                data-latitude="${row.latitude}" data-longitude="${row.longitude}">Finished</button></td>
                <td><button id="btnCancel" data-id="${row.id}" data-table="${tableId}">Cancel</button></td>

                
                <td style="display: none;">${row.latitude}</td>
                <td style="display: none;">${row.longitude}</td>

            `);
            tbody.append(newRow);
        });

        table.append(tbody);
    }

    fetchData('getTasksRescuer.php', function(data) {
        //offerTable with data
        populateTable(data.offers, 'offerTable');
    });

    fetchData('getTasksRescuer.php', function(data) {
        //requestTable with data
        populateTable(data.requests, 'requestTable');
    });


        $(document).on('click', '#btnFinished', function() {
            var id = $(this).data('id');
            var tableId = $(this).data('table');
            var category = $(this).data('category');
            var item = $(this).data('item');
            var quantity = $(this).data('quantity');  
            handleFinishedButton(id, tableId, category, item, quantity);  
        });});

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
                alert('Task Completed successfully!');
                console.log('Rescuer took offer successfully:', response);
                $('#' + tableId + ' button[data-id="' + id + '"]').closest('tr').remove();
                location.reload();
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

                    //Iterate through the array to find the correct cargo item
                    for (var i = 0; i < jsonData.length; i++) {
                        var cargoItem = jsonData[i];
                        if (cargoItem.Category === category && cargoItem.Item === item) {
                            foundCargoItem = cargoItem;
                            break; //Exit the loop once the item is found
                        }
                    }
                    var rescuer_quantity = foundCargoItem.Quantity;

                    if (rescuer_quantity - difference >= 0) {
                        alert('Task Finished successfully!');
                        $.ajax({
                            url: 'setTasksRescuer.php',
                            method: 'POST',
                            data: { ID: id, tableId: tableId, category: category, item: item, difference: difference, actionType: 'Finish' },
                            success: function (response) {
                                console.log('Rescuer took request successfully:', response);
                                $('#' + tableId + ' button[data-id="' + id + '"]').closest('tr').remove();
                                location.reload();
                            },
                            error: function (xhr, status, error) {
                                console.error('AJAX request error (handleFinishedButton):', status, error);
                            }
                        });
                    } else {
                        alert("You can't offer that much quantity of this item yet!\nPlease visit the Base to update your cargo.");
                    }
                } catch (e) {
                    alert("You can't offer that much quantity of this item yet!\nPlease visit the Base to update your cargo.");
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
            location.reload();
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

    if (resclat && resclon && tasklat && tasklon) {
        
        

        //Iterate over each row and hide/show btnFinished 
        $('#' + tableId + ' tbody tr').each(function () {
            var rowId = $(this).attr('id');
            var rowLat = $(this).find('td').eq(8).text();  //latitude is in the 8th column
            var rowLon = $(this).find('td').eq(9).text();  //longitude is in the 9th column
            var button = $('#' + rowId + ' button.btnFinished');
            var distance = calculateDistance(resclat, resclon, rowLat, rowLon);
            console.log('Row ID:', rowId);

            if (distance > 50) { 
                button.hide();console.log('Hiding button');
            } else {
                button.show();
                console.log('Showing button');
            }
        });
    }
}
