<?php 
session_start();
include('../conn.php');

if(isset($_POST['update'])){
    $id = mysqli_real_escape_string($conn, $_POST['update_id']);
    $services = mysqli_real_escape_string($conn, $_POST["services"]);

    $query = "UPDATE services SET name='$services' WHERE id=$id";
    $query_run = mysqli_query($conn, $query);

    if($query_run){
        $_SESSION['message'] = "Service Updated Successfully!";
        header("Location: admin_services.php");
        exit(0);
    } else {
        $_SESSION['error'] = "Service Not Updated!";
        $_SESSION['error'] = "error";
        header("Location: admin_services.php");
        exit(0);
    }
}

?>