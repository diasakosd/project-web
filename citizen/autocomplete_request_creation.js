// autocomplete_request_creation.js

document.addEventListener('DOMContentLoaded', function () {
    var categoryInput = document.getElementById('autocompleteCategory');
    var itemInput = document.getElementById('autocompleteItem');

    categoryInput.addEventListener('input', function () {
        updateAutocomplete('category', categoryInput.value, 'categoryList');
        itemInput.value = ''; // Clear item input when category changes
    });

    itemInput.addEventListener('input', function () {
        updateAutocomplete('item', itemInput.value, 'itemList', categoryInput.value);
    });

    function updateAutocomplete(type, input, listId, selectedCategory) {
        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var dataList = document.getElementById(listId);
                dataList.innerHTML = xhr.responseText;
            }
        };

        var url = 'fetch_autocomplete.php?type=' + type + '&input=' + input;

        if (type === 'item' && selectedCategory) {
            url += '&category=' + selectedCategory;
        }

        xhr.open('GET', url, true);
        xhr.send();
    }
});
