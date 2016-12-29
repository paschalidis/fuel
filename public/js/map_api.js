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

    map.addListener('idle', function() {
        // 3 seconds after the center of the map has changed, pan back to the
        // marker.
        cleanMarkers();
        // window.setTimeout(function() {
        getGasStations();
        //}, 1000);
    });

}

// This function populates the infowindow when the marker is clicked. We'll only allow
// one infowindow which will open at the marker that is clicked, and populate based
// on that markers position.
function populateInfoWindow(marker, infowindow) {
    // Check to make sure the infowindow is not already opened on this marker.
    if (infowindow.marker != marker) {
        infowindow.marker = marker;
        infowindow.setContent('<div>' + marker.title + '</div>' +
            '<div><a href="#" data-gasstationid="' + marker.id +
            '" data-toggle="modal" data-target="#priceDataModal"' +
            ' data-action="order">Price Data</a></div>');
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

function initMap2() {
    var initCenter = new google.maps.LatLng(39.6315214,22.4464073);
    var mapOptions = {//create the map object
        center:initCenter,
        zoom:7,
        scaleControl: true,
        mapTypeControl: true,
        mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
            position:google.maps.ControlPosition.TOP_LEFT,
        },
        streetViewControlOptions: {
            position: google.maps.ControlPosition.RIGHT_TOP },
        panControl: true,
        panControlOptions: {
            position: google.maps.ControlPosition.RIGHT_TOP
        },
        zoomControl: true,
        zoomControlOptions: {
            position: google.maps.ControlPosition.RIGHT_TOP
        },
        mapTypeId:google.maps.MapTypeId.ROADMAP
    };

    //New map Instance
    map = new google.maps.Map(document.getElementById("map"), mapOptions);

    $.ajax({
        type: "GET",
        url: "https://fuel.local/api/v1/gasstations/",
        success: function(response){

            $.each(response, function(i, item) {

                console.log(item.gasStationLat);
                var myPosition = new google.maps.LatLng(item.gasStationLat, item.gasStationLong);

                var myMarker = new google.maps.Marker({
                    position: myPosition,
                    map: map,
                });

                markers.push(myMarker);
            });
        }
    });
}