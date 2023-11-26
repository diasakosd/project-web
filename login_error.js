document.addEventListener("DOMContentLoaded", function () {
    // Function to display error message
    function displayErrorMessage(message) {
        const errorMessageContainer = document.querySelector(".error_message");
        errorMessageContainer.innerHTML = `<p style="color: red;">${message}</p>`;
    }

    // Function to check if the username and password match using AJAX
    function checkUser(username, password) {
        // Create a new XMLHttpRequest object
        const xhr = new XMLHttpRequest();

        // Set up a POST request to check_user.php
        xhr.open('POST', 'check_user.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        // Define the callback function for when the request is complete
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    // Parse the JSON response
                    const response = JSON.parse(xhr.responseText);

                    // Check if the username and password match
                    if (response.userMatch) {
                        // Submit the form directly
                        const loginInput = document.createElement('input');
                        loginInput.type = 'hidden';
                        loginInput.name = 'login_user';
                        loginInput.value = 'true';
                        loginForm.appendChild(loginInput);
                        document.getElementById('loginForm').submit();
                    } else {
                        // Display error message
                        displayErrorMessage("Wrong credentials");
                    }
                } else {
                    console.error('Error checking username and password');
                }
            }
        };

        // Send the request with the data
        xhr.send(`username=${username}&password=${password}`);
    }

    // Attach the checkUser function to the form submission
    document.getElementById('loginForm').addEventListener('submit', function (event) {
        event.preventDefault();

        // Get the username and password input values
        const usernameInput = document.getElementById('username').value;
        const passwordInput = document.getElementById('password').value;

        // Call the function to check if the username and password match
        checkUser(usernameInput, passwordInput);
    });
});
