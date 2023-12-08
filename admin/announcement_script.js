// announcement_script.js

function submitForm() {
    var title = document.getElementById('title').value;
    var body = document.getElementById('body').value;

    // Use AJAX to submit the form data
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'process_announcement.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Handle the response, e.g., display a success message
            document.getElementById('successMessage').innerHTML = xhr.responseText;
        }
    };

    // Send the form data as URL-encoded parameters
    var formData = 'title=' + encodeURIComponent(title) + '&body=' + encodeURIComponent(body) + '&submit=true';
    xhr.send(formData);
}
