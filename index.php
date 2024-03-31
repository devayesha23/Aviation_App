<?php
// Include the flight_functions.php file
require_once('./api/flight_functions.php');

function displayFlightPath($latitude, $longitude, $flightNumber, $airline, $status, $departureAirport, $arrivalAirport, $direction) {
    // Define the URL of the image
    $imageUrl = './assets/flight.png';
    
    // Convert degrees to radians
    $rotationAngle = deg2rad($direction);

    // Echo the JavaScript code properly
    echo "<script>
            var imageUrl = '$imageUrl';
            var rotationAngle = '$rotationAngle';
            var icon = L.divIcon({
                html: '<img src=\"' + imageUrl + '\" style=\"transform: rotate(' + rotationAngle + 'rad); width: 32px; height: 32px; background: transparent;\">',
                iconSize: [0, 0], 
                iconAnchor: [32, 32] // Adjust the anchor point if needed
            });
            var marker = L.marker([$latitude, $longitude], { icon: icon }).addTo(map);
            marker.bindPopup('<b>Flight:</b> $flightNumber <br>' +
                             '<b>Airline:</b> $airline <br>' +
                             '<b>Status:</b> $status <br>' +
                             '<b>Departure:</b> $departureAirport <br>' +
                             '<b>Arrival:</b> $arrivalAirport');
          </script>";
}

// Fetch all live flights
$live_flights_data = getLiveFlightData();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Tracker</title>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
</head>
<body>

<div class="sidebar">
    <h2>Live Flight Tracking</h2>
    <div class="search">
        <form method="post">
            <input type="text" name="flightNumber" placeholder="Search by Flight Number">
            <button type="submit" name="searchFlight">Search</button>
        </form>
    </div>
        <!-- Flight information will be displayed here -->
        <?php
    if (isset($_POST['searchFlight'])) {
        $flightNumber = $_POST['flightNumber'];
        if (!empty($flightNumber)) {
            // Call the function to fetch flight details
            $flightDetails = getFlightDetailsByNumber($flightNumber);
            if ($flightDetails && isset($flightDetails['data'][0])) {
                $flight = $flightDetails['data'][0];
                // Display flight information
                echo "<div class='flight-info'>";
                echo "<h3>Flight Information</h3>";
                echo "<p><b>Flight Number:</b> " . $flight['flight']['iata'] . "</p>";
                echo "<p><b>Airline:</b> " . $flight['airline']['name'] . "</p>";
                echo "<p><b>Departure Airport:</b> " . $flight['departure']['airport'] . "</p>";
                echo "<p><b>Arrival Airport:</b> " . $flight['arrival']['airport'] . "</p>";
                echo "<p><b>Status:</b> " . $flight['flight_status'] . "</p>";
                echo "</div>";
            } else {
                echo "<p class='flight-info'>No flight found or an error occurred.</p>";
            }
        } else {
            echo "<p class='flight-info'>Please enter a flight number.</p>";
        }
    }
    ?>
</div>
    <div class="content">
        <h1>Flight Tracker</h1>
        <nav>
            <ul>
            <li><a href="./schedule.php">Flight Schedules</a></li>
                <li><a href="./airports.php">Airports</a></li>
                <li><a href="./airlines.php">Airlines</a></li>
                <li><a href="./historicalData.php">Historical Data</a></li>
            </ul>
        </nav>
        <!-- Display map -->
        <div id='map' style='height: 500px;'></div>
    </div>
    


    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <!-- Initialize the map -->
    <script>
        var map = L.map('map').setView([0, 0], 2);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
    </script>

    <?php
    // Loop through live flights and display their information on the map
    foreach ($live_flights_data['data'] as $flight) {
        if ($flight['live'] !== null) {
            $lat = $flight['live']['latitude'];
            $lon = $flight['live']['longitude'];
            $flightNumber = $flight['flight']['iata'];
            $airline = $flight['airline']['name'];
            $status = $flight['flight_status'];
            $departureAirport = $flight['departure']['airport'];
            $arrivalAirport = $flight['arrival']['airport'];
            $direction = $flight['live']['direction'];

            // Call function to display flight path with marker
            displayFlightPath($lat, $lon, $flightNumber, $airline, $status, $departureAirport, $arrivalAirport, $direction);
        }
    }
    ?>

    <meta http-equiv="refresh" content="6000">
</body>
</html>
