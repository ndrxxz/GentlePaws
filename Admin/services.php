<?php 
include('../conn.php');

// Query to fetch total number of appointments per service type
$sqlService = "SELECT reason, COUNT(*) AS count FROM bookings GROUP BY reason";
$resultService = $conn->query($sqlService);

$dataService = array();
while($row = $resultService->fetch_assoc()) {
    $dataService[$row['reason']] = $row['count'];
}

// Convert data to JSON format
echo json_encode($dataService);

?>