document.addEventListener("DOMContentLoaded", function () {
    // Function to display error message
    function displayErrorMessage(message) {
        const errorMessageContainer = document.querySelector(".error_message");
        errorMessageContainer.innerHTML = `<p style="color: red;">${message}</p>`;
    }

    // Function to check if the username exists using AJAX
    function checkRegisterUser(username) {
        // Create a new XMLHttpRequest object
        const xhr = new XMLHttpRequest();

        // Set up a POST request to check_register_user.php
        xhr.open('POST', 'check_register_user.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        // Define the callback function for when the request is complete
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    // Parse the JSON response
                    const response = JSON.parse(xhr.responseText);

                    // Check if the username exists
                    if (response.userExists) {
                        // Display error message
                        displayErrorMessage("This user already exists");
                    } else {
                        // Set the reg_user parameter to true
                        const regInput = document.createElement('input');
                        regInput.type = 'hidden';
                        regInput.name = 'reg_user';
                        regInput.value = 'true';
                        registerForm.appendChild(regInput);
                        document.getElementById('registerForm').submit();
                    }
                } else {
                    console.error('Error checking username existence');
                }
            }
        };

        // Send the request with the data
        xhr.send(`username=${username}`);
    }

    // Attach the checkRegisterUser function to the form submission
    document.getElementById('registerForm').addEventListener('submit', function (event) {
        event.preventDefault();

        // Get the username input value
        const usernameInput = document.getElementById('username').value;

        // Call the function to check if the username exists
        checkRegisterUser(usernameInput);
    });
});
