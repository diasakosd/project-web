// url-file-validate.js
document.addEventListener('DOMContentLoaded', function () {
    // Attach submit event to the form
    var form = document.getElementById('updateTableForm');
    form.addEventListener('submit', function (event) {
        event.preventDefault();  // Prevent the default form submission

        // Get the form data
        var formData = new FormData(form);

        // Make an AJAX request
        var xhr = new XMLHttpRequest();
        xhr.open('POST', form.action, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Update the message container with the response
                document.querySelector('.err_message').textContent = xhr.responseText;
                document.getElementById('updateTableBtn').click();
            }
        };

        // Send the form data
        xhr.send(formData);
    });
});
