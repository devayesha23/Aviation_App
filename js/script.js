// Function to display flight path on the map
function displayFlightPath(latitude, longitude, flightNumber, airline, status, departureAirport, arrivalAirport) {
    // Add marker for flight
    var marker = L.marker([latitude, longitude]).addTo(map);
    marker.bindPopup("<b>Flight:</b> " + flightNumber + "<br>" +
                     "<b>Airline:</b> " + airline + "<br>" +
                     "<b>Status:</b> " + status + "<br>" +
                     "<b>Departure:</b> " + departureAirport + "<br>" +
                     "<b>Arrival:</b> " + arrivalAirport).openPopup();

    // Optionally, you can also add the flight path display logic here if needed
    // For example, you can draw a line between multiple flight coordinates to represent the flight path
}
