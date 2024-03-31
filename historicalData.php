<?php
// Include the flight_functions.php file
require_once('./api/flight_functions.php');

// Initialize variables
$flightNumber = $_GET['flightNumber'] ?? null;
$airline = $_GET['airline'] ?? null;
$date = $_GET['date'] ?? null;

// Fetch historical flight data based on filters
$historicalFlightData = historical($airline, $date, $flightNumber);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historical Flight Data</title>
    <link rel="stylesheet" href="./css/index.css">
</head>
<body>
    <h1>Historical Flight Data</h1>

    <!-- Filter form -->
    <form class="bar" method="get">
        <label for="flightNumber">Flight Number:</label>
        <input type="text" name="flightNumber" id="flightNumber" value="<?= htmlspecialchars($flightNumber) ?>">

        <label for="airline">Airline:</label>
        <input type="text" name="airline" id="airline" value="<?= htmlspecialchars($airline) ?>">

        <label for="date">Date:</label>
        <input type="date" name="date" id="date" value="<?= htmlspecialchars($date) ?>">

        <button type="submit">Apply Filters</button>
    </form>

   <!-- Display Historical Flight Data -->
<?php if (!empty($historicalFlightData['data'])): ?>
    <?php foreach ($historicalFlightData['data'] as $flight): ?>
        <div class="flight-schedules">
            <ul>
                <li>
                    <b>Flight Number:</b> <?= $flight['flight']['iata'] ?>
                    <b>Date:</b> <?= $flight['flight_date'] ?>
                    <p><b>Departure Delay (min): </b> <?= htmlspecialchars($flight['departure']['delay']) ?></p>
                    <p><b>Arrival Delay (min): </b> <?= htmlspecialchars($flight['arrival']['delay']) ?></p>
                    <p><b>Departure Time:</b> <?= htmlspecialchars($flight['departure']['scheduled']) ?></p>
                    <p><b>Arrival Time:</b> <?= htmlspecialchars($flight['arrival']['scheduled']) ?></p>
                    <p><b>Airline:</b> <?= htmlspecialchars($flight['airline']['name']) ?></p>
                    <p><b>Departure Airport:</b> <?= htmlspecialchars($flight['departure']['airport']) ?></p>
                    <p><b>Arrival Airport:</b> <?= htmlspecialchars($flight['arrival']['airport']) ?></p>
                    <p><b>Flight Status:</b> <?= htmlspecialchars($flight['flight_status']) ?></p>
                    <!-- Add more flight details as needed -->
                </li>
            </ul>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="flight-schedules">
        <p>No such flight found.</p>
    </div>
<?php endif; ?>

</body>
</html>
