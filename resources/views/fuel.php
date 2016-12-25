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
                    <li><a href="#">Cras justo odio</a></li>
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
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="registerUsername" class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="registerUsername" placeholder="Username">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="registerEmail" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="registerEmail" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="registerPassword" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="registerPassword" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-default">Sign up</button>
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
                    <div class="form-group">
                        <label for="registerUsername" class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10">
                            <input name="username" type="text" class="form-control" id="registerUsername" placeholder="Username">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="registerPassword" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10">
                            <input name="paswword" type="password" class="form-control" id="registerPassword" placeholder="Password">
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
<script>
    $( document ).ready(function() {
        console.log( "document loaded" );

        $.ajax({
            type: "POST",
            url: "http://fuel.local/api/v1/login",
            success: function(msg){
                console.log(msg);
            },
            error: function(response){
                $.notify({
                    // options
                    message: response.responseJSON.message
                },{
                    // settings
                    type: 'danger'
                });
            }
        });
    });

    $(function() {
//twitter bootstrap script
        $("#loginSubmit").click(function(){

            $.ajax({
                type: "POST",
                url: "http://fuel.local/api/v1/login",
                data: $('#loginForm').serialize(),
                success: function(msg){
                    //$("#thanks").html(msg)
                    $("#form-content").modal('hide');
                },
                error: function(){
                    //alert("failure");
                    $("#form-content").modal('hide');
                }
            });
        });
    });
</script>