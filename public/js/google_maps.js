var map;
//Initialized JavaScript functions to load the map
function initMap() {
    // Constructor creates a new map - only center and zoom are required.
    //Used in callback

    //New map Instance
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 40.7413549, lng: -73.9980244},
        zoom: 13
    });

    if(navigator.geolocation) {
        //ορισμός callback συναρτήσεων για τον χειρισμό
        //επιτυχούς ή ανεπιτυχούς προσδιορισμού θέσης
        navigator.geolocation.getCurrentPosition(cbGetCurPosOK, cbGetCurPosFail);
    } else {
        //o browser δεν υποστηρίζει geolocation
        alert('Your browser does not support geolocation.');
    }
}

//callback σε υποστήριξη geolocation
//position είναι το στίγμα που επεστράφει από τον browser
function cbGetCurPosOK(position) {
    //έστω διαβάζουμε την τρέχουσα θέση και φτιάχνουμε ένα σημείο χάρτη
    var curPosition = new google.maps.LatLng( position.coords.latitude,
        position.coords.longitude );
    // κεντράρουμε το χάρτη σε αυτό το σημείο
    map.setCenter(curPosition);

    // φτιάχνουμε μια πινέζα (marker) σε αυτό το σημείο
    var curMarker = new google.maps.Marker({ position: curPosition,
        title: 'You are here!',
        icon: 'home.png' });
    //βάζουμε την πινέζα στο χάρτη (γίνεται και στην αρχικοποίηση!)
    curMarker.setMap(map);

    //zoom στη θέση μας - επιλέξτε επίπεδο zoom που επιτρέπει στο χρήστη
    //να δει και κάποια σημεία αναφοράς της περιοχής για να προσανατολιστεί.
    //Συνήθως τιμές 10-12 είναι οι ποιο ταιριαστές
    map.setZoom(12);
}

//callback σε MH υποστήριξη geolocation
function cbGetCurPosFail(error) {
    //διαβάζουμε το error code και ενημερώνουμε τον χρήστη
    switch(error.code) {
        case error.PERMISSION_DENIED:
            alert("User denied the request for Geolocation.");
            break;
        case error.POSITION_UNAVAILABLE:
            alert("Location information is unavailable.");
            break;
        case error.TIMEOUT:
            alert("The request to get user location timed out.");
            break;
        case error.UNKNOWN_ERROR:
            alert("An unknown error occurred.");
            break;
    }
}