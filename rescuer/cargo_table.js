$(document).ready(function(){
    $.ajax({
        url: 'cargo_table.php', // PHP file to retrieve data
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
                    var selectAllCheckbox = $('<input type="checkbox" class="select_all_items">');
                    var selectAllCell = $('<th>Select All</th>').append(selectAllCheckbox);
                    headerRow.append(selectAllCell);
                    
                    Object.keys(cargoData[0]).forEach(function(key){
                        headerRow.append('<th>' + key + '</th>'); // Display headers
                    });
                    $('#loadedCargoTable').append('<thead>' + headerRow.prop('outerHTML') + '</thead>');

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

                        // Handle row click to toggle the checkbox state
                        row.on('click', function() {
                            var checkbox = $(this).find('input[type="checkbox"]');
                            checkbox.prop('checked', !checkbox.prop('checked'));
                        });

                        // Handle checkbox click to stop propagation -- Actually disabling the checkbox. Act as a row click (see above)
                        checkboxCell.find('input[type="checkbox"]').on('click', function(event) {
                            event.stopPropagation();
                        });
                    });

                    function selectAllRows() {
                        return $('.item_id');
                    }
                
                    $('.select_all_items').on('change', function() {
                        var isChecked = $(this).prop('checked');
                        var rows = selectAllRows();
                
                        rows.each(function() {
                            $(this).find('input[type="checkbox"]').prop('checked', isChecked);
                        });
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

