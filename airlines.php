<?php
// Include the flight_functions.php file
require_once('./api/flight_functions.php');

// Fetch airline data
$airlineData = getAirlineData();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airline Directory</title>
    <link rel="stylesheet" href="./css/index.css">
</head>
<body>
    <h1>Airline Directory</h1>
    <div class='bar'></div>
    <!-- Display Airline Information -->
    <ul class="flight-schedules">
        <?php foreach ($airlineData['data'] as $airline): ?>
            <li>
                <b>Airline Name:</b> <?= $airline['airline_name'] ?><br>
                <b>Country:</b> <?= $airline['country_name'] ?><br>
                <b>Fleet Size:</b> <?= $airline['fleet_size'] ?><br>
                <b>Fleet Average Age:</b> <?= $airline['fleet_average_age'] ?><br>
                <b>Type: </b> <?= $airline['type'] ?><br>
                <b>Founded in: </b> <?= $airline['date_founded'] ?><br>
                <!-- Add more airline details as needed -->
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
