
document.addEventListener('DOMContentLoaded', function () {
    // Attach submit event to the form
    var form = document.getElementById('updateTableForm');
    form.addEventListener('submit', function (event) {
        event.preventDefault();  // Prevent the default form submission

        // Get the form data
        var formData = new FormData(form);

        // Check if quantity is empty for ADD action
        var action = formData.get('action-form');
        if (action === 'ADD' && formData.get('quantity-form') === '') {
            formData.set('quantity-form', 0);
        }

        // Check if quantity is empty for UPDATE action
        if (action === 'UPDATE' && formData.get('quantity-form') === '') {
            formData.set('quantity-form', 0);
        }

        // Make an AJAX request
        var xhr = new XMLHttpRequest();
        xhr.open('POST', form.action, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Update the message container with the response
                document.querySelector('.err_message').textContent = xhr.responseText;
                document.getElementById('updateTableBtn').click();
            }
        };

        // Send the form data
        xhr.send(formData);
    });
});

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

function prepareForm() {
    var quantityField = document.getElementById('quantity-form');
    var actionField = document.getElementById('action-form');

    // Check the selected action and adjust form fields
    switch (actionField.value) {
        case 'ADD':
            // Set quantity to 0 if the user left it empty
            if (quantityField.value.trim() === '') {
                quantityField.value = 0;

                // Remove the "required" attribute if quantity is set to 0
                quantityField.removeAttribute('required');
            }
            break;
        case 'UPDATE':
            // Set quantity to 0 if the user left it empty for UPDATE action
            if (quantityField.value.trim() === '') {
                quantityField.value = 0;
            }
            break;
        case 'DELETE':
            // Clear quantity for DELETE action
            quantityField.value = '';
            // Add back the "required" attribute for DELETE action
            quantityField.setAttribute('required', 'required');
            break;
        default:
            break;
    }
}

