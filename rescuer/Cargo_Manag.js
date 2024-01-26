$(document).ready(function () {
    let resclat1, resclon1; let baselat1, baselon1;

    function getBaseCoords(){
        $.ajax({
            url: 'base_map.php',
            method: 'GET',
            success: function (response) {
                console.log("Base Coordinates Received", response);
                try {
                    var baseCoords = JSON.parse(response);
                    console.log("Parsed Base Coordinates:", baseCoords);
                    baselat1 = baseCoords.latitude; baselon1 = baseCoords.longitude;
                } catch (error) {
                    console.error("Error parsing JSON: ", error);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX request error: ", status, error);
            }
        });
    }
    function getRescuerCoords(){
        $.ajax({
            url: 'location_currResc.php',
            method: 'GET',
            success: function(response){
                console.log("Rescuer Coordinates Received", response);
                try {
                    var rescCoords = JSON.parse(response);
                    console.log("Parsed Rescuer Coordinates:", rescCoords);
                    resclat1 = rescCoords.latitude; resclon1 = rescCoords.longitude;
                    getBaseCoords();
                } catch (error) {
                    console.error("Error parsing JSON: ", error);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX request error: ", status, error);
            }
        });
    }

    function updateQuantityInDatabase(itemId, newQuantity, category, item, baselat, baselon, resclat, resclon) {
        console.log('Updating quantity in the database');
        $.ajax({
            url: 'Cargo_Manag.php',
            method: 'POST',
            data: {  item_id: itemId, quantity: newQuantity, category: category, item: item, baseLat: baselat, baseLon: baselon, rescuerLat: resclat, rescuerLon: resclon },
            success: function (response) {
                console.log('Update success:', response);
                // Handle the response as needed, e.g., display a success message
            },
            error: function (xhr, status, error) {
                console.error('Update error:', status, error);
            }
        });
    } 
    console.log("Before getBaseCoords and getRescuerCoords");
// Call the function to get base coordinates
getRescuerCoords();
// Call the function to get rescuer coordinates

console.log("After getBaseCoords and getRescuerCoords");

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
                    var category = row.find('.category-cell').text(); // Replace with the actual class or identifier
                    var item = row.find('.item-cell').text(); // Replace with the actual class or identifier
                    var newValue = baseQuantity - numericQuantity;
                    var x3 = resclat1;
                    var x4 = resclon1;
                    var x1 = baselat1;
                    var x2 = baselon1;

                    
                    
                    if (newValue < 0) {
                        alert('Base does not hold that much quantity. Please enter a valid value.');
                    } else {
                        baseQuantityCell.text(newValue);
                        baseQuantityCell.addClass('edited-cell');

                        // Update the quantity in the database using jQuery AJAX
                        updateQuantityInDatabase(itemId, newValue, category, item, x1, x2, x3, x4);
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
