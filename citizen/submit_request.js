

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('dropdownForm').addEventListener('submit', function (event) {
        event.preventDefault(); //Prevent the default form submission

        var category = document.getElementById('dropdownCategory').value;
        var item = document.getElementById('dropdownItem').value;
        var quantity = document.getElementById('dropdownNumber').value;

        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                //Handle the response (e.g., display a success message)
                alert(xhr.responseText);
            }
        };

        xhr.open('POST', 'submit_request.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('category=' + category + '&item=' + item + '&quantity=' + quantity);
    });
});
