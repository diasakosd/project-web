$(document).ready(function () {
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

                    if (newValue < 0) {
                        alert('Base does not hold that much quantity. Please enter a valid value.');
                    } else {
                        baseQuantityCell.text(newValue);
                        baseQuantityCell.addClass('edited-cell');
                            // Call the function to get base coordinates
                            getBaseCoords();
                            getRescuerCoords();

                        // Update the quantity in the database using jQuery AJAX
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

    function updateQuantityInDatabase(itemId, newQuantity, category, item, baselat, baselon, resclat, resclat) {
        console.log('Updating quantity in the database');
        $.ajax({
            url: 'Cargo_Manag.php',
            method: 'POST',
            data: { action: 'updateQuantity', item_id: itemId, quantity: newQuantity, category: category, item: item, rescuerLat: resclat, rescuerLon: resclat, baseLat: baselat, baseLon: baselon },
            success: function (response) {
                console.log('Update success:', response);
                // Handle the response as needed, e.g., display a success message
            },
            error: function (xhr, status, error) {
                console.error('Update error:', status, error);
            }
        });
    }    
let baselat, baselon, resclat, resclon;
    function getRescuerCoords(){
        $.ajax({
            url: 'location_currResc.php',
            method: 'GET',
            success: function(response){
                console.log("Rescuer Coordinates Received", response);
                try {
                    var rescCoords = JSON.parse(response);
                    console.log("Parsed Rescuer Coordinates:", rescCoords);
                    resclat = rescCoords.latitude; resclon = rescCoords.longitude;
                } catch (error) {
                    console.error("Error parsing JSON: ", error);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX request error: ", status, error);
            }
        });
    }
/*
    function postRescCoords(lat, lon){
        $.ajax({
            url: 'Cargo_Manag.php',
            method: 'POST',
            data: { action: 'postRescCoords', rescuerLat: lat, rescuerLon: lon },
            success: function (response){
                console.log(response);
            },
            error: function (xhr, status, error) {
                console.error("AJAX request error: ", status, error);
            }
        });
    }*/

    function getBaseCoords(){
        $.ajax({
            url: 'base_map.php',
            method: 'GET',
            success: function (response) {
                console.log("Base Coordinates Received", response);
                try {
                    var baseCoords = JSON.parse(response);
                    console.log("Parsed Base Coordinates:", baseCoords);
                    baselat = baseCoords.latitude; baselon = baseCoords.longitude;
                } catch (error) {
                    console.error("Error parsing JSON: ", error);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX request error: ", status, error);
            }
        });
    }
/*
    function postBaseCoords(baselat, baselon){
        $.ajax({
            url: 'Cargo_Manag.php',
            method: 'POST',
            data: { action: 'postBaseCoords', baselat: baselat, baselon: baselon },
            success: function (response){
                console.log(response);
            },
            error: function (xhr, status, error) {
                console.error("AJAX request error: ", status, error);
            }
        });
    }*/


});
