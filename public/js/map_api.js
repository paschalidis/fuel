//Map Values
var map = null;
var markers = []; // Create a new blank array for all the listing markers.

document.getElementById('zoom-to-area').addEventListener('click', function() {
    zoomToArea();
});

$('#zoom-to-area-text').keypress(function (e) {
    if (e.which == 13) {
        $("#zoom-to-area").click();
        return false;    //<---- Add this line
    }
});

//Initialized JavaScript functions to load the map
function initMap() {
    // Constructor creates a new map - only center and zoom are required.
    //Used in callback

    var Greece = new google.maps.LatLng(37.840834994646166, 23.74952344409178);
    //New map Instance
    map = new google.maps.Map(document.getElementById('map'), {
        center: Greece,
        zoom: 6,
        mapTypeControl: false
    });

    // Try HTML5 geolocation.
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            map.setCenter(pos);
            map.setZoom(14);
        }, function() {
            handleLocationError(true);
        });
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false);
    }

    map.addListener('idle', function() {
        cleanMarkers();
        getGasStations();
    });

}

function createMarket(_posistion, _title, imageID) {

    var marker = new google.maps.Marker({
        map: map,
        position: _posistion,
        title: _title,
        icon: '/img/gas_logos/'+ imageID +'.png'
    });

    return marker;
}

function handleLocationError(browserHasGeolocation) {
    var errorMessage = "Your browser doesn\'t support geolocation.";

    if(browserHasGeolocation){
        errorMessage  = 'The Geolocation service failed.';
    }

    $.notify({ message: errorMessage
    },{
        type: 'warning',
        placement: {
            from: "top",
            align: "center"
        }
    });
}
// This function populates the infowindow when the marker is clicked. We'll only allow
// one infowindow which will open at the marker that is clicked, and populate based
// on that markers position.
function populateInfoWindow(marker, infowindow, gasStation) {
    // Check to make sure the infowindow is not already opened on this marker.
    if (infowindow.marker != marker) {
        infowindow.marker = marker;

        var phone = gasStation.phone1;
        if(phone == null){
            phone = "";
        }

        var image = '<img src="/img/gas_logos/'+ gasStation.fuelCompID + '.png" class="img-responsive"' +
                                    ' alt="' + gasStation.fuelCompNormalName + '">';

        var priceDataButton = '<button type="button" class="btn btn-primary" data-gasstationid="' +
                                gasStation.gasStationID + '" data-toggle="modal" data-target="#priceDataModal"' +
                                 ' data-action="order">Price Data</button>';

        var infoWindowContent = '<ul class="list-group">' +
                        '<li>' + image +'<h4>' + gasStation.fuelCompNormalName + '</h4></li>' +
                        '<li>' + gasStation.gasStationOwner +'</li>' +
                        '<li>' + gasStation.gasStationAddress +'</li>' +
                        '<li>' + phone +'</li>' +
                        '<li>' + priceDataButton +'</li>' +
                    '</ul>'

        infowindow.setContent(infoWindowContent);
        infowindow.open(map, marker);
        // Make sure the marker property is cleared if the infowindow is closed.
        infowindow.addListener('closeclick',function(){
            infowindow.setMarker(null);
        });
    }
}

function cleanMarkers() {
    for (var i=0; i<markers.length; i++){
        markers[i].setMap(null);
    }
    //άδειασμα και του πίνακα με τα references
    markers=[];
}

// This function takes the input value in the find nearby area text input
// locates it, and then zooms into that area. This is so that the user can
// show all listings, then decide to focus on one area of the map.
function zoomToArea() {
    // Initialize the geocoder.
    var geocoder = new google.maps.Geocoder();
    // Get the address or place that the user entered.
    var address = document.getElementById('zoom-to-area-text').value;
    // Make sure the address isn't blank.
    if (address == '') {
        $.notify({
            // options
            message: 'You must enter an area, or address.'
        },{
            // settings
            type: 'danger',
            placement: {
                from: "top",
                align: "center"
            }
        });
    } else {
        // Geocode the address/area entered to get the center. Then, center the map
        // on it and zoom in
        geocoder.geocode(
            { address: address
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);
                    map.setZoom(14);
                } else {
                    $.notify({
                        // options
                        message: 'We could not find that location - try entering a more' +
                        ' specific place.'
                    },{
                        // settings
                        type: 'danger',
                        placement: {
                            from: "top",
                            align: "center"
                        }
                    });
                }
            });
    }
}