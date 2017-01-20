// Login Values
var api_token = "";
var username = "";
var userGasStation = "";

//Settings
var defaultFuelTypeID = '1';
var defaultFuelTypeName = 'Αμόλυβδη 95';
var gasStationIDs = [];
var api_url = "https://fuel.local/api/v1/";

$( document ).ready(function() {
    loginSubmit();
    registerSubmit();
    logout();
    updatePriceDataSubmit();
    makeOrderSubmit();
    settingsSubmit();
});

$('.nav-tabs a').on('shown.bs.tab', function(event){
    var x = $(event.target).text();         // active tab
    var y = $(event.relatedTarget).addClass("inactiveTab");  // previous tab
});

$('#priceDataModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var action = button.data('action'); // Extract info from data-* attributes
    var gasStationId = "";
    var target = "";
    if(action == "edit"){
        if(userGasStation === ''){
            return;
        }
        gasStationId = userGasStation;
        target = "#updatePriceDataModal";
    }else {
        gasStationId = button.data('gasstationid');
        target = "#makeOrderModal";
    }

    $("#priceDataTable > tbody").children().remove();

    $.ajax({
        async: false,
        type: "GET",
        url: api_url + "gasstations/" + gasStationId + "/pricedata/",
        data: {fields : 'priceDataID,fuelNormalName,fuelName,fuelPrice,dateUpdated,isPremium'},
        success: function(response){

            $.each(response, function(i, item) {
                var  premium = "Yes";
                if(item.isPremium == 0){
                    premium = "No";
                }

                $('#priceDataTable').append('<tr>' +
                    '<td>' + item.fuelNormalName + '</td>' +
                    '<td>' + item.fuelName + '</td>' +
                    '<td>' + item.fuelPrice + '</td>' +
                    '<td>' + item.dateUpdated + '</td>' +
                    '<td>' + premium + '</td>' +
                    '<td><button type="button" class="btn btn-primary" data-toggle="modal" ' +
                    'data-target="' + target + '" data-whatever="'+ item.fuelName + ',' + item.priceDataID +
                    ',' +  item.fuelPrice + '">' + action +'</button></td></tr>');
            });
        }
    });
});

$('#updatePriceDataModal').on('show.bs.modal', function (event) {
    $('#priceDataModal').modal('hide');
    var button = $(event.relatedTarget); // Button that triggered the modal
    var recipient = button.data('whatever');// Extract info from data-* attributes
    var priceData = recipient.split(",");

    var modal = $(this);
    modal.find('.modal-title').text('Fuel: ' + priceData[0]);
    modal.find('#updatePriceDataID').val(priceData[1]);
    modal.find('#updateFuelPrice').val(priceData[2]);
});

$('#makeOrderModal').on('show.bs.modal', function (event) {
    if(api_token === ""){
        event.preventDefault();
        $.notify({ message: "Please login or register to order."
        },{
            type: 'danger',
            placement: {
                from: "top",
                align: "center"
            }
        });
    }

    $('#priceDataModal').modal('hide');
    var button = $(event.relatedTarget); // Button that triggered the modal
    var recipient = button.data('whatever');// Extract info from data-* attributes
    var priceData = recipient.split(",");

    var modal = $(this);
    modal.find('.modal-title').text('Fuel: ' + priceData[0]);
    modal.find('#makeOrderPriceDataID').val(priceData[1]);
    modal.find('#makeOrderFuelPrice').val(priceData[2]);
});

$('#statsModal').on('show.bs.modal', function (event) {
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawFuelTypesChart);
    google.charts.setOnLoadCallback(drawDefaultFuelPriceChart);
});

function getGasStations() {
    var _gasStationIDs = [];
    var mapBounds = map.getBounds();
    var latIN = mapBounds.f.f + ',' + mapBounds.f.b;
    var lngIN = mapBounds.b.b + ',' + mapBounds.b.f;

    var _data = {'fields': 'gasStationID,gasStationLat,gasStationLong,fuelCompNormalName,' +
    'gasStationAddress,fuelCompID,phone1,gasStationOwner',
        'gasStationLat_BETWEEN' : latIN,
        'gasStationLong_BETWEEN' : lngIN};

    $.ajax({
        type: "GET",
        url: api_url + "gasstations/",
        data: _data,
        success: function(response){
            $('#gasStationsNumber').text(response.length);
            var largeInfowindow = new google.maps.InfoWindow();
            $.each(response, function(i, item) {
                _gasStationIDs.push(item.gasStationID);
                var gasStationPosition = new google.maps.LatLng(item.gasStationLat, item.gasStationLong);

                var myMarker = createMarket(gasStationPosition, item.gasStationAddress, item.fuelCompID);

                markers.push(myMarker);
                myMarker.addListener('click', function() {
                    populateInfoWindow(this, largeInfowindow, item);
                });

            });

            gasStationIDs = _gasStationIDs;
            getPriceDataAnalytics();
        }
    });

}

function getPriceDataAnalytics() {

    if(gasStationIDs.length <= 0){
        $('#minPrice').text('0');
        $('#avgPrice').text('0');
        $('#maxPrice').text('0');
        return;
    }

    var _data = {'gasStationID' : gasStationIDs,
        'max' : 'fuelPrice',
        'min' : 'fuelPrice',
        'avg' : 'fuelPrice',
        'fuelTypeID' : defaultFuelTypeID};

    $.ajax({
        type: "GET",
        url: api_url + "pricedata/",
        data: _data,
        success: function(response){

            var minFuelPrice = 0;
            if(response[0].min_fuelPrice !== null){
                minFuelPrice = parseFloat(response[0].min_fuelPrice).toFixed(3);
            }

            var maxFuelPrice = 0;
            if(response[0].max_fuelPrice !== null){
                maxFuelPrice = parseFloat(response[0].max_fuelPrice).toFixed(3);
            }

            var avgFuelPrice = 0;
            if(response[0].avg_fuelPrice !== null){
                avgFuelPrice = parseFloat(response[0].avg_fuelPrice).toFixed(3);
            }

            $('#minPrice').text(minFuelPrice);
            $('#avgPrice').text(maxFuelPrice);
            $('#maxPrice').text(avgFuelPrice);
        }
    });
}

function loginSubmit() {
    $("#loginSubmit").click(function(event){

        event.preventDefault();// using this page stop being refreshing
        $('#loginError').empty();
        $('.help-block').remove();
        $('.has-error').removeClass('has-error');
        $.ajax({
            type: "POST",
            url: api_url + "login/",
            data: $('#loginForm').serialize(),
            success: function(response){
                api_token = response.api_token;
                username = $("#loginUsername").val();

                getOrders();
                getUserGasStation();
                showLogout();
                $('#signInUpModal').modal('hide');
                $.notify({
                    // options
                    message: response.message
                },{
                    // settings
                    type: 'success',
                    placement: {
                        from: "top",
                        align: "center"
                    },
                });
            },
            error: function(response){
                $('#loginError').append(response.responseJSON.message);
                $.each(response.responseJSON, function(inputName, errorMessage){
                    $("#loginForm input[name=" + inputName + "]").
                    after('<span class="help-block">' + errorMessage + '</span>')
                        .parent('div').addClass('has-error');
                });
            }
        });
    });
}

function registerSubmit() {
    $("#registerSubmit").click(function(event){

        event.preventDefault();// using this page stop being refreshing
        $('.help-block').remove();
        $('#registerError').empty();
        $('.has-error').removeClass('has-error');
        $.ajax({
            type: "POST",
            url: api_url + "register/",
            data: $('#registerForm').serialize(),
            success: function(response){
                api_token = response.api_token;
                username = $("#registerUsername").val();
                $('#signInUpModal').modal('hide');

                getOrders();
                getUserGasStation();
                showLogout();

                $.notify({
                    // options
                    message: response.message
                },{
                    // settings
                    type: 'success',
                    placement: {
                        from: "top",
                        align: "center"
                    }
                });
            },
            error: function(response){
                $('#registerError').append(response.responseJSON.message);
                $.each(response.responseJSON, function(inputName, errorMessage){
                    $("#registerForm input[name=" + inputName + "]").
                    after('<span class="help-block">' + errorMessage + '</span>')
                        .parent('div').addClass('has-error');
                });
            }
        });
    });
}

function getOrders() {
    $.ajax({
        type: "GET",
        url: api_url + "orders/",
        data: {"api_token": api_token, "owner" : username},
        success: function(response){
            $('#ordersList').show();
            $('#ordersNumber').append(response.length);

            $.each(response, function(i, item) {
                var  row = i + 1;
                $('#ordersTable').append('<tr><th scope="row">' + row + '</th>' +
                    '<td> ' + item.client + ' </td>' +
                    '<td> ' + item.fuelName + ' </td>' +
                    '<td> ' + item.fuelPrice + ' </td>' +
                    '<td> ' + item.quantity + ' </td>' +
                    '<td> '+item.create_time+' </td></tr>');
            });
        }
    });
}

function getUserGasStation() {
    $.ajax({
        type: "GET",
        url: api_url + "gasstations/",
        data: {"fields": "gasStationID", "username" : username},
        success: function(response){
            //User is not owner of a gas station
            if(jQuery.isEmptyObject(response)){
                return ;
            }

            $('#updateFuelData').show();
            userGasStation = response[0].gasStationID;
        }
    });
}

function updatePriceDataSubmit() {
    $("#updatePriceDataSubmit").click(function(event){
        event.preventDefault();// using this page stop being refreshing

        $('.help-block').remove();
        $('#updatePriceDataError').empty();
        $('.has-error').removeClass('has-error');
        $.ajax({
            type: "PUT",
            url: api_url + "pricedata/" + $("#updatePriceDataID").val(),
            data: {fuelPrice :  $("#updateFuelPrice").val(),
                api_token : api_token},
            success: function(response){
                $('#updatePriceDataModal').modal('hide');
                $.notify({
                    // options
                    message: response.message
                },{
                    // settings
                    type: 'success',
                    placement: {
                        from: "top",
                        align: "center"
                    }
                });
            },
            error: function(response){
                $('#updatePriceDataError').append(response.responseJSON.message);
                $.each(response.responseJSON, function(inputName, errorMessage){
                    $("#updatePriceDataForm input[name=" + inputName + "]").
                    after('<span class="help-block">' + errorMessage + '</span>')
                        .parent('div').addClass('has-error');
                });
            }
        });
    });
}

function makeOrderSubmit() {
    $("#makeOrderSubmit").click(function(event){
        event.preventDefault();// using this page stop being refreshing
        $('#makeOrderError').empty();
        $('.help-block').remove();
        $('.has-error').removeClass('has-error');
        $.ajax({
            type: "POST",
            url: api_url + "orders",
            data: $('#makeOrderForm').serialize() + '&api_token=' + api_token,
            success: function(response){
                $('#makeOrderModal').modal('hide');
                $.notify({
                    // options
                    message: response.message
                },{
                    // settings
                    type: 'success',
                    placement: {
                        from: "top",
                        align: "center"
                    }
                });
            },
            error: function(response){
                $('#makeOrderError').append(response.responseJSON.message);
                $.each(response.responseJSON, function(inputName, errorMessage){
                    $("#makeOrderForm input[name=" + inputName + "]").
                    after('<span class="help-block">' + errorMessage + '</span>')
                        .parent('div').addClass('has-error');
                });
            }
        });
    });
}

function logout() {
    $("#signOut").click(function(){
        $.notify({
            // options
            message: "Successfully log out"
        },{
            // settings
            type: 'success',
            placement: {
                from: "top",
                align: "center"
            },
        });

        $('#signInUp').show();
        $('#signOut').hide();
        $('#ordersList').hide();
        $('#updateFuelData').hide();
        $('#loginForm')[0].reset();
        $('#registerForm')[0].reset();
        $("#ordersTable > tbody").children().remove();
        $("#ordersNumber").html('');
        api_token = "";
        username = "";
        userGasStation = "";
    });
}

function showLogout() {
    $('#signInUp').hide();
    $('#signOut').show();
}

function settingsSubmit() {
    $("#fuelTypeForm").submit(function(event){
        event.preventDefault();// using this page stop being refreshing
        defaultFuelTypeID = $('#fuelTypeSelect').val();
        defaultFuelTypeName = $('#fuelTypeSelect option:selected').text();
        getPriceDataAnalytics();
        $('#settingsModal').modal('hide');
    });
}

function drawFuelTypesChart() {

    var _data = {'fields' : 'fuelNormalName',
        'count' : 'priceDataID',
        'groupby' : 'fuelNormalName',
        'gasStationID' : gasStationIDs};

    var stats = [['Task', 'Hours per Day']];
    $.ajax({
        async: false,
        type: "GET",
        url: api_url + "pricedata/",
        data: _data,
        success: function(response){
            $.each(response, function(i, item) {
                var temp = [item.fuelNormalName, item.count_priceDataID];
                stats.push(temp);
            });
        }
    });

    var data = google.visualization.arrayToDataTable(stats);

    var options = {
        title: 'Fuel types per Gas stations'
    };

    var chart = new google.visualization.PieChart(document.getElementById('piechart'));

    chart.draw(data, options);
}

function drawDefaultFuelPriceChart() {
    var _data = {fields : 'fuelPrice',
        'fuelTypeID' : defaultFuelTypeID,
        'gasStationID' : gasStationIDs};

    var stats = [['Fuels', defaultFuelTypeName]];
    $.ajax({
        async: false,
        type: "GET",
        url: api_url + "pricedata/",
        data: _data,
        success: function(response){
            $.each(response, function(i, item) {
                var temp = [i+1, parseFloat(item.fuelPrice)];
                stats.push(temp);
            });
        }
    });

    var data = google.visualization.arrayToDataTable(stats);

    var options = {
        title: 'Fuel Price',
        curveType: 'function',
        legend: { position: 'bottom' }
    };

    var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

    chart.draw(data, options);
}

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