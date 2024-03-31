<?php
require_once('./api/flight_functions.php');

// Parse filter parameters
$airline = $_GET['airline'] ?? null;
$date = $_GET['date'] ?? date('Y-m-d');
$minDelayDep = $_GET['minDelayDep'] ?? null;
$maxDelayDep = $_GET['maxDelayDep'] ?? null;
$minDelayArr = $_GET['minDelayArr'] ?? null;
$maxDelayArr = $_GET['maxDelayArr'] ?? null;

// Get flight schedules based on filters
$flightSchedules = getFlightSchedules($airline, $date, $minDelayDep, $maxDelayDep, $minDelayArr, $maxDelayArr);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Schedules</title>
    <link rel="stylesheet" href="./css/index.css">
</head>
<body>
    <h1>Flight Schedules</h1>

    <!-- Filter form -->
    <form class="bar" method="get">
    <label for="airline">Airline:</label>
    <input type="text" name="airline" id="airline" value="<?= htmlspecialchars($airline) ?>">
    
    <label for="date">Date:</label>
    <input type="date" name="date" id="date" value="<?= htmlspecialchars($date) ?>">
    <br>

    <label for="minDelayDep">Min Delay Departure (min):</label>
    <input type="number" name="minDelayDep" id="minDelayDep" value="<?= htmlspecialchars($minDelayDep) ?>">

    <label for="maxDelayDep">Max Delay Departure (min):</label>
    <input type="number" name="maxDelayDep" id="maxDelayDep" value="<?= htmlspecialchars($maxDelayDep) ?>">

    <label for="minDelayArr">Min Delay Arrival (min):</label>
    <input type="number" name="minDelayArr" id="minDelayArr" value="<?= htmlspecialchars($minDelayArr) ?>">

    <label for="maxDelayArr">Max Delay Arrival (min):</label>
    <input type="number" name="maxDelayArr" id="maxDelayArr" value="<?= htmlspecialchars($maxDelayArr) ?>">
<br>
    <button type="submit">Apply Filters</button>
</form>

    <!-- Display filtered flight schedules -->
    <div class="flight-schedules">
        <?php if (!empty($flightSchedules['data'])): ?>
            <ul>
                <?php foreach ($flightSchedules['data'] as $schedule): ?>
                    <li>
                        <p><b>Flight Date:</b> <?= htmlspecialchars($schedule['flight_date']) ?></p>
                        <p><b>Departure Delay (min): </b> <?= htmlspecialchars($schedule['departure']['delay']) ?></p>
                        <p><b>Arrival Delay (min): </b> <?= htmlspecialchars($schedule['arrival']['delay']) ?></p>
                        <p><b>Departure Time:</b> <?= htmlspecialchars($schedule['departure']['scheduled']) ?></p>
                        <p><b>Arrival Time:</b> <?= htmlspecialchars($schedule['arrival']['scheduled']) ?></p>
                        <p><b>Airline:</b> <?= htmlspecialchars($schedule['airline']['name']) ?></p>
                        <p><b>Departure Airport:</b> <?= htmlspecialchars($schedule['departure']['airport']) ?></p>
                        <p><b>Arrival Airport:</b> <?= htmlspecialchars($schedule['arrival']['airport']) ?></p>
                        <p><b>Flight Status:</b> <?= htmlspecialchars($schedule['flight_status']) ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No flight schedules found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
