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

/*    function getBaseCoords(){
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

    function postRescCoords(resclat, resclon, baselat, baselon){
        $.ajax({
            url: 'Cargo_Manag.php',
            method: 'POST',
            data: {  rescuerLat: resclat, rescuerLon: resclon, baseLat: baselat, baseLon: baselon },
            success: function (response){
                console.log(response);
            },
            error: function (xhr, status, error) {
                console.error("AJAX request error: ", status, error);
            }
        });
    }*/