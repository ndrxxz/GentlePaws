<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/login1.css">
    <link rel="shortcut icon" href="gentle paws logo.png" type="image/x-icon">
    <title>Forgot Password</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center inner-row">
            <div class="col-md-6">
                <div class="form-box p-5">
                    <div class="form-title">
                        <h1 class="fw-bold mb-3 text-center">Forgot Password</h1>
                    </div>
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
                    <div class="mb-4">
                        <span>Enter the email address you used and we'll send you instructions to reset your password. </span>
                    </div>
                    <form action="reset-code.php" method="POST">
                        <div class="form-group mb-4">
                            <input type="text" class="form-control py-3" name="email" id="floatingInput" placeholder="Email">
                        </div>
                        <div class="mt-3">
                            <button type="submit" name="submit" class="btn btn-primary text-white w-100">Reset Password</button>
                        </div>
                        <div class="mt-3">
                            <span>Don't have an account? </span><a href="register.php" class="p-0 border-0 bg-transparent primaryColor">Sign Up</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>