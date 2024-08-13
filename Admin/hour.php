<?php 
include('../conn.php');

// Query to fetch appointment times
$sqlAppointments = "SELECT timeslot FROM bookings";
$resultAppointments = $conn->query($sqlAppointments);

// Array to store appointment counts per hour
$appointmentCountsPerHour = array_fill(0, 24, 0);

// Process appointment times
while($row = $resultAppointments->fetch_assoc()) {
    // Extract hour from appointment time
    $appointmentTime = $row['timeslot'];
    $hour = (int)substr($appointmentTime, 0, 2); // Extract hour part

    // If the hour is greater than 12, subtract 12 to convert to 12-hour format
    if ($hour > 12) {
        $hour -= 12;
    }

    // Increment appointment count for the hour
    $appointmentCountsPerHour[$hour]++;
}

// Convert data to JSON format
echo json_encode($appointmentCountsPerHour);


?>