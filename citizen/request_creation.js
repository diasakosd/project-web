document.addEventListener('DOMContentLoaded', function () {
    // Fetch announcements and dropdown menu when the page loads
    fetchAnnouncements();
    populateDropdowns();
});


function validateForm() {
    var category = document.getElementById("category").value;
    var item = document.getElementById("item").value;
    var quantity = document.getElementById("quantity").value;
    var status = document.getElementById("status").value;

    if (category === "" || item === "") {
        // Display an error message
        document.querySelector('.error_message').innerHTML = "Oops bro kati ksexases.";
        return false; // Prevent form submission
    }
 else
    return true; // Allow form submission
}

function populateDropdowns() {
    // Fetch initial options for category and item when the page loads
    fetchOptions('category');
    fetchOptions('item');
}

// Function to fetch options for category or item
function fetchOptions(field) {
    // AJAX request to fetch data from PHP script
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Parse the JSON response
            var data = JSON.parse(xhr.responseText);

            // Update the dropdown based on the field
            if (field === 'category') {
                updateDropdown('category', data.categories);
            } else if (field === 'item') {
                updateDropdown('item', data.items);
            }
        }
    };

    // Replace "your_data_fetching_script.php" with your actual PHP script
    xhr.open("GET", "fetch_request_creation.php?field=" + field, true);
    xhr.send();
}

// Function to update dropdown options
function updateDropdown(field, options) {
    var dropdown = document.getElementById(field);
    
    // Clear existing options
    dropdown.innerHTML = '';

    // Add new options
    options.forEach(function (option) {
        var optionElement = document.createElement("option");
        optionElement.text = option;
        dropdown.add(optionElement);
    });
}

$(document).ready(function () {

    // Set current time
    var currentTime = new Date();
    $("#currentTime").val(currentTime.toISOString().slice(0, 19).replace("T", " "));

    // Form submission
    $("#request_creationForm").submit(function (event) {
        event.preventDefault();

        // Get form data
        var formData = {
            item: $("#item").val(),
            category: $("#category").val(),
            quantity: $("#quantity").val(),
            currentTime: $("#currentTime").val()
        };

        // Send data to the server using AJAX
        $.ajax({
            type: "POST",
            url: "fetch_request_creation.php",  
            data: formData,

            success: function (response) {
                // Handle success (if needed)
                console.log("Request submitted successfully");
            },
            error: function (error) {
                // Handle error (if needed)
                console.error("Error submitting request:", error);
            }
        });
    });
});
