var map = null;
myInfowindow = null;   //the infowindows object
myPosition = null;    //browser's position
markers = [];     //array to store marker references

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

//συνάρτηση αρχικοποίησης AJAX υποδομής - επιστρέφει reference στο AJAX
//object ή false αν δεν υποστηρίζονται AJAX κλήσεις από τον browser.
function initAJAX() {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        return new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        // code for IE6, IE5 - εδώ χρησιμοποιούνται ActiveX object (MS τεχνολογίες)
        return new ActiveXObject("Microsoft.XMLHTTP");
    } else {
        alert("Your browser does not support XMLHTTP!");
        return false;
    }
}

function getData() {

    //εκκίνηση AJAX υποδομής
    var xmlhttp = initAJAX();

    //Εφόσον υποστηρίζονται AJAX κλίεις:
    if (xmlhttp) {
        // κλήση σε API για λήψη δεδομένων (ΕΔΩ κλήση σε στατικό JSON αρχείο)
        // Για λόγους security ο ΙΕ δεν ανήγει τοπικό αρχείο οπότε για τις ανάγκες
        //του παραδείγματος το έβαλα στον server που βλέπετε παρακάτω.
        //xmlhttp.open("GET","http://fuelgr.gr/sample-stations.json",true);
        //xmlhttp.open("GET","sample-stations.json",true);
        xmlhttp.open("GET","https://fuel.local/api/v1/gasstations",true);
        xmlhttp.send(null);

        //ορισμός callback για τον χειρισμό της απάντησης
        xmlhttp.onreadystatechange=function() {
            if(xmlhttp.readyState === XMLHttpRequest.DONE && xmlhttp.status === 200) {
                var obj = JSON.parse(xmlhttp.responseText);
                for (var i=0; i<obj.length; i++){
                    putMarker( obj[i].gasStationLat,
                        obj[i].gasStationLong,
                        obj[i].gasStationAddress );
                }   //for
            }

        };  //callback
    }   //if xmlhttp
}

// δημιουργία, τοποθέτηση και αποθήκευση marker
function putMarker(myLat,myLong,myAddress) {

    var myMarker = null;
    //create a position object
    var myPosition = new google.maps.LatLng(myLat,myLong);

    //initialize and create a marker object
    myMarker = new google.maps.Marker({
        position: myPosition,  //θέση
        map: map,            //χαρτης στον οποίο θα εμφανιστούν
        title: myAddress,      //tooltip
        draggable: false       //χωρίς δυνατότητα μετακίνησης νε drag'n'drop
    });

    //αποθήκευση στο markers array
    markers.push(myMarker);

    //associate the infowindow with the click on the marker
    // google.maps.event.addListener( myMarker, 'click', function(){
    //     myInfowindow.setContent(myAddress);
    //     //ζηταμε να εμφανιστεί στη θέση του συσχετισμένου marker
    //     myInfowindow.position = myMarker.getPosition();
    //     myInfowindow.open(map,this); }
    // );

}

function cleanMarkers() {
    for (i=0; i<markers.length; i++)
        markers[i].setMap(null);
    //άδειασμα και του πίνακα με τα references
    markers=[];
}