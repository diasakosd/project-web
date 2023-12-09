// announcement_script.js

// Function to fetch items from the base_storage table and populate the dropdown
function fetchItems() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'fetch_items.php', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const items = JSON.parse(xhr.responseText);

            // Populate the dropdown with items
            const selectedItems = document.getElementById('selectedItems');
            items.forEach(item => {
                const option = document.createElement('option');
                option.value = item;
                option.text = item;
                selectedItems.add(option);
            });
        }
    };
    xhr.send();
}

// Function to submit the form using AJAX
function submitForm() {
    // Get form data
    const title = document.getElementById('title').value;
    const body = document.getElementById('body').value;
    const selectedItems = Array.from(document.getElementById('selectedItems').selectedOptions).map(option => option.value);

    // Create an object with the form data
    const formData = {
        title: title,
        body: body,
        selectedItems: selectedItems
    };

    // Send data using AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'process_announcement.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Handle the response
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                document.getElementById('successMessage').innerHTML = 'Announcement added successfully!';
            } else {
                document.getElementById('successMessage').innerHTML = 'Error adding announcement.';
            }
        }
    };
    xhr.send(JSON.stringify(formData));
}

// Fetch items when the page loads
window.onload = fetchItems;