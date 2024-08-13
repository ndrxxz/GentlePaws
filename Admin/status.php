<?php 
include('../conn.php');

// Query to fetch counts for each status
$sql = "SELECT status, COUNT(*) AS count FROM bookings GROUP BY status";
$result = $conn->query($sql);

$data = array();
while($row = $result->fetch_assoc()) {
    $data[$row['status']] = $row['count'];
}

// Convert data to JSON format
echo json_encode($data);

?>