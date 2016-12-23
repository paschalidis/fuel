<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css"></head>
<!--    <link href="/css/style.css" rel="stylesheet" type="text/css"/>-->
</head>
<body>
    <div class="container-fluid">
        <div class="row-">
            <div class="col-md-6">
                A
            </div>
            <div class="col-md-6">
                <div id="map"></div>
            </div>
        </div>
    </div>
</body>
</html>
<script src="/js/google_maps.js"></script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?= $API_KEY ?>&v=3&callback=initMap">
</script>