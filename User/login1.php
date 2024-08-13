<?php 
session_start();
// make a database and name it as gentlepaws
// after that make a table and name it as users
// the screenshot of the table structure is in the Gdrive

include('../conn.php');

$email = $password = "";
$emailErr = $passwordErr = "";

if(isset($_POST['submit'])){
    $email = mysqli_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));

    if(empty($_POST['email'])){
        $emailErr = "Email is required";
    } else {
        // check if email has valid email format/address
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid Email Format";
        }
    }
    if(empty($_POST['password'])){
        $passwordErr = "Password is required.";
    }

    if($emailErr == "" && $passwordErr == ""){

        //check if user exists in the database with given credentials
        $sql = "SELECT * FROM users WHERE email='$email' AND pass='$password' LIMIT 1";
        $result = mysqli_query($conn,$sql);
        
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);
            // echo $row['verify_status'];

            if($row['verify_status'] == 1){
                $_SESSION['user_id'] = $row['id'];
                header("Location: user_dashboard.php");
            } else {
                $_SESSION['error'] = "Please verify your email address";
                header("Location: login1.php");
                exit(0);
            }
        } else {
                $_SESSION['error'] = "Invalid Email or Password";
                header("Location: login1.php");
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
    <link rel="stylesheet" href="css/login1.css">
    <link rel="shortcut icon" href="gentle paws logo.png" type="image/x-icon">
    <title>Login | Gentle Paws</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center inner-row">
            <div class="col-md-6">
                <div class="form-box p-5">
                    <div class="form-title">
                        <h1 class="fw-bold mb-3 text-center">Login</h1>
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
                    <form action="login1.php" method="POST">
                        <div class="form-group mb-4 ">
                            <input type="text" class="form-control py-3" name="email" id="floatingInput" placeholder="Email">
                            <!--<label for="floatingInput">Email</label>-->
                            <p id="error"><?php echo $emailErr; ?></p>
                        </div>
                        <div class="form-group mb-4">
                            <input type="password" class="form-control py-3" name="password" id="floatingInput" placeholder="Password">
                            <!--<label for="floatingPassword">Password</label>-->
                            <p id="error"><?php echo $passwordErr; ?></p>
                        </div>
                        <div class="mt-3 p-1">
                           <a href="reset.php" class="pb-3 border-0 bg-transparent primaryColor float-end">Forgot Password?</a>
                        </div>
                        <div class="mt-3">
                            <button type="submit" name="submit" class="btn btn-primary text-white w-100">Login</button>
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