
function getLocation() {
    var x = document.getElementById("googleMapApiResult");
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    }
    else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    lat = position.coords.latitude;
    lon = position.coords.longitude;
    displayLocation(lat, lon);
}

function showError(error) {
    var x = document.getElementById("googleMapApiResult");
    x.innerHTML = "<button type='button' class='closes btn-main bg-btn1 btn-blue lnk wow fadeInUp text-uppercase' data-bs-dismiss='modal'>Proceed to website</button>"
    /* switch(error.code){
        case error.PERMISSION_DENIED:
            x.innerHTML="User denied the request for Geolocation."
        break;
        case error.POSITION_UNAVAILABLE:
            x.innerHTML="Location information is unavailable."
        break;
        case error.TIMEOUT:
            x.innerHTML="The request to get user location timed out."
        break;
        case error.UNKNOWN_ERROR:
            x.innerHTML="An unknown error occurred."
        break;
    } */
}

function displayLocation(latitude, longitude) {
    var x = document.getElementById("googleMapApiResult");
    var geocoder;
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(latitude, longitude);

    geocoder.geocode(
        { 'latLng': latlng },
        function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {

                    var add = results[0].formatted_address;
                    console.log(add);
                    var value = add.split(",");

                    count = value.length;
                    country = value[count - 1];
                    state = value[count - 2];
                    city = value[count - 3];
                    //x.innerHTML = "city name is: " + city;
                    console.log(city);
                    if (city != '') {
                        var dataString = 'method=selectCityUsingGoogleMapApi&cityName=' + city;
                        $.ajax({
                            type: "POST",
                            url: "../scripts/ajax/index.php",
                            dataType: 'json',
                            data: dataString,
                            success: function (data, textStatus, XMLHttpRequest) {
                                if (data.RESULT == "OK") {
                                    if (data.URL != '') {
                                        location.href = data.URL;
                                    } else {
                                        location.reload();
                                    }
                                }
                                else {
                                    x.innerHTML = "We are not available at " + city;
                                }
                            }
                        });
                    }
                    else {
                        x.innerHTML = "address not found";
                    }
                }
                else {
                    x.innerHTML = "address not found";
                }
            }
            else {
                x.innerHTML = "Geocoder failed due to: " + status;
            }
        }
    );
}