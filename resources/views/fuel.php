<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <style>
        html,
        body,
        .container-fluid {
            font-family: Arial, sans-serif;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #map {
            height: 100%;
            margin: auto 0 -65px;
            padding-bottom: 65px;
        }

        .navbar{
            margin-bottom: 0px;
        }
    </style>
</head>
<!--    <link href="/css/style.css" rel="stylesheet" type="text/css"/>-->
</head>
<body>
<div class="container-fluid">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Brand</a>
            </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <form class="navbar-form navbar-left">
                    <div class="input-group">
                        <input id="zoom-to-area-text" type="text" class="form-control" placeholder="Enter your area...">
                        <span class="input-group-btn">
                            <button id="zoom-to-area" class="btn btn-default" type="button">Go!</button>
                        </span>
                    </div><!-- /input-group -->
                </form>
                <ul class="nav navbar-nav navbar-right">
                    <p class="navbar-text">Signed in as</p>
                    <li class="list-group-item list-group-item-info">
                        <span id="gasStationsNumber" class="badge">0</span>
                        Total Fuels:
                    </li>
                    <li class="list-group-item list-group-item-success">
                        <span id="minPrice" class="badge">0</span>
                        Min Prize
                    </li>
                    <li class="list-group-item list-group-item-warning">
                        <span id="avgPrice" class="badge">0</span>
                        AVG Prize
                    </li>
                    <li class="list-group-item list-group-item-danger">
                        <span id="maxPrice" class="badge">0</span>
                        MAx prize
                    </li>
                    <li><a href="#">Link</a></li>
                    <button type="button" class="btn btn-default navbar-btn">Sign in</button>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Menu <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#" data-toggle="modal" data-target="#loginModal">Login</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#" data-toggle="modal" data-target="#registerModal">Register</a></li>
                            <li role="separator" class="divider"></li>
                            <li id="ordersList" style="display: none">
                                <a href="#" data-toggle="modal" data-target="#ordersModal">Orders</a>
                                <span id="ordersNumber" class="badge">0</span>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#" data-toggle="modal" data-target="#makeOrderModal">Make order</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Cras justo odio</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <div id="map"></div>
</div>
<!-- Modal Register-->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="Register" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Register</h4>
            </div>
            <div class="modal-body">
                <form id="registerForm" class="form-horizontal">
                    <h4><p class="text-center"><span id="registerError" class="label label-danger"></span></p></h4>
                    <div class="form-group">
                        <label for="registerUsername" class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" name="username" class="form-control" id="registerUsername" placeholder="Username">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="registerEmail" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" name="email" class="form-control" id="registerEmail" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="registerPassword" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" class="form-control" id="registerPassword" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Gas Station</label>
                        <div class="col-sm-10">
                            <label class="radio-inline">
                                <input type="radio" name="userType" value="2"  checked="">Client
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="userType" value="1">Owner
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button id="registerSubmit" type="submit" class="btn btn-default">Sign up</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Login -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Login</h4>
            </div>
            <div class="modal-body">
                <form id="loginForm" class="form-horizontal">
                    <h4><p class="text-center"><span id="loginError" class="label label-danger"></span></p></h4>
                    <div class="form-group">
                        <label for="registerUsername" class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10">
                            <input name="username" type="text" class="form-control" id="registerUsername" placeholder="Username">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="registerPassword" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10">
                            <input name="password" type="password" class="form-control" id="registerPassword" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button id="loginSubmit" type="submit" class="btn btn-default">Sign in</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Orders -->
<div class="modal fade" id="ordersModal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Orders</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="ordersTable" class="table table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Client</th>
                                <th>Fuel Name</th>
                                <th>Fuel Price</th>
                                <th>Quantity</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Make Order -->
<div class="modal fade" id="makeOrderModal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Make Order</h4>
            </div>
            <div class="modal-body">
                <form id="makeOrderForm" class="form-horizontal">
                    <h4><p class="text-center"><span id="loginError" class="label label-danger"></span></p></h4>
                    <div class="form-group">
                        <label for="registerUsername" class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10">
                            <input name="username" type="text" class="form-control" id="registerUsername" placeholder="Username">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="registerPassword" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10">
                            <input name="password" type="password" class="form-control" id="registerPassword" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button id="loginSubmit" type="submit" class="btn btn-default">Sign in</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script type="text/javascript" src="/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/notify.js"></script>
<script type="text/javascript">
    var api_token = "";
    var map = null;
    // Create a new blank array for all the listing markers.
    var markers = [];
    var defaultFuelTypeID = '1';

    $( document ).ready(function() {
        loginSubmit();
        registerSubmit();
    });

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

    function getGasStations() {
        var gasStationsIDs = [];
        var mapBounds = map.getBounds();
        var latIN = mapBounds.f.f + ',' + mapBounds.f.b;
        var lngIN = mapBounds.b.b + ',' + mapBounds.b.f;

        var _data = {'fields': 'gasStationID,gasStationLat,gasStationLong,fuelCompNormalName',
            'gasStationLat_BETWEEN' : latIN,
            'gasStationLong_BETWEEN' : lngIN};

        $.ajax({
            type: "GET",
            url: "https://fuel.local/api/v1/gasstations/",
            data: _data,
            success: function(response){
                $('#gasStationsNumber').text(response.length);
                var largeInfowindow = new google.maps.InfoWindow();
                $.each(response, function(i, item) {
                    gasStationsIDs.push(item.gasStationID);
                    var gasStationPosition = new google.maps.LatLng(item.gasStationLat, item.gasStationLong);

                    var myMarker = new google.maps.Marker({
                        map: map,
                        position: gasStationPosition,
                        title: item.fuelCompNormalName
                    });

                    markers.push(myMarker);
                    myMarker.addListener('click', function() {
                        populateInfoWindow(this, largeInfowindow);
                    });

                });

                getPriceDataAnalytics(gasStationsIDs);
            }
        });

    }

    function getPriceDataAnalytics(gasStationsIDs) {

        if(gasStationsIDs.length <= 0){
            $('#minPrice').text('0');
            $('#avgPrice').text('0');
            $('#maxPrice').text('0');
            return;
        }

        var _data = {gasStationID : gasStationsIDs,
                     'max' : 'fuelPrice',
                     'min' : 'fuelPrice',
                     'avg' : 'fuelPrice',
                     'fuelTypeID' : defaultFuelTypeID};

        $.ajax({
            type: "GET",
            url: "https://fuel.local/api/v1/pricedata/",
            data: _data,
            success: function(response){
                $('#minPrice').text(response[0].min_fuelPrice);
                $('#avgPrice').text(response[0].avg_fuelPrice);
                $('#maxPrice').text(response[0].max_fuelPrice);
            }
        });
    }

    // This function populates the infowindow when the marker is clicked. We'll only allow
    // one infowindow which will open at the marker that is clicked, and populate based
    // on that markers position.
    function populateInfoWindow(marker, infowindow) {
        // Check to make sure the infowindow is not already opened on this marker.
        if (infowindow.marker != marker) {
            infowindow.marker = marker;
            infowindow.setContent('<div>' + marker.title + '</div>');
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

    function loginSubmit() {
        $("#loginSubmit").click(function(event){

            event.preventDefault();// using this page stop being refreshing
            $('#loginError').empty();
            $('.help-block').remove();
            $('.has-error').removeClass('has-error');
            $.ajax({
                type: "POST",
                url: "https://fuel.local/api/v1/login/",
                data: $('#loginForm').serialize(),
                success: function(response){
                    api_token = response.api_token;
                    getOrders();
                    $('#loginModal').modal('hide');
                    $.notify({
                        // options
                        message: "Successfully login"
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
                url: "https://fuel.local/api/v1/register/",
                data: $('#registerForm').serialize(),
                success: function(response){
                    $('#registerModal').modal('hide');
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
            url: "https://fuel.local/api/v1/orders/",
            data: {"api_token": api_token},
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
            }
        });
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

</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgsWQrJsLfcZYrqjM6S4C9NqublrJk1Eo&v=3&callback=initMap">
</script>