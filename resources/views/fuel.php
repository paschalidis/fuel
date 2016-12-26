<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<!--    <link href="/css/style.css" rel="stylesheet" type="text/css"/>-->
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-1">
            <div class="dropdown">
                <button id="dMenu" type="button" class="btn btn-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
                </button>
                <ul class="list-group dropdown-menu" aria-labelledby="dMenu">
                    <li><a href="#" data-toggle="modal" data-target="#loginModal">Login</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="#" data-toggle="modal" data-target="#registerModal">Register</a></li>
                    <li role="separator" class="divider"></li>
                    <li id="ordersList" style="display: none">
                        <a href="#" data-toggle="modal" data-target="#orderModal">Orders</a>
                        <span id="ordersNumber" class="badge">0</span>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li><a href="#">Cras justo odio</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="#">Cras justo odio</a></li>
                </ul>
            </div>
<!--            <button type="button" class="btn btn-default" aria-label="Left Align">-->
<!--                <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>-->
<!--            </button>-->
        </div>
        <div class="col-md-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Go!</button>
                </span>
            </div><!-- /input-group -->
        </div>
        <div class="col-md-8">
            <ul class="list-group list-inline">
                <li class="list-group-item list-group-item-info">
                    <span class="badge">40</span>
                    Total Fuels:
                </li>
                <li class="list-group-item list-group-item-success">
                    <span class="badge">40</span>
                    Min Prize
                </li>
                <li class="list-group-item list-group-item-warning">
                    <span class="badge">40</span>
                    AVG Prize
                </li>
                <li class="list-group-item list-group-item-danger">
                    <span class="badge">40</span>
                    MAx prize
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <img src="http://placehold.it/1100x850">
        </div>
    </div>
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

<!-- Modal Order -->
<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Orders</h4>
            </div>
            <div class="modal-body">
                <p>TAble here</p>
            </div>
            <div class="modal-footer">
                <p>Footer her</p>
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

    $( document ).ready(function() {
        loginSubmit();
        registerSubmit();
    });

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
                console.log(response);
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
                console.log(response);
            }
        });
    }
</script>