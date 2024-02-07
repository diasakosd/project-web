$(document).ready(function () {
    var cargoData; 

    function renderCargoTable() {
        var tableBody = $('#baseCargoTable tbody');
        tableBody.empty();

        if (cargoData.length > 0) {
            var headerRow = $('<tr></tr>');
            headerRow.append($('<th></th>'));

            Object.keys(cargoData[0]).forEach(function (key) {
                if (key === 'Quantity') {
                    headerRow.append('<th class="editable-cell">' + key + '</th>');
                } else {
                    headerRow.append('<th>' + key + '</th>');
                }
            });

            $('#baseCargoTable').append('<thead>' + headerRow.prop('outerHTML') + '</thead>');

            cargoData.forEach(function (cargo) {
                var row = $('<tr class="item_id"></tr>');
                var itemId = cargo.id; 

                //Add a checkbox to each row
                var checkboxCell = $('<td><input type="checkbox"></td>');
                row.append(checkboxCell);

                Object.keys(cargo).forEach(function (key) {
                    
                    if (key === 'Quantity') {
                        row.append('<td class="editable-cell" data-item-id="' + itemId + '">' + cargo[key] + '</td>');
                    } else {
                        row.append('<td>' + cargo[key] + '</td>');
                    }
                });

                tableBody.append(row);

                //Handle row click to toggle the checkbox state
                row.on('click', function () {
                    var checkbox = $(this).find('input[type="checkbox"]');
                    checkbox.prop('checked', !checkbox.prop('checked'));
                });

                //Handle checkbox click to stop propagation -- Actually disabling the checkbox. Act as a row click (see above)
                checkboxCell.find('input[type="checkbox"]').on('click', function (event) {
                    event.stopPropagation();
                });
            });
        }
    }

    $.ajax({
        url: 'base_get-resc.php',
        method: 'GET',
        success: function (response) {
            console.log("Response received", response);
            try {
                cargoData = JSON.parse(response);
                console.log("Parsed cargoData:", cargoData);
                renderCargoTable();
            } catch (error) {
                console.error("Error parsing JSON: ", error);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX request error: ", status, error);
        }
    });
});
