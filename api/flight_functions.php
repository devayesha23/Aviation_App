<?php
require_once('config.php');

// Function to fetch live flight data
function getLiveFlightData() {
    global $api_key, $base_url;
    $url = $base_url . "flights?access_key=" . $api_key ."&%20flight_status=active";
    $response = file_get_contents($url);
    return json_decode($response, true);
}


// Function to fetch details of a specific flight by its flight number
function getFlightDetailsByNumber($flightNumber) {
    global $api_key, $base_url;
    $url = $base_url . "flights?access_key=" . $api_key . "&flight_iata=" . $flightNumber. "&limit=1";
    $response = file_get_contents($url);
    return json_decode($response, true);
}

// Function to fetch flight schedules
function getFlightSchedules($airline, $date, $minDelayDep, $maxDelayDep, $minDelayArr, $maxDelayArr) {
    global $api_key, $base_url;
    
    // Convert date to UTC format
    $utcDate = date("Y-m-d", strtotime($date)) . "T00:00:00+00:00";

    $url = $base_url . "flights?access_key=" . $api_key . "&flight_date=" . $date;

    if (!empty($airline)) {
        $url .= "&airline_name=" . urlencode($airline);
    }
    if (!empty($minDelayDep)) {
        $url .= "&min_delay_dep=" . urlencode($minDelayDep);
    }
    if (!empty($maxDelayDep)) {
        $url .= "&max_delay_dep=" . urlencode($maxDelayDep);
    }
    if (!empty($minDelayArr)) {
        $url .= "&min_delay_arr=" . urlencode($minDelayArr);
    }
    if (!empty($maxDelayArr)) {
        $url .= "&max_delay_arr=" . urlencode($maxDelayArr);
    }

    $response = file_get_contents($url);
    return json_decode($response, true);
}

// Function to fetch airport information
function getAirportInfo() {
    global $api_key, $base_url;
    $url = $base_url . "airports?access_key=" . $api_key;
    $response = file_get_contents($url);
    return json_decode($response, true);
}

// Function to fetch airline data
function getAirlineData() {
    global $api_key, $base_url;
    $url = $base_url . "airlines?access_key=" . $api_key;
    $response = file_get_contents($url);
    return json_decode($response, true);
}

function historical($airline, $date, $flightNumber) {
    global $api_key, $base_url;

    $url = $base_url . "flights?access_key=" . $api_key . "&flight_date=" . $date;

    if (!empty($airline)) {
        $url .= "&airline_name=" . urlencode($airline);
    }
    if (!empty($flightNumber)) {
        $url .= "&flight_iata=" . urlencode($flightNumber);
    }

    $response = file_get_contents($url);
    return json_decode($response, true);
}

?>
