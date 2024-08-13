<?php 
session_start();
include('../conn.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';
function send_password_reset($get_fname, $get_lname, $get_email, $token){
    // Sending email to the user's registered email address with a link containing token for password reset
    $mail = new PHPMailer(true);
    $mail-> SMTPDebug = 0;
    $mail->isSMTP();                                            //Send using SMTP
    

    $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
    $mail->Username   = 'gentlepaws35@gmail.com';               //SMTP username
    $mail->Password   = 'yxua vxud dann pngu';                  //SMTP password
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication

    $mail->SMTPSecure = "tls";                                  //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('gentlepaws35@gmail.com', 'Gentle Paws');
    $mail->addAddress($get_email);                              //Add a recipient

    $mail->isHTML(true);                                        //Set email format to HTML
    $mail->Subject = 'Reset Password Request';

    $email_template = "
        <h2>Welcome to Gentle Paws</h2>
        <h5>We've received your request to reset your password.</h5>
        <h5>To reset, simply click the reset password link.</h5>
        <br>
        <a href='http://localhost/GentlePaws/User/password-change.php?token=$token&email=$get_email'>Reset Password</a>
    ";

    $mail->Body = $email_template;
    $mail->send();
    // echo 'Message has been sent';
}

if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $token = md5(rand());

    $check_email = "SELECT email FROM users WHERE email='$email' LIMIT 1";
    $check_email_run = mysqli_query($conn, $check_email);

    if(mysqli_num_rows($check_email_run) > 0){
        $row = mysqli_fetch_array($check_email_run);
        $get_fname = $row['fname'];
        $get_lname =  $row['lname'];
        $get_email = $row['email'];

        $update_token = "UPDATE users SET verify_token='$token' WHERE email='$get_email' LIMIT 1 ";
        $update_token_run = mysqli_query($conn, $update_token);

        if($update_token_run){
            send_password_reset($get_fname, $get_lname, $get_email, $token);

            $_SESSION['status'] = "A link to reset your password has been sent to your registered email. Please check it out!";
            header("Location: reset.php");
            exit(0);
        } else {
            $_SESSION['status'] = "Something went wrong.";
            header("Location: reset.php");
            exit(0);
        }
    }
} else {
    $_SESSION['status'] = "No Email Found";
    header("Location: reset.php");
    exit(0);
}


?>