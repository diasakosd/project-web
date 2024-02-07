$(document).ready(function () {


    function updateQuantityInDatabase(itemId, newQuantity, category, item) {
        console.log('Updating quantity in the database');
        $.ajax({
            url: 'Cargo_Manag.php',
            method: 'POST',
            data: {  item_id: itemId, quantity: newQuantity, category: category, item: item },
            success: function (response) {
                console.log('Update success:', response);
            },
            error: function (xhr, status, error) {
                console.error('Update error:', status, error);
            }
        });
    } 

    var loadButton = document.getElementById('LoadBtn');

    loadButton.addEventListener('click', function () {
        console.log('LoadBtn clicked');
        var selectedQuantity = $('#getFromBaseItem').val();

        if (selectedQuantity !== "") {
            var numericQuantity = parseFloat(selectedQuantity);

            if (numericQuantity > 0) {
                $('input[type="checkbox"]:checked').each(function () {
                    var row = $(this).closest('tr');
                    var baseQuantityCell = row.find('.editable-cell');
                    var itemId = baseQuantityCell.data('item-id');
                    var baseQuantity = parseFloat(baseQuantityCell.text()) || 0;
                    var category = row.find('.category-cell').text(); 
                    var item = row.find('.item-cell').text(); 
                    var newValue = baseQuantity - numericQuantity;
                    
                    if (newValue < 0) {
                        alert('Base does not hold that much quantity. Please enter a valid value.');
                    } else {
                        baseQuantityCell.text(newValue);
                        baseQuantityCell.addClass('edited-cell');
                        updateQuantityInDatabase(itemId, newValue, category, item);
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
