// url-file-validate.js
var flag = 0;
document.addEventListener('DOMContentLoaded', function () {
    // Attach submit event to the form
    var form = document.querySelector('form');
    form.addEventListener('submit', function (event) {
        event.preventDefault();  // Prevent the default form submission

        // Get the form data
        var formData = new FormData(form);

        // Make an AJAX request
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'table_storage.php', true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Update the message container with the response
                document.getElementById('messageContainer').textContent = xhr.responseText;
            }
        };

        // Send the form data
        xhr.send(formData);
    });
});
