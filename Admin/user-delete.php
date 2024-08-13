<?php 
session_start();
include('../conn.php');

if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $query = "DELETE FROM users WHERE id='$id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run){
        $_SESSION['message'] = "User Deleted Successfully!";
        header("Location: admin_registered_profile.php");
        exit(0);
    } else {
        $_SESSION['error'] = "User Not Deleted! Please Try Again.";
        header("Location: admin_registered_profile.php");
        exit(0);
    }
}


?>