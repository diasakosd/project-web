//Vanilla JavaScript version without jQuery
document.addEventListener("DOMContentLoaded", function () {
    //Fetch admin name using AJAX
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var data = JSON.parse(xhr.responseText);

            if (data.citizenName) {
                //Update the header with the admin name
                document.querySelector('.header').innerHTML = '<h1>Welcome, ' + data.citizenName + '!</h1>';
            } else {
                console.error('Citizen name not found');
            }
        } else if (xhr.readyState == 4) {
            console.error('Error fetching citizen name');
        }
    };

    xhr.open('GET', 'get_citizen_details.php', true);
    xhr.send();
});
