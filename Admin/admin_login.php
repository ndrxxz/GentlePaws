<?php 
session_start();
include('../conn.php');

$email = $password = "";
$emailA = "admin";
$passA = "admin123";
$emailErr = $passwordErr = "";

if(isset($_POST['submit'])){
    $email = mysqli_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));

    if(empty($_POST['email'])){
        $emailErr = "Email is required";
    }

    if(empty($_POST['password'])){
        $passwordErr = "Password is required.";
    }

    if($email == $emailA && $password == $passA){
        header("Location: admin_dashboard.php");
    } else {
        $_SESSION['error'] = "Invalid Email or Password";
        header("Location: admin_dashboard.php");
        exit(0);
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/admin_login.css">
    <link rel="shortcut icon" href="gentle paws logo.png" type="image/x-icon">
    <title>Admin Login</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center inner-row">
            <div class="col-md-6">
                <div class="form-box p-5">
                    <div class="form-title">
                        <h1 class="fw-bold mb-3 text-center">Admin Login</h1>
                    </div>
                    <?php
                        if(isset($_SESSION['error'])){
                    ?>
                        <div class="alert alert-danger">
                            <h6><?= $_SESSION['error']; ?></h6>
                        </div>
                    <?php
                        unset($_SESSION['error']);
                        }
                    ?>
                    <form action="admin_login.php" method="POST">
                        <div class="form-group mb-4 ">
                            <input type="text" class="form-control py-3" name="email" id="floatingInput" placeholder="Email">
                            <p id="error"><?php echo $emailErr; ?></p>
                        </div>
                        <div class="form-group mb-4">
                            <input type="password" class="form-control py-3" name="password" id="floatingInput" placeholder="Password">
                            <p id="error"><?php echo $passwordErr; ?></p>
                        </div>
                        <div class="mt-3">
                            <button type="submit" name="submit" class="btn btn-primary text-white w-100">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>