<?php 
session_start();
include('../User/js/script.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if(isset( $_POST['submit'])){
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $message = $_POST['message'];

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
    $mail->setFrom($email, $name);
    $mail->addAddress("gentlepaws35@gmail.com", "Gentle Paws");
    $mail->addReplyTo($_POST['email'], $_POST['name']);

    //Content
    $mail->isHTML(true);
    $mail->Subject = $_POST['subject'];
    $message_template = "Name: $name <br>
                         Contact: $contact<br>
                         Email: $email<br><br>
                         Message: $message";
    $mail->Body = $message_template;

    $mail->send();
    echo "<script>alert('Your message has been sent!')</script>";
    // $_SESSION['success'] = "Your message has been sent!";
    // header("Location: mail.php");
    // exit(0);
}else{
    // $_SESSION['warning']  = "Something went wrong, please try again later.";
    header("Location: home.php");
    // exit(0);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Sent | Gentle Paws</title>
    <link rel="stylesheet" href="css/mail.css">
    <link rel="shortcut icon" href="gentle paws logo.png" type="image/x-icon">
</head>
<body>
    <div class="content">
        <h1>We received your message!</h1>
        <p>Thank you for contacting us!</p>
        <a href="../User/home.php" class="button">Go Back to Homepage</a>
    </div>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>
</html>
