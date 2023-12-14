$(document).ready(function(){
    $.ajax({
        url: 'base_get-resc.php',
        method: 'GET',
        success: function(response){
            console.log("Response received", response);
            try{
                var cargoData = JSON.parse(response);
                console.log("Parsed cargoData:", cargoData); // Check parsed cargoData

                var tableBody = $('#baseCargoTable tbody');

                tableBody.empty(); // Clear the table body before populating it with new content

                if(cargoData.length > 0){
                    var headerRow = $('<tr></tr>'); // Create a header row
                    headerRow.append($('<th></th>'))

                    Object.keys(cargoData[0]).forEach(function(key){
                        headerRow.append('<th>' + key + '</th>'); // Display headers
                    });
                    $('#baseCargoTable').append('<thead>' + headerRow.prop('outerHTML') + '</thead>');

                    cargoData.forEach(function(cargo, index){
                        var row = $('<tr class="item_id"></tr>'); // Create a new row for each cargo item
                        var itemId = index + 1; // Generate item_id starting from 1

                        // Add a checkbox to each row
                        var checkboxCell = $('<td><input type="checkbox"></td>');
                        row.append(checkboxCell);

                        Object.keys(cargo).forEach(function(key){
                            row.append('<td>' + cargo[key] + '</td>'); // Display data
                        });

                        tableBody.append(row); // Append the row to the table body

                })}
            }catch (error) {
                console.error("Error parsing JSON: ", error);
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX request error: ", status, error);
        }
    })
});