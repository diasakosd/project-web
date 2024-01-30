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
                <td><button id="btnFinished" data-id="${row.id}" data-table="${tableId}" 
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
        });
        // Event delegation for Cancel buttons
        $(document).on('click', '#btnCancel', function() {
            var id = $(this).data('id');
            var tableId = $(this).data('table');
            handleCancelButton(id, tableId);
        });
});

function handleFinishedButton(id, tableId, category, item, difference) {
   
    $.ajax({
        url: 'getTasksRescuer.php',
        type: 'GET',
        success: function(data) {
            try {
                var jsonData = JSON.parse(data);
                var task = jsonData.requests.find(task => task.id === id);
                rescuer_quantity = task.Quantity;

            } catch (e) {
                console.error('Error parsing JSON:', e);
                console.log('Raw JSON data:', data);
            }
        },
        error: function(error) {
            console.error('Error fetching data:', error.responseText);
        }
    });
if(rescuer_quantity - difference >=0){
    alert('Task Finished successfully!');
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
            console.error('AJAX request error (handleCancelButton):', status, error);
        }
    });
} else{
    alert("You can't offer that much quantity of this item yet!\nPlease visit the Base to update your cargo.");
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