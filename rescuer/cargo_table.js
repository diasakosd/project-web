$(document).ready(function(){
    $.ajax({
        url: 'get_rescuer_details.php', // PHP file to retrieve data
        method: 'GET',
        success: function(response){
            console.log("Response received:", response); // Check the response
            try {
                var cargoData = JSON.parse(response);
                console.log("Parsed cargoData:", cargoData); // Check parsed cargoData

                var tableBody = $('#loadedCargoTable tbody');

                tableBody.empty(); // Clear the table body before populating it with new content

                if (cargoData.hasOwnProperty('message')) {
                    tableBody.append('<tr><td colspan="2">' + cargoData.message + '</td></tr>');
                } else if (cargoData.length > 0) {
                    var headerRow = $('<tr></tr>'); // Create a header row
                    var selectAllCheckbox = $('<input type="checkbox">');
                    var selectAllCell = $('<th>Select All</th>').append(selectAllCheckbox);
                    headerRow.append(selectAllCell);
                    
                    Object.keys(cargoData[0]).forEach(function(key){
                        headerRow.append('<th>' + key + '</th>'); // Display headers
                    });
                    $('#loadedCargoTable').append('<thead>' + headerRow.prop('outerHTML') + '</thead>');

                    cargoData.forEach(function(cargo){
                        var row = $('<tr></tr>'); // Create a new row for each cargo item

                        // Add a checkbox to each row
                        var checkboxCell = $('<td><input type="checkbox"></td>');
                        row.append(checkboxCell);

                        Object.keys(cargo).forEach(function(key){
                            row.append('<td>' + cargo[key] + '</td>'); // Display data
                        });

                        tableBody.append(row); // Append the row to the table body
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
