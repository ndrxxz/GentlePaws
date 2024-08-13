<?php
session_start();
include('../conn.php');

if(isset($_POST['update'])){
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);

    // Contact number validation
    if(!preg_match('/^(09|\+639)\d{9}$/', $contact)) {
        $_SESSION['error'] = "Contact number must start with '09' or '+63' and be 11 digits long.";
        $_SESSION['error-code'] = "warning";
        header("Location: admin_registered_profile.php");
        exit(0);
    }

    $query = "UPDATE users SET fname='$fname', lname='$lname', email='$email', contact='$contact' WHERE id='$id'";
    $_SESSION['message'] = "Updated Successfully!";


    $pass = mysqli_real_escape_string($conn, md5($_POST['pass']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpass']));

    // Proceed with password validation only if the password fields are not empty
    if (!empty($pass) && !empty($cpass)) {
        // Password validation
        if (strlen($_POST['pass']) < 8 || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$/', $_POST['pass'])) {
            $_SESSION['error'] = "Password should contain at least 8 characters including uppercase, lowercase letters, numbers, and symbols.";
            $_SESSION['error-code'] = "warning";
            header("Location: admin_registered_profile.php");
            exit(0);
        }

        if ($pass !== $cpass) {
            $_SESSION['error'] = "Passwords do not match.";
            $_SESSION['error-code'] = "warning";
            header("Location: admin_registered_profile.php");
            exit(0);
        }

        $query = "UPDATE users SET pass='$cpass' WHERE id='$id'";
        $query_run = mysqli_query($conn, $query);

        if($query_run){
            $_SESSION['message'] = "Password Updated Successfully!";
            header("Location: admin_registered_profile.php");
            exit(0);
        } else {
            $_SESSION['error'] = "Password Not Updated!";
            $_SESSION['error-code'] = "error";
            header("Location: admin_registered_profile.php");
            exit(0);
        }
    }

    // $query = "UPDATE users SET fname='$fname', lname='$lname', email='$email', contact='$contact', pass='$cpass' WHERE id='$id'";
    // $query_run = mysqli_query($conn, $query);

    // if($query_run){
    //     $_SESSION['message'] = "User Updated Successfully!";
    //     header("Location: admin_registered_profile.php");
    //     exit(0);
    // } else {
    //     $_SESSION['error'] = "User Not Updated!";
    //     $_SESSION['error-code'] = "error";
    //     header("Location: admin_registered_profile.php");
    //     exit(0);
    // }
}
?>
