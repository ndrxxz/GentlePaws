<?php
require('../conn.php');
require_once '../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Initialize Dompdf options
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

// Instantiate Dompdf
$pdf = new Dompdf($options);

if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conn, $_GET['id']);  // sanitize the id

    $query = "SELECT * FROM bookings WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    // Load HTML content
    $html = '<!DOCTYPE html>
    <html>
    <head>
        <title>Appointment Form | Gentle Paws</title>
        <style type="text/css">
            body{
                font-family: Arial, sans-serif;
            }
        </style>
    </head>
    <body>
        <div style="text-align: center; display: flex; justify-content: center; align-items: center;">
            <!-- <img src="../img/gentle paws logo.png" alt="Gentle Paws Logo" style="width: 90px; height: 100px;"> -->
            <div class="header" style="line-height: 5px;">
                <h1 style="font-size: 40px;"><span style="color: #fc7c8c;">Gentle</span> <span style="color: #5990ed;">Paws</span></h1>
                <h4>gentlepaws35@gmail.com / 09123456789</h4>
                <h4>Pasig, Philippines</h4>
            </div>
        </div>
        <div class="line" style="border-bottom: 2px solid #fc7c8c; margin-top: 5px;"></div>
        <h1>Owners Info</h1>';

    if(mysqli_num_rows($result) > 0){
        $html .= '<table border="0" cellspacing="0" cellpadding="5" style="text-align: left;">';
        foreach($result as $row){
            $html .= '<tr>
                        <th style="text-align: left;">Name: </th>
                        <td style="padding-left: 170px;">'.$row['fname'].'</td>
                    </tr>
                    <tr>
                        <th style="text-align: left;">Contact Number: </th>
                        <td style="padding-left: 170px;">'.$row['lname'].'</td>
                    </tr>
                    <tr>
                        <th style="text-align: left;">Contact Number: </th>
                        <td style="padding-left: 170px;">'.$row['contact'].'</td>
                    </tr>
                    <tr>
                        <th style="text-align: left;">Email: </th>
                        <td style="padding-left: 170px;">'.$row['email'].'</td>
                    </tr>';
        }
        $html .= '</table>';
        $html .= '<div class="line" style="border-bottom: 2px solid #fc7c8c; margin-top: 5px;"></div>';
        $html .= '<h1>Pet Info</h1>';
        $html .= '<table border="0" cellspacing="0" cellpadding="5" style="text-align: left;">';
        foreach($result as $row){
            $html .= '<tr>
                <th style="text-align: left;">Pet Name: </th>
                <td style="padding-left: 220px;">'.$row['petname'].'</td>
            </tr>
            <tr>
                <th style="text-align: left;">Pet Type: </th>
                <td style="padding-left: 220px;">'.$row['type'].'</td>
            </tr>
            <tr>
                <th style="text-align: left;">Pet Age: </th>
                <td style="padding-left: 220px;">'.$row['age'].'</td>
            </tr>
            <tr>
                <th style="text-align: left;">Pet Breed: </th>
                <td style="padding-left: 220px;">'.$row['breed'].'</td>
            </tr>';
        }
        $html .= '</table>';
        $html .= '<div class="line" style="border-bottom: 2px solid #fc7c8c; margin-top: 5px;"></div>
                <h1>Appointment Details</h1>
                <table border="0" cellspacing="0" cellpadding="5" style="text-align: left;">';
        foreach($result as $row){
            $html .= '<tr>
                <th style="text-align: left;">Reason of Appointment: </th>
                <td style="padding-left: 120px;">'.$row['reason'].'</td>
            </tr>
            <tr>
                <th style="text-align: left;">Appointment Date: </th>
                <td style="padding-left: 120px;">'.date('M d, Y', strtotime($row['date'])).'</td>
            </tr>
            <tr>
                <th style="text-align: left;">Appointment Time: </th>
                <td style="padding-left: 120px;">'.$row['timeslot'].'</td>
            </tr>';
        }
        $html .= '</table>
            <footer style="margin-top: 100px;  text-align: center;">
                <p>Thank you for setting an appointment with us.</p>
            </footer>';
    } else {
        $html .= "No data found";
    }

    $html .= '</body></html>';

    // Load HTML into Dompdf
    $pdf->loadHtml($html);

    // Set paper size and orientation
    $pdf->setPaper('A4', 'portrait');

    // Render PDF
    $pdf->render();

    // Output PDF
    $pdf->stream('Appointment Form.pdf');
}
?>
