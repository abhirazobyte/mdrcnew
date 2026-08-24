<style>
input.error,select.error,textarea.error
{
	border:1px solid red !important;
}
</style>

<link rel="stylesheet" href="js/notify/jquery.toastmessage.css">
<script src="js/notify/jquery.toastmessage.js"></script>

<?php if($this->getCurrentView()!="checkout"){?>
<link rel="stylesheet" href="js/searchjs/jquery-ui.min.css">
<script src="js/searchjs/jquery-ui.min.js"></script>
<?php }?>

<script src="js/jquery.validate.min.js"></script>
<script src="js/generalscript.js?v=2.04"></script>

<?php if($this->getCurrentView()=="radiology" || $this->getCurrentView()=="pathology" || $this->getCurrentView()=="search" || $this->getCurrentView()=="search" || $this->getCurrentView()=="diseases" || $this->getCurrentView()=="category" || $this->getCurrentView()=="premium_health_checkup"){?>

<script src="js/packages.js?v=1.1"></script>

<?php }?>



<?php if($this->getCurrentView()=="blog"){?>
<script src="js/blogscript.js"></script>
<?php }?>

<?php if($this->getCurrentView()=="news_and_events"){?>
<script src="js/event.js"></script>
<?php }?>



<?php if($this->getCurrentView()=="my_family_friends" || $this->getCurrentView()=="my_addresses"){?>

<link href="js/alert/css/sweet-alert.css" rel="stylesheet" type="text/css" />

<script src="js/alert/js/sweet-alert.min.js"></script>

<script src="js/alert/js/jquery.sweet-alert.init.js"></script>

<?php }?>





<?php if($this->getCurrentView()=="my_wallet"){?>

<script src="js/load_wallet_transction.js"></script>

<?php }?>



<?php if($this->getCurrentView()=="cart"){?>

<link href="js/alert/css/sweet-alert.css" rel="stylesheet" type="text/css" />

<script src="js/alert/js/sweet-alert.min.js"></script>

<script src="js/alert/js/jquery.sweet-alert.init.js"></script>

<script src="js/load_cart.js?ver=1.0"></script>

<?php }?>



<?php if($this->getCurrentView()=="checkout"){?>

<link href="js/alert/css/sweet-alert.css" rel="stylesheet" type="text/css" />

<script src="js/alert/js/sweet-alert.min.js"></script>

<script src="js/alert/js/jquery.sweet-alert.init.js"></script>

<script src="js/load_checkout.js?v=1.1"></script>

<?php }?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>



<?php if($this->rs_customer['name']=='' && $_SESSION['MDRCCustID']!=''){?>
<script>
$(document).ready(function(){            
	if ($.cookie('MDRCProfileDetail')) { //if cookie isset
	   
	} else {
		$.cookie("MDRCProfileDetail", "Yes", { expires: 1, secure: true , domain: 'mdrcindia.com'});
		$('#offcanvasExample-signup').offcanvas('show');
	}       
});

</script>
<?php }?>

<!-- EXTERNAL API REMOVED: Google Maps -->
<script>
$(document).ready(function(){            
	if ($.cookie('MDRCCitySelect')) { //if cookie isset
	   
	} else {
		getLocation();
	}       
});

function getLocation(){
    $.cookie("MDRCCitySelect", "Yes", { expires: 1, secure: true , domain: 'mdrcindia.com'});
	var x = document.getElementById("googleMapApiResult");
    if (navigator.geolocation){
        navigator.geolocation.getCurrentPosition(showPosition,showError);
    }
    else{
        x.innerHTML="Geolocation is not supported by this browser.";
    }
}

function showPosition(position){
    lat=position.coords.latitude;
    lon=position.coords.longitude;
    displayLocation(lat,lon);
}

function showError(error){
	var x = document.getElementById("googleMapApiResult");
    x.innerHTML="<button type='button' class='closes btn-main bg-btn1 btn-blue lnk wow fadeInUp text-uppercase' data-bs-dismiss='modal'>Proceed to website</button>"
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

function displayLocation(latitude,longitude){
	var x = document.getElementById("googleMapApiResult");
    var geocoder;
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(latitude, longitude);

    geocoder.geocode(
        {'latLng': latlng}, 
        function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
					
                    var add= results[0].formatted_address ;
                    console.log(add);
                    var  value=add.split(",");

                    count=value.length;
                    country=value[count-1];
                    state=value[count-2];
                    city=value[count-3];
                    //x.innerHTML = "city name is: " + city;
                    console.log(city);
					if(city!='')
					{
						var dataString ='method=selectCityUsingGoogleMapApi&cityName='+city;
						$.ajax({
							type: "POST",
							url: "scripts/ajax/index.php",
							dataType:'json',
							data: dataString,
							success:function(data, textStatus, XMLHttpRequest){
								if(data.RESULT=="OK") {
									if(data.URL!=''){
										location.href = data.URL;
									} else {
										location.reload();
									}
								}
                                else if(data.RESULT=="SAME")
                                {

                                } else {
									x.innerHTML = "We are not available at "+city;
								}
							}
						});
					}
					else{
						x.innerHTML = "address not found";
					}
                }
                else  {
                    x.innerHTML = "address not found";
                }
            }
            else {
                x.innerHTML = "Geocoder failed due to: " + status;
            }
        }
    );
}
</script>










