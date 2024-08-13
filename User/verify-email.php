<?php 
session_start();
include('../conn.php');

$alert = "";

if(isset($_GET['token'])){
    $token = $_GET['token'];
    $verify_query = "SELECT verify_token,verify_status FROM users WHERE verify_token='$token' LIMIT 1";
    $verify_query_run = mysqli_query($conn, $verify_query);

    if(mysqli_num_rows($verify_query_run) > 0){
        $row = mysqli_fetch_array($verify_query_run);
        
        if($row['verify_status'] == "0"){
            $clicked_token = $row['verify_token'];
            $update_query = "UPDATE users SET verify_status='1' WHERE verify_token='$clicked_token' LIMIT 1 ";
            $update_query_run = mysqli_query($conn, $update_query);

            if($update_query_run){
                $_SESSION['status'] = "Account Verified Successfully! Please Log In to Continue.";
                header("Location: login1.php");
                exit(0);
            } else {
                $_SESSION['status'] = "Error Occured! Please Try Again Later.";
                header("Location: login1.php");
                exit(0);
            }
        } else {
            $_SESSION['status'] = "Your email is already verified! Please login to access your account.";
            header("Location: login1.php");
            exit(0);
        }
    } else {
        $_SESSION['status'] = "Invalid token!";
        header("Location: login1.php");
    }
} else {
    $_SESSION['status'] = "Not Allowed";
    header("Location: login1.php");
}

?>