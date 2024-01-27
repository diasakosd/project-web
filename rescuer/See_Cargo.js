$(document).ready(function () {

    function updateQuantityInD(itemId, newQuantity, category, item) {
        console.log('Updating quantity in the database');
        $.ajax({
            url: 'See_Cargo.php',
            method: 'POST',
            data: { quantity: newQuantity, category: category, item: item },
            success: function (response) {
                console.log('Update success:', response);
            },
            error: function (xhr, status, error) {
                console.error('Update error:', status, error);
            }
        });
    }

    var dischargeButton = document.getElementById('dischargeBtn');

    dischargeButton.addEventListener('click', function () {
        console.log('dischargeBtn clicked');
        var selectedQuantity = $('#setToBaseItem').val();

        if (selectedQuantity !== "") {
            var numericQuantity = parseFloat(selectedQuantity);

            if (numericQuantity > 0) {
                $('input[type="checkbox"]:checked').each(function () {
                    var row = $(this).closest('tr');

                    // Retrieve data from the row
                    var rescuerQuantityCell = row.find('.editable-cell');
                    var itemId = rescuerQuantityCell.data('item-id');
                    var category = row.find('.category-cell').text();
                    var item = row.find('.item-cell').text();
                    
                    var rescuerQuantity = row.find('.quantity-cell').text() || 0;

                    var newValue = rescuerQuantity - numericQuantity;

                    if (newValue < 0) {
                        alert('You do not hold that much quantity. Please enter a valid value.');
                    } else if(rescuerQuantity>0){
                        rescuerQuantityCell.text(newValue);
                        rescuerQuantityCell.addClass('edited-cell');

                        // Update the quantity in the database using jQuery AJAX
                        updateQuantityInD(itemId, numericQuantity, category, item);
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
