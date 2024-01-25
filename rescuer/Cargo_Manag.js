$(document).ready(function () {
    var loadButton = document.getElementById('LoadBtn');

    loadButton.addEventListener('click', function () {
        var selectedQuantity = $('#getFromBaseItem').val();
        if (selectedQuantity !== "") {
            var numericQuantity = parseFloat(selectedQuantity);

            if (numericQuantity > 0) {
                $('input[type="checkbox"]:checked').each(function () {
                    var row = $(this).closest('tr');
                    var baseQuantityCell = row.find('.editable-cell');
                    var itemId = baseQuantityCell.data('item-id');
                    var baseQuantity = parseFloat(baseQuantityCell.text()) || 0;
                    var newValue = baseQuantity - numericQuantity;

                    if (newValue < 0) {
                        alert('Base does not hold that much quantity. Please enter a valid value.');
                    } else {
                        baseQuantityCell.text(newValue);
                        baseQuantityCell.addClass('edited-cell');

                        // Update the quantity in the database using jQuery AJAX
                        updateQuantityInDatabase(itemId, newValue);
                    }
                });
            } else {
                alert('Please enter a valid quantity.');
            }
        } else {
            alert('Please select a row or enter a quantity.');
        }
    });

    function updateQuantityInDatabase(itemId, newQuantity) {
        $.ajax({
            url: 'Cargo_Manag.php',
            method: 'POST',
            data: { item_id: itemId, quantity: newQuantity },
            success: function (response) {
                console.log(response);
                // Handle the response as needed, e.g., display a success message
            },
            error: function (xhr, status, error) {
                console.error("AJAX request error: ", status, error);
            }
        });
    }    

});
