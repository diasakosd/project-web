// base_table.js

document.addEventListener('DOMContentLoaded', function () {
    // Function to update the table
    function updateTable() {
        // Make an AJAX request to base_get.php
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'base_get.php', true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Update the table container with the response
                document.querySelector('.table_base').innerHTML = xhr.responseText;
            }
        };

        // Send the AJAX request
        xhr.send();
    }

    // Initial table update
    updateTable();

    // Add an event listener to the "Update Table" button
    document.getElementById('updateTableBtn').addEventListener('click', function () {
        // Call the updateTable function when the button is clicked
        updateTable();
    });
});
