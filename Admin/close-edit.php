<?php 
session_start();
include('../conn.php');

if(isset($_POST['update'])){
    $id = mysqli_real_escape_string($conn, $_POST['update_id']);
    $date = mysqli_real_escape_string($conn, $_POST["date"]);

    $query = "UPDATE close SET date='$date' WHERE id=$id";
    $query_run = mysqli_query($conn, $query);

    if($query_run){
        $_SESSION['message'] = "Updated Successfully!";
        header("Location: close.php");
        exit(0);
    } else {
        $_SESSION['error'] = "Not Updated!";
        $_SESSION['error'] = "error";
        header("Location: close.php");
        exit(0);
    }
}

?>