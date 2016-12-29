// Login Values
var api_token = "";
var username = "";
var userGasStation = "";

//Settings
var defaultFuelTypeID = '1';
var api_url = "https://fuel.local/api/v1/";

$( document ).ready(function() {
    loginSubmit();
    registerSubmit();
    updatePriceDataSubmit();
    makeOrderSubmit();
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
        url: "https://fuel.local/api/v1/gasstations/" + gasStationId + "/pricedata/",
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
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find('.modal-title').text('Update ' + priceData[0]);
    modal.find('#updatePriceDataID').val(priceData[1]);
    modal.find('#updateFuelPrice').val(priceData[2]);
});

$('#makeOrderModal').on('show.bs.modal', function (event) {
    if(api_token === ""){
        event.preventDefault();
        $.notify({ message: "Please login to order"
        },{
            type: 'success',
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
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find('.modal-title').text('Order: ' + priceData[0]);
    modal.find('#makeOrderPriceDataID').val(priceData[1]);
    modal.find('#makeOrderFuelPrice').val(priceData[2]);
});

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
                    title: item.fuelCompNormalName,
                    id: item.gasStationID
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
                username = $("#loginUsername").val();

                getOrders();
                getUserGasStation();
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

function getUserGasStation() {
    $.ajax({
        type: "GET",
        url: "https://fuel.local/api/v1/gasstations/",
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