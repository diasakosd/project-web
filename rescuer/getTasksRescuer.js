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
                <td><button id="btnFinished">Finished</button></td>
                <td><button id="btnCancel">Cancel</button></td>
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
});
