// Vanilla JavaScript version without jQuery
document.addEventListener("DOMContentLoaded", function () {
    // Fetch admin name using AJAX
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var data = JSON.parse(xhr.responseText);

            if (data.rescuerName) {
                // Update the header with the admin name
                document.querySelector('.header').innerHTML = '<h1>Welcome, ' + data.rescuerName + '!</h1>';
            } else {
                console.error('Rescuer name not found');
            }
        } else if (xhr.readyState == 4) {
            console.error('Error fetching rescuer name');
        }
    };

    xhr.open('GET', 'get_rescuer_details.php', true);
    xhr.send();
});
