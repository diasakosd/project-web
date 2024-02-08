document.getElementById('registerForm').addEventListener('submit', function (event) {
    event.preventDefault(); //Prevent the default form submission

    //Get the username
    const usernameInput = document.getElementById('username').value;

    //check if the username exists
    checkRegisterUser(usernameInput);
});

//check if the username exists using AJAX
function checkRegisterUser(username) {
    //Create a new XMLHttpRequest object
    const xhr = new XMLHttpRequest();

    //POST request to check_register_user.php
    xhr.open('POST', 'check_register_user.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                //Parse the JSON response
                const response = JSON.parse(xhr.responseText);

                //Check if the username exists
                if (response.userExists) {
                    //Display error message
                    displayErrorMessage("This user already exists");
                } else {
                    //Set the reg_user parameter to true
                    const regInput = document.createElement('input');
                    regInput.type = 'hidden';
                    regInput.name = 'reg_user';
                    regInput.value = 'true';
                    document.getElementById('registerForm').appendChild(regInput);

                    //Check if form validation is successful before submitting
                    if (validateForm()) {
                        //Submit the form using AJAX
                        submitFormWithAjax();
                    } else {
                        displayErrorMessage("Form validation failed.");
                    }
                }
            } else {
                console.error('Error checking username existence');
            }
        }
    };

    //Send the request with the data
    xhr.send(`username=${username}`);
}

//Function to display error message
function displayErrorMessage(message) {
    const errorMessageContainer = document.querySelector(".error_message");
    errorMessageContainer.innerHTML = `<p style="color: red;">${message}</p>`;
}

// Function to submit the form using AJAX
function submitFormWithAjax() {
    const formData = new FormData(document.getElementById('registerForm'));
    const xhr = new XMLHttpRequest();

    xhr.open('POST', 'register_get.php', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Parse the JSON response
            const response = JSON.parse(xhr.responseText);

            if (response.success) {
                // Redirect using JavaScript
                window.location.href = response.redirect;

                // Reload the page after redirection
                window.location.reload();
            } else {
                // Display the response message
                displayErrorMessage("Registration failed: " + response.error);
            }
        }
    };

    xhr.send(formData);
}
