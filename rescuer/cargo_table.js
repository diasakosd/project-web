$(document).ready(function(){
    $.ajax({
        url: 'get_rescuer_details.php', // PHP file to retrieve data
        method: 'GET',
        success: function(response){
            try {
                var cargoData = JSON.parse(response);

                // Reference to the tbody of the table
                var tableBody = $('#loadedCargoTable tbody');

                // Clear the table body before populating it with new content
                tableBody.empty();

                if (cargoData.hasOwnProperty('message')) {
                    // User has no cargo, display the message
                    tableBody.append('<tr><td colspan="2">' + cargoData.message + '</td></tr>');
                } else if (cargoData.length > 0) {
                    // Display headers for the first cargo item
                    var headerRow = $('<tr></tr>'); // Create a header row
                    Object.keys(cargoData[0]).forEach(function(key){
                        headerRow.append('<th>' + key + '</th>'); // Display headers
                    });
                    $('#loadedCargoTable').append('<thead>' + headerRow.prop('outerHTML') + '</thead>');

                    // Iterate through each cargo item and create a new row in the table
                    cargoData.forEach(function(cargo){
                        var row = $('<tr></tr>'); // Create a new row for each cargo item
                        Object.keys(cargo).forEach(function(key){
                            row.append('<td>' + cargo[key] + '</td>'); // Display data
                        });

                        // Append the row to the table body
                        tableBody.append(row);
                    });
                } // If cargoData is empty (no cargo), do nothing (no rows will be added)
            } catch (error) {
                console.error("Error parsing JSON: ", error);
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX request error: ", status, error);
        }
    });
});
