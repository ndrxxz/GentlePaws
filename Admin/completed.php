<?php 
session_start();
include('../conn.php');
require '../vendor/autoload.php'; // Include PHPMailer autoload file

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $select = "UPDATE bookings SET status = 'Completed' WHERE id = '$id'";
    $result = mysqli_query($conn, $select);

    // Check if the appointment was successfully approved
    if ($result) {
        // Fetch appointment details
        $select_appointment = "SELECT * FROM bookings WHERE id = '$id'";
        $appointment_result = mysqli_query($conn, $select_appointment);
        $appointment = mysqli_fetch_assoc($appointment_result);

        // Compose email
        $recipient = $appointment['email']; // Assuming email field exists in appointment table
        $subject = 'Appointment Completed';
        $content = 'Your appointment has been completed. ';
        $content .= "Thank you for setting an appointment with us, kindly click the link below to give us a review. We appreciate your feedback!
        http://localhost/GentlePaws/review.php";
        
        // Send email
        $mail = new PHPMailer(true); // Enable verbose debug output
        try {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Your SMTP host
            $mail->SMTPAuth = true;
            $mail->Username = 'gentlepaws35@gmail.com';
            $mail->Password = 'yxua vxud dann pngu';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Email content
            $mail->setFrom('gentlepaws35@gmail.com', 'Gentle Paws');
            $mail->addAddress($recipient);
            $mail->Subject = $subject;
            $mail->Body = $content;

            // Send email
            $mail->send();
            echo 'Email has been sent successfully';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    header("Location: completed_appointment.php");
} else {
    header("Location: pending-appointment.php");
}

?>