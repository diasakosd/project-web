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
                option.value = item.item; // Store only the item value
                option.setAttribute('data-category', item.category); // Use a data attribute for category
                option.text = item.item;
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
    const selectedOptions = document.getElementById('selectedItems').selectedOptions;

    // Extract item and category from selected options
    const selectedItems = Array.from(selectedOptions).map(option => option.value);
    const itemCategories = Array.from(selectedOptions).map(option => option.getAttribute('data-category'));

    // Create an object with the form data
    const formData = {
        title: title,
        body: body,
        selectedItems: selectedItems,
        itemCategories: itemCategories
    };

    // Send data using AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'process_announcement.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // Handle the response
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    document.getElementById('successMessage').innerHTML = 'Announcement added successfully!';

                    // Display selected items and categories in the success message
                    const selectedItemsMessage = selectedItems.map((item, index) => `${itemCategories[index]}: ${item}`).join(', ');
                    document.getElementById('selectedItemsMessage').innerHTML = `Selected Items: ${selectedItemsMessage}`;
                } else {
                    document.getElementById('successMessage').innerHTML = 'Error adding announcement.';
                }
            } else {
                console.error('Error: ' + xhr.statusText);
            }
        }
    };
    xhr.send(JSON.stringify(formData));s
}

// Fetch items when the page loads
window.onload = fetchItems;
