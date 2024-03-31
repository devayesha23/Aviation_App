<?php
// Include the flight_functions.php file
require_once('./api/flight_functions.php');

// Fetch airport information
$airportData = getAirportInfo();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airport Information</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="./css/index.css">
    <style>
        #map {
            height: 500px;
        }
    </style>
</head>
<body>

<h1>Airport Information</h1>
<div class="bar"></div>

<!-- Display map -->
<div id='map'></div>

<!-- Leaflet JavaScript -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    var map = L.map('map').setView([51.505, -0.09], 2); // Default center and zoom level

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Define custom icon
    var airportIcon = L.icon({
        iconUrl: './assets/airport.png', // URL of the icon image
        iconSize: [32, 32], // Size of the icon
        iconAnchor: [16, 32], // Anchor point of the icon
        popupAnchor: [0, -32] // Popup anchor point relative to the icon
    });

    // Loop through airport data and create icons
    <?php foreach ($airportData['data'] as $airport): ?>
        L.marker([<?= $airport['latitude'] ?>, <?= $airport['longitude'] ?>], {icon: airportIcon}).addTo(map)
            .bindPopup(`<b>Airport Name:</b> <?= $airport['airport_name'] ?><br>
                        <b>City:</b> <?= $airport['city_iata_code'] ?><br>
                        <b>Country:</b> <?= $airport['country_name'] ?><br>
                        <b>Phone Number:</b> <?= $airport['phone_number'] ?><br>
                        <b>Timezone:</b> <?= $airport['timezone'] ?>`);
    <?php endforeach; ?>
</script>


</body>
</html>
