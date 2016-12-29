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
                            <li id="updateFuelData" style="display: none">
                                <a href="#" data-toggle="modal" data-target="#priceDataModal" data-action="edit">Update Fuel Data</a>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#" data-toggle="modal" data-target="#makeOrderModal">Make order</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#" data-toggle="modal" data-target="#updatePriceDataModal">Price update</a></li>
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
                <form id="updatePriceDataForm" class="form-horizontal">
                    <h4><p class="text-center"><span id="makeOrderError" class="label label-danger"></span></p></h4>
                    <input name="priceDataID" type="hidden" id="makeOrderPriceDataID" value="">
                    <div class="form-group">
                        <label for="updateFuelPrice" class="col-sm-2 control-label">Fuel Price</label>
                        <div class="col-sm-10">
                            <input name="fuelPrice" type="text" class="form-control" id="makeOrderFuelPrice">
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