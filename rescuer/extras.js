// Functions for additional functionalities or actions
document.addEventListener('DOMContentLoaded', function () {
    var dischargeButton = document.getElementById('dischargeBtn');

    dischargeButton.addEventListener('click', function () {
        var errorOccurred = true;

        if (errorOccurred) {
            alert('Error: Unable to discharge cargo. You need to be at most 100m away from the base.');
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    var loadButton = document.getElementById('LoadBtn');

    loadButton.addEventListener('click', function () {
        // Add your custom load button logic here
        var selectedQuantity = document.getElementById('getFromBaseItem').value;
        if (selectedQuantity !== "") {
            var numericQuantity = parseFloat(selectedQuantity);

            if (numericQuantity > 0) {
                // Update the quantity for selected rows
                var checkedRows = document.querySelectorAll('input[type="checkbox"]:checked');
                checkedRows.forEach(function (checkbox) {
                    var row = checkbox.closest('tr');
                    var baseQuantityCell = row.querySelector('.editable-cell');
                    var baseQuantity = parseFloat(baseQuantityCell.textContent) || 0;
                    var itemId = baseQuantityCell.dataset.itemId;
                    var newValue = baseQuantity - numericQuantity;

                    // Perform validation or additional checks if needed
                    if (newValue < 0) {
                        alert('Base does not hold that much quantity. Please enter a valid value.');
                    } else {
                        // Update the quantity cell
                        baseQuantityCell.textContent = newValue;
                        baseQuantityCell.classList.add('edited-cell'); // Add the class to mark it as edited
                    }
                });
            } else {
                alert('Please enter a valid quantity.');
            }
        } else {
            alert('Please select a row or enter a quantity.');
        }
    });
});




document.addEventListener("DOMContentLoaded", function() {
    const checkbox = document.getElementById('check');
    const sidebar = document.getElementById('sidebar');
    const chBtn = document.querySelector('.chBtn');
    const chBtn2 = document.querySelector('.chBtn2');

    checkbox.addEventListener('change', function() {
        if (this.checked) {
            sidebar.style.width = '250px'; // Show sidebar by setting its width
            chBtn.style.display = 'none'; // Show chBtn
        } else {
            sidebar.style.width = '0'; // Hide sidebar by setting its width to 0
        }
    });

    chBtn2.addEventListener('click', function() {
        if (checkbox.checked) {
            chBtn.style.display = 'block'; // Show chBtn when chBtn2 is clicked and sidebar is checked
        }
    });
});