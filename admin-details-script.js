// Vanilla JavaScript version without jQuery
document.addEventListener("DOMContentLoaded", function () {
    // Fetch admin name using AJAX
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var data = JSON.parse(xhr.responseText);

            if (data.adminName) {
                // Update the header with the admin name
                document.querySelector('.header').innerHTML = '<h1>Welcome, ' + data.adminName + '!</h1>';
            } else {
                console.error('Admin name not found');
            }
        } else if (xhr.readyState == 4) {
            console.error('Error fetching admin name');
        }
    };

    xhr.open('GET', 'get_admin_details.php', true);
    xhr.send();
});
