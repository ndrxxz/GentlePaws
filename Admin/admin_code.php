<?php 
session_start();
include ('../conn.php');

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';
function sendemail_verify($fname, $lname, $email, $verify_token){
    //Instantiate PHPMailer class
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
    $mail->addAddress($email);                                  //Add a recipient

    $mail->isHTML(true);                                        //Set email format to HTML
    $mail->Subject = 'Email Verification from Gentle Paws';

    $email_template = "
        <h2>Welcome to Gentle Paws</h2>
        <h5>Verify your email address to Login with the given link below</h5>
        <br>
        <a href='http://localhost/GentlePaws/User/verify-email.php?token=$verify_token'>Verify Here</a>
    ";

    $mail->Body = $email_template;
    $mail->send();
    // echo 'Message has been sent';
}

if(isset($_POST['submit'])){
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['pass']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpass']));
    $verify_token = md5(rand());

    $check_email_query = "SELECT email FROM users WHERE email='$email' LIMIT 1";
    $check_email_query_run = mysqli_query($conn, $check_email_query);
    if(mysqli_num_rows($check_email_query_run)>0){
        $_SESSION['error'] = "The provided Email is already registered! Please try another one.";
        $_SESSION['error-code'] = "warning";
        header("Location: admin_create.php");
        
    } else {
        // Contact number validation
        if(!preg_match('/^(09|\+639)\d{9}$/', $contact)) {
            $_SESSION['error'] = "Contact number must start with '09' or '+63' and be 11 digits long.";
            $_SESSION['error-code'] = "warning";
            header("Location: admin_create.php");
            exit(0);
        }

        // Password validation
        if (strlen($_POST['pass']) < 8 || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$/', $_POST['pass'])) {
            $_SESSION['error'] = "Password should contain at least 8 characters including uppercase, lowercase letters, numbers, and symbols.";
            $_SESSION['error-code'] = "warning";
            header("Location: admin_create.php");
            exit(0);
        }

        if($pass === $cpass){
            $query = "INSERT INTO users (fname, lname, email, contact, pass, verify_token) 
            VALUES ('$fname', '$lname', '$email', '$contact', '$cpass', '$verify_token')";

            $query_run = mysqli_query($conn, $query);

            if($query_run){
                sendemail_verify("$fname", "$lname", "$email", "$verify_token");

                $_SESSION['message'] = "Registration Successful! Please verify your email address";
                header("Location: admin_create.php");
                exit(0);
            } else {
                $_SESSION['error'] = "Registration Failed!";
                $_SESSION['error'] = "error";
                header("Location: admin_create.php");
                exit(0);
            }
        } else {
            $_SESSION['error'] = "Password did not match";
            $_SESSION['error-code'] = "warning";
            header("Location: admin_create.php");
            exit(0);
        }
    }

}

?>