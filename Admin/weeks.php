<?php 
include('../conn.php');


// Query to fetch total number of appointments per week
$sqlWeek = "SELECT YEARWEEK(date) AS week, COUNT(*) AS count FROM bookings GROUP BY YEARWEEK(date)";
$resultWeek = $conn->query($sqlWeek);

$dataWeek = array();
while($row = $resultWeek->fetch_assoc()) {
    $dataWeek[$row['week']] = $row['count'];
}

// Convert data to JSON format
echo json_encode($dataWeek);

?>