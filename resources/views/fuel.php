<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fuels</title>
    <link rel="icon" href="/img/favicon.ico">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <style>
        html,
        body,
        #map,
        .container-fluid {
            font-family: Arial, sans-serif;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #map {
            height: 94%;
        }

        .navbar{
            margin-bottom: 0px;
        }

        .navbar-form{
            padding: 0px;
        }

        .custom-nav{
            margin-right: 0px;
        }

        #logoImg{
            height: 100%;
        }

        .chart {
            width: 100%;
            min-height: 450px;
        }

    </style>
</head>
<!--    <link href="/css/style.css" rel="stylesheet" type="text/css"/>-->
</head>
<body>
<div class="container-fluid">
    <nav class="navbar navbar-default">
            <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed custom-nav" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">
                <img id="logoImg" src="/img/fuel.png">
            </a>
            <form class="navbar-form navbar-left custom-nav">
                <div class="input-group">
                    <input id="zoom-to-area-text" type="text" class="form-control" placeholder="Enter your area...">
                    <span class="input-group-btn">
                        <button id="zoom-to-area" class="btn btn-default" type="button">Go!</button>
                    </span>
                </div><!-- /input-group -->
            </form>
        </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-left">
                <p class="navbar-text">Fuels:<span id="gasStationsNumber" class="label label-primary">0</span></p>
                <p class="navbar-text">Min:<span id="minPrice" class="label label-success">0</span></p>
                <p class="navbar-text">Avg:<span id="avgPrice" class="label label-warning">0</span></p>
                <p class="navbar-text">Max:<span id="maxPrice" class="label label-danger">0</span></p>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <button type="button" id="updateFuelData" style="display: none" class="btn btn-default navbar-btn" data-toggle="modal" data-target="#priceDataModal" data-action="edit">
                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                </button>
                <button type="button" id="ordersList" style="display: none" class="btn btn-default navbar-btn" data-toggle="modal" data-target="#ordersModal">
                    <span class="glyphicon glyphicon-tint" aria-hidden="true"></span>
                    <span id="ordersNumber" class="badge"></span>
                </button>
                <button type="button" id="stats" class="btn btn-default navbar-btn" data-toggle="modal" data-target="#statsModal">
                    <span class="glyphicon glyphicon-stats" aria-hidden="true"></span>
                </button>
                <button type="button" id="settings" class="btn btn-default navbar-btn" data-toggle="modal" data-target="#settingsModal">
                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                </button>
                <button type="button" id="signInUp" class="btn btn-default navbar-btn" data-toggle="modal" data-target="#signInUpModal">
                    <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>
                </button>
                <button type="button" id="signOut" style="display: none" class="btn btn-default navbar-btn">
                    <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
                </button>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
    <div id="map"></div>
</div><!-- /.container-fluid -->

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

<!-- Modal Price Data -->
<div class="modal fade" id="priceDataModal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Fuel Data</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="priceDataTable" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Normal Name</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Updated</th>
                            <th>Premium</th>
                            <th>Action</th>
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

<!-- Modal Update Price Data -->
<div class="modal fade" id="updatePriceDataModal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Update Price Data</h4>
            </div>
            <div class="modal-body">
                <form id="updatePriceDataForm" class="form-horizontal">
                    <h4><p class="text-center"><span id="updatePriceDataError" class="label label-danger"></span></p></h4>
                    <input name="priceDataID" type="hidden" id="updatePriceDataID" value="">
                    <div class="form-group">
                        <label for="updateFuelPrice" class="col-sm-2 control-label">Fuel Price</label>
                        <div class="col-sm-10">
                            <input name="fuelPrice" type="text" class="form-control" id="updateFuelPrice">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button id="updatePriceDataSubmit" type="submit" class="btn btn-default">Update</button>
                        </div>
                    </div>
                </form>
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
                <h4 class="modal-title" id="myModalLabel">Order</h4>
            </div>
            <div class="modal-body">
                <form id="makeOrderForm" class="form-horizontal">
                    <h4><p class="text-center"><span id="makeOrderError" class="label label-danger"></span></p></h4>
                    <input name="priceDataID" type="hidden" id="makeOrderPriceDataID" value="">
                    <div class="form-group">
                        <label for="updateFuelPrice" class="col-sm-2 control-label">Fuel Price</label>
                        <div class="col-sm-10">
                            <input disabled name="fuelPrice" type="text" class="form-control" id="makeOrderFuelPrice">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="makeOrderQuantity" class="col-sm-2 control-label">Quantity</label>
                        <div class="col-sm-10">
                            <input name="quantity" type="text" class="form-control" id="makeOrderQuantity">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button id="makeOrderSubmit" type="submit" class="btn btn-default">Order</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Sign In/Up -->
<div class="modal fade" id="signInUpModal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#loginTab" aria-controls="loginTab" role="tab" data-toggle="tab">Sign In</a></li>
                    <li role="presentation"><a href="#registerTab" aria-controls="registerTab" role="tab" data-toggle="tab">Sign Up</a></li>
                </ul>
            </div>
            <div class="modal-body">
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="loginTab" class="tab-pane active" id="loginTab">
                        <form id="loginForm" class="form-horizontal">
                            <h4><p class="text-center"><span id="loginError" class="label label-danger"></span></p></h4>
                            <div class="form-group">
                                <label for="registerUsername" class="col-sm-2 control-label">Username</label>
                                <div class="col-sm-10">
                                    <input name="username" type="text" class="form-control" id="loginUsername" placeholder="Username">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="registerPassword" class="col-sm-2 control-label">Password</label>
                                <div class="col-sm-10">
                                    <input name="password" type="password" class="form-control" id="loginPassword" placeholder="Password">
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
                    <div role="registerTab" class="tab-pane" id="registerTab">
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
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-primary active">
                                            <input type="radio" name="userType" value="2" autocomplete="off" checked> Client
                                        </label>
                                        <label class="btn btn-primary">
                                            <input type="radio" name="userType" value="1" autocomplete="off"> Owner
                                        </label>
                                    </div>
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
    </div>
</div>

<!-- Modal Settings -->
<div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="Settings" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#fuelTypeTab" aria-controls="fuelTypeTab" role="tab" data-toggle="tab">Fuel Type</a></li>
                </ul>
            </div>
            <div class="modal-body">
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="fuelTypeTab" class="tab-pane active" id="fuelTypeTab">
                        <form id="fuelTypeForm" class="form-horizontal">
                            <div class="form-group">
                                <label for="fuelTypeSelect" class="col-sm-2 control-label">Fuel Type</label>
                                <div class="col-sm-10">
                                    <select name="fuelTypeID" id="fuelTypeSelect" class="form-control">
                                        <option value="1">Αμόλυβδη 95</option>
                                        <option value="2">Αμόλυβδη 100</option>
                                        <option value="3">Super</option>
                                        <option value="4">Diesel Κίνησης</option>
                                        <option value="5">Diesel Θέρμανσης</option>
                                        <option value="6">Υγραέριο Κίνησης</option>
                                        <option value="7">Diesel Θέρμανσης κ.ο.</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button id="fuelTypeSubmit" type="submit" class="btn btn-default">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Stats -->
<div class="modal fade" id="statsModal" tabindex="-1" role="dialog" aria-labelledby="Stats" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#fuelTypeStatsTab" aria-controls="fuelTypeStatsTab" role="tab" data-toggle="tab">Fuel Types</a></li>
                    <li role="presentation"><a href="#fuelTypePriceTab" aria-controls="fuelTypePriceTab" role="tab" data-toggle="tab">Fuel Price</a></li>
                </ul>
            </div>
            <div class="modal-body">
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="fuelTypeStatsTab" class="tab-pane active" id="fuelTypeStatsTab">
                        <div id="piechart" class="chart"></div>
                    </div>
                    <div role="fuelTypePriceTab" class="tab-pane" id="fuelTypePriceTab">
                        <div id="curve_chart" class="chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script type="text/javascript" src="/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/notify.js"></script>
<script type="text/javascript" src="/js/map_api.js"></script>
<script type="text/javascript" src="/js/fuel_api.js"></script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgsWQrJsLfcZYrqjM6S4C9NqublrJk1Eo&v=3&callback=initMap">
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {

        var _data = {fields : 'fuelNormalName',
            'count' : 'priceDataID',
            'groupby' : 'fuelNormalName'};

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
            title: 'Fuel types per Gas stations',
            'width':500,
            'height':500
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }
</script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart2);

    function drawChart2() {
        var _data = {fields : 'fuelPrice',
            'fuelTypeID' : defaultFuelTypeID};

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
</script>
