document.addEventListener('DOMContentLoaded', function () {
    // Fetch initial options for category and item when the page loads
    fetchOptions('category');
    fetchOptions('item');

    // Add event listener to call fetchOptions on change
    document.getElementById('category').addEventListener('change', function () {
        fetchOptions('item', this.value);
    });

    // Add event listener for form submission
    document.getElementById('request_creationForm').addEventListener('submit', function () {
        // Reset error message on form submission
        document.querySelector('.error_message').innerHTML = '';
    });
});

$(document).ready(function () {
    // Autocomplete for category
    $("#category").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "fetch_request_creation.php",
                dataType: "json",
                data: {
                    field: 'category',
                    term: request.term
                },
                success: function (data) {
                    response(data.categories);
                }
            });
        }
    });

    // Autocomplete for item
    $("#item").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "fetch_request_creation.php",
                dataType: "json",
                data: {
                    field: 'item',
                    term: request.term,
                    selectedCategory: $("#category").val()
                },
                success: function (data) {
                    response(data.items);
                }
            });
        }
    });
function fetchOptions(field, selectedCategory = null) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var data = JSON.parse(xhr.responseText);

            // Check if the response contains the expected field
            if (data[field + 's']) {
                updateDropdown(field, data[field + 's']);
            } else {
                console.error('Invalid response format');
            }
        }
    };

    var url = "fetch_request_creation.php?field=" + field;

    // Pass selected category to the server if it's not null
    if (selectedCategory !== null) {
        url += "&selectedCategory=" + encodeURIComponent(selectedCategory);
    }

    xhr.open("GET", url, true);
    xhr.send();
}

function updateDropdown(field, options) {
    var dropdown = document.getElementById(field);

    // Clear existing options
    dropdown.innerHTML = '';

    // Add default option
    var defaultOption = document.createElement("option");
    defaultOption.value = "";
    defaultOption.text = "Select " + field.charAt(0).toUpperCase() + field.slice(1);
    dropdown.add(defaultOption);

    // Add new options
    options.forEach(function (option) {
        var optionElement = document.createElement("option");
        optionElement.value = option;
        optionElement.text = option;
        dropdown.add(optionElement);
    });

    dropdown.value = ""; // Ensure that the default option is selected
}
});