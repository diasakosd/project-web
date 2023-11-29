// Declare flag in the global scope
var flag = 0;

document.addEventListener('DOMContentLoaded', function () {
    // Attach submit event to the form
    var form = document.querySelector('form');
    form.addEventListener('submit', function (event) {
        // Check if both URL and file are provided
        var url = document.getElementById('url').value;
        var fileInput = document.getElementById('file');

        if (url.trim() === '' && fileInput.files.length === 0) {
            // Prevent form submission
            event.preventDefault();
            flag = 0;
        } else if (url.trim() !== '' && fileInput.files.length > 0) {
            // Prevent form submission
            event.preventDefault();
            flag = 0;
        } else {
            flag = 1;
        }
        
    });
});

function validate_url_file() {
    if (flag) {
        return true;
    }
}
