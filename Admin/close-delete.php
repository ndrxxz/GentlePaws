<?php 
session_start();
include('../conn.php');

if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $query = "DELETE FROM close WHERE id='$id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run){
        $_SESSION['message'] = "Deleted Successfully!";
        header("Location: close.php");
        exit(0);
    } else {
        $_SESSION['error'] = "Not Deleted! Please Try Again.";
        header("Location: close.php");
        exit(0);
    }
}


?>