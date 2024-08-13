<?php 
session_start();
include('../conn.php');

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

$fname = $lname = $email = $contact = $pass = $cpass = "";
$fnameErr = $lnameErr = $emailErr = $contactErr = $passErr = $cpassErr = "";

if(isset($_POST['submit'])){
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['pass']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpass']));
    $verify_token = md5(rand());

    if(empty($_POST['fname'])){
        // check if fname field is empty
        $fnameErr = "First name is required";
    }

    if(empty($_POST['lname'])){
        // check if lname field is empty, display error message.
        $lnameErr = "Last name is required";
    }

    if(empty($_POST['email'])){
        // check if email field is empty
        $emailErr = "Email is required";
    } else {
        // check if e-mail address is well-formed
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Email must be a valid email address";
        } else {
            // check if email is already exists
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn,$sql);
            $row = mysqli_fetch_array($result);
            if(!empty($row)){
                $emailErr = "This Email Address Is Already Exists.";
            }
        }
    }

    if(empty($_POST['contact'])){
        //check if contact number field is empty
        $contactErr = "Contact number is required";
    }

    $pass = mysqli_real_escape_string($conn, $_POST['pass']);
if (empty($_POST['pass'])){
    $passErr = "Pass is required";
} else{
// Validate the password
if (strlen($pass) < 8) {
    $passErr = "Password should contain at least 8 characters";
} elseif (!preg_match('/[A-Z]/', $pass)) {
    $passErr = "Password should contain at least one uppercase letter";
} elseif (!preg_match('/[a-z]/', $pass)) {
    $passErr = "Password should contain at least one lowercase letter";
} elseif (!preg_match('/[0-9]/', $pass)) {
    $passErr = "Password should contain at least one number";
} elseif (!preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $pass)) {
    $passErr = "Password should contain at least one special character";
} else {
    // Hash the password using bcrypt
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
}
} 
if($pass == $cpass){
    $cpassErr = "Passwords do not match";
}

if($fnameErr == "" && $lnameErr =="" && $emailErr =="" && $contactErr == "" && $passErr == "" && $cpassErr == "" ) {
    // Store the hashed password in the database
    $query = "INSERT INTO users (fname, lname, email, contact, pass, verify_token) 
              VALUES ('$fname', '$lname', '$email', '$contact', '$cpass', '$verify_token')";
    
    // Execute the query to insert user data into the database
    $query_run = mysqli_query($conn, $query);
    
    // Check if the query was successful
    if($query_run){
        sendemail_verify($fname, $lname, $email, $verify_token);
        $_SESSION['status'] = "Registration Successful! Please verify your email address";
        header("Location: register.php");
        exit(0);
    } else {
        $_SESSION['status'] = "Registration Failed!";
        header("Location: register.php");
        exit(0);
    }
}
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/register.css">
    <link rel="shortcut icon" href="gentle paws logo.png" type="image/x-icon">
    <title>Register</title>
</head>
<body>
    <div class="container">
        <form class="form-signup justify-content-center align-item-center p-4" action="register.php" method="POST">
            <h1 class="fw-bold mb-3 text-center">Register</h1>
            <style>
        * {
           
        }
        .wrapper{
            font-size: 12px;
            
        }
       
        .invalid{
            color: red;
        }
        .valid{
            color: green;
        }
        .error{
            color: red;
        }

        </style>
            <?php
                        if(isset($_SESSION['status'])){
                    ?>
                        <div class="alert alert-success">
                            <h6><?= $_SESSION['status']; ?></h6>
                        </div>
                    <?php
                        unset($_SESSION['status']);
                        }
                    ?>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <input type="text" class="form-control" name="fname" id="" placeholder="First Name">
                        <p id="error"><?php echo $fnameErr; ?></p>
                    </div>
                    <div class="col-md-6 mb-2">
                        <input type="text" class="form-control" name="lname" id="" placeholder="Last Name">
                        <p id="error"><?php echo $lnameErr; ?></p>
                    </div>
                    <div class="col-md-6 mb-2">
                        <input type="text" class="form-control" name="email" id="" placeholder="Email">
                        <p id="error"><?php echo $emailErr; ?></p>
                    </div>
                    <div class="col-md-6">
                    <input type="text" class="form-control" name="contact" id="contact" placeholder="Contact Number" required>
                        <!-- Error message for contact number validation -->
                        <p id="contact-error" class="error"></p>
                    </div>

                    <div class="col-md-6 mb-3">
                    
                    <input type="password" class="form-control" name="pass" id="pass" placeholder="Password" onclick="showPasswordValidation()">
                    <p id="error"><?php echo $passErr; ?></p>
    <div class="wrapper" id="passwordWrapper" style="display: none;">
        
                   
                    <br>
    <ul>   
        <li id="eightCharacters">Contain 8 Charatacters </li>
        <li id="lowerCase" >Contain LowerCase Characters</li>
        <li id="upperCase" >Contain Uppercase Characters</li>
        <li id="containNumber">Contain Numbers</li>
        <li id="specialCharacters">Contain Special Characters</li> 
    </ul>
    
</div>
<script>
    var pass = document.getElementById('pass');
    var eightCharacters = document.getElementById('eightCharacters');
    var lowerCase = document.getElementById('lowerCase');
    var upperCase = document.getElementById('upperCase');
    var containNumber = document.getElementById('containNumber');
    var specialCharacters = document.getElementById('specialCharacters');



    pass.onkeyup = () => { 
        
        var userPassword = pass.value;


        // LowerCaseCheck Letters
        var pattern = /[a-z]/g;
        if(userPassword.match(pattern)){
            lowerCase.classList.add('valid');
            lowerCase.classList.remove('invalid');
        }else{
            lowerCase.classList.remove('valid');
            lowerCase.classList.add('invalid');
        }

          // UpperCaseCheck Letters
          var pattern = /[A-Z]/g;
        if(userPassword.match(pattern)){
            upperCase.classList.add('valid');
            upperCase.classList.remove('invalid');
        }else{
            upperCase.classList.remove('valid');
            upperCase.classList.add('invalid');
        }

            // Check for Numbers
            var pattern = /[0-9]/g;
        if(userPassword.match(pattern)){
            containNumber.classList.add('valid');
            containNumber.classList.remove('invalid');
        }else{
            containNumber.classList.remove('valid');
            containNumber.classList.add('invalid');
        }

        // Check for length of Password
        if(userPassword.length >= 8){
            eightCharacters.classList.add('valid');
            eightCharacters.classList.remove('invalid');
        }else{
            eightCharacters.classList.remove('valid');
            eightCharacters.classList.add('invalid');
        }

        // Check for Special
          var pattern = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
        if(userPassword.match(pattern)){
            specialCharacters.classList.add('valid');
            specialCharacters.classList.remove('invalid');
        }else{
            specialCharacters.classList.remove('valid');
            specialCharacters.classList.add('invalid');
        }

        if (userPassword.match(pattern)){
            specialCharacters.classList.remove('invalid');
            eightCharacters.classList.remove('invalid');
            lowerCase.classList.remove('invalid');
            upperCase.classList.remove('invalid');
            containNumber.classList.remove('invalid');

        } else {
            
        }

    } 
</script>
</div>   

                 
                    <div class="col-md-6">
                        <input type="password" class="form-control" name="cpass" id="" placeholder="Confirm Password">
                        <p id="error"><?php echo $cpassErr; ?></p>
                    </div>
                </div>
            </div>  

            
            <div class="mt-1">
                <button type="submit" name="submit" class="btn btn-primary text-white w-100">Sign Up</button>
            </div>
            <div class="mt-3">
                <span>Already have an account? </span><a href="login1.php" class="p-0 border-0 bg-transparent primaryColor">Login</a>
            </div>
        </form>
         <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JavaScript for contact number validation -->
    <script>
        var contactInput = document.getElementById('contact');
        var contactError = document.getElementById('contact-error');


        // Function to validate contact number
        function validateContactNumber() {
            var contact = contactInput.value;

            // Regular expression to match contact number format
            var regex = /^(?:\+63|09)\d{9}$/;

            if (!regex.test(contact)) {
                contactError.textContent = "Invalid contact number. It must start with '09' and have 11 digits";
                return false;
            } else {
                contactError.textContent = "";
                return true;
            }
        }

        // Event listener for input change
        contactInput.addEventListener('input', function() {
            validateContactNumber();
        });

        // Form submission validation
        document.querySelector('form').addEventListener('submit', function(event) {
            if (!validateContactNumber()) {
                event.preventDefault(); // Prevent form submission if contact number is invalid
            }
        });
    </script>
<script>
    function showPasswordValidation() {
        var passwordWrapper = document.getElementById('passwordWrapper');
        passwordWrapper.style.display = 'block';
    }
</script>
    
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>