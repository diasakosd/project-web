document.addEventListener('DOMContentLoaded', function () {
    // Function to update the table based on selected categories
    function updateTable() {
        // Get selected categories
        var selectedCategories = Array.from(document.querySelectorAll('.category-checkbox:checked')).map(function (checkbox) {
            return checkbox.value;
        });

        // Make an AJAX request to base_get.php with selected categories
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'base_get.php?categories=' + selectedCategories.join(','), true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Update the table container with the response
                document.querySelector('.table_base').innerHTML = xhr.responseText;
            }
        };

        //Send the AJAX request
        xhr.send();
    }

    //Function to fetch categories via AJAX and create checkboxes
    function fetchCategories() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_categories.php', true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                //Update the category menu with checkboxes
                document.querySelector('#categoryMenu').innerHTML = xhr.responseText;

                //Add event listener to category checkboxes
                var categoryCheckboxes = document.querySelectorAll('.category-checkbox');
                categoryCheckboxes.forEach(function (checkbox) {
                    checkbox.addEventListener('change', updateTable);
                });

                //Table update when checkboxed selected
                updateTable();
            }
        };

        // Send the AJAX request
        xhr.send();
    }

    // Fetch categories and create checkboxes
    fetchCategories();
});
