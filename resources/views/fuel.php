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
                    <li><a href="#" data-toggle="modal" data-target="#project1">Cras justo odio</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="#">Cras justo odio</a></li>
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

<!-- Modal -->
<div class="modal fade" id="project1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Favorite App Page</h4>
            </div>
            <div class="modal-body">
                This was my first project in this class. I learned a lot about HTML and CSS.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</body>
</html>
<script type="text/javascript" src="/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
