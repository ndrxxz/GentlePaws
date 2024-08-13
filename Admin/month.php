<?php 
include('../conn.php');

// Query to fetch total number of appointments per month
$sqlMonth = "SELECT DATE_FORMAT(date, '%Y-%m') AS month, COUNT(*) AS count FROM bookings GROUP BY DATE_FORMAT(date, '%Y-%m')";
$resultMonth = $conn->query($sqlMonth);

$dataMonth = array();
while($row = $resultMonth->fetch_assoc()) {
    $dataMonth[$row['month']] = $row['count'];
}

// Convert data to JSON format
echo json_encode($dataMonth);




?>