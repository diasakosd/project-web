
document.addEventListener("DOMContentLoaded", function () {
    //Create XMLHttpRequest for AJAX method
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var data = JSON.parse(xhr.responseText);
            //adminName sent from php Mysql
            if (data.adminName) {
                //Update the header with the admin name in html
                document.querySelector('.header').innerHTML = '<h1>Welcome, ' + data.adminName + '!</h1>';
            } else {
                console.error('Admin name not found');
            }
        } else if (xhr.readyState == 4) {
            console.error('Error fetching admin name');
        }
    };
    //Get request from Mysql
    xhr.open('GET', 'get_admin_details.php', true);
    xhr.send();
});
