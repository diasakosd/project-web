

document.addEventListener('DOMContentLoaded', function () {
    //Fetch and populate the category dropdown
    var xhrCategory = new XMLHttpRequest();

    xhrCategory.onreadystatechange = function () {
        if (xhrCategory.readyState == 4 && xhrCategory.status == 200) {
            document.getElementById('dropdownCategory').innerHTML = xhrCategory.responseText;
        }
    };

    xhrCategory.open('GET', 'fetch_categories.php', true);
    xhrCategory.send();

  
    document.getElementById('dropdownCategory').addEventListener('change', function () {
        var category = this.value;
        var xhrItem = new XMLHttpRequest();

        xhrItem.onreadystatechange = function () {
            if (xhrItem.readyState == 4 && xhrItem.status == 200) {
                document.getElementById('dropdownItem').innerHTML = xhrItem.responseText;
            }
        };

        xhrItem.open('POST', 'fetch_dropdown.php', true);
        xhrItem.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhrItem.send('category=' + category);
    });
});
