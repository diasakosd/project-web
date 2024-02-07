// url-file-validate.js
var flag = 0;
document.addEventListener('DOMContentLoaded', function () {
    //Attach submit event to the form
    var form = document.querySelector('#jsonForm');
    form.addEventListener('submit', function (event) {
        event.preventDefault();  //Prevent the default form submission

        // Get the data
        var formData = new FormData(form);

        //AJAX request 
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'table_storage.php', true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                //Update the message container with the response
                document.getElementById('messageContainer').textContent = xhr.responseText;
                document.getElementById('updateTableBtn').click();
            }
        };

        //Send the data
        xhr.send(formData);
    });
});
