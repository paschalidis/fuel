<!DOCTYPE html>
<html>
<head>
    <link href="/css/style.css" rel="stylesheet" type="text/css"/>
    <script src="/js/google_maps.js"></script>
</head>
<body>
    <button onclick="getData();" id="getDataBtn" type="button">Click Me!</button>
    <button onclick="cleanMarkers();" id="cleanMarkersBtn" type="button">Clear!</button>
    <div id="map"></div>

    <!-- Script to load tha API
    Loads tha JavaScript definitions when the page starts loading
    aync = asynchronously which means tha the rest will render while the Java Script API loads (more speed without having
    to wait for the Javascript)
    callback function will execute when the API is done loading
    maps.googleapis.com = endpoint
    v=3 Version three of the API-->
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?= $API_KEY ?>&v=3&callback=initMap">
    </script>
</body>
</html>