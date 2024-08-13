<?php
session_start();
include("../conn.php");
           
if(isset($_POST['update'])){
    $email = mysqli_escape_string($conn, $_POST['email']);
    $new_password = mysqli_escape_string($conn, md5($_POST['new_password']));
    $confirm_password = mysqli_escape_string($conn, md5($_POST['confirm_password']));

    $token = mysqli_escape_string($conn, $_POST['pass_token']);

    if(!empty($token)){
        if(!empty($email) && !empty($new_password) && !empty($confirm_password)){
            $check_token = "SELECT verify_token FROM users WHERE verify_token='$token' LIMIT 1";
            $check_token_run = mysqli_query($conn, $check_token);

            if(mysqli_num_rows($check_token_run) > 0){
                if($new_password == $confirm_password){
                    $update_password = "UPDATE users SET pass='$new_password' WHERE verify_token='$token' LIMIT 1";
                    $update_password_run = mysqli_query($conn, $update_password);

                    if($update_password_run){
                        $new_token = md5(rand());
                        $update_new_token = "UPDATE users SET verify_token='$new_token' WHERE verify_token='$token' LIMIT 1";
                        $update_new_token_run = mysqli_query($conn, $update_new_token);

                        $_SESSION['status'] = "Password successfully updated";
                        header("Location: login1.php");
                        exit(0);
                    } else {
                        $_SESSION['status'] = "Did not update password. Something went wrong!";
                        header("Location: password-change.php?token=$token&email=$email");
                        exit(0);
                    }
                } else { 
                    $_SESSION['status'] = "Password and Confirm Password does not match";
                    header("Location: password-change.php?token=$token&email=$email");
                    exit(0);
                }
            } else {
                $_SESSION['status'] = "Invalid Token";
                header("Location: password-change.php?token=$token&email=$email");
                exit(0);
            }
        } else {
            $_SESSION['status'] = "All fields are required";
            header("Location: password-change.php?token=$token&email=$email");
            exit(0);
        }
    } else {
        $_SESSION['status'] = "No Available Token";
        header("Location: password-change.php");
        exit(0);
    }
}
?>
