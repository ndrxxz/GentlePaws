<?php 

// make a database and name it as gentlepaws
// after that make a table and name it as signup

include('../conn.php');

$email = $username = $password = $repeat_password = "";
$emailErr = $usernameErr = $passwordErr = $RpasswordsErr = "";

if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $username = $_POST['name'];
    $password = $_POST['password'];
    $repeat_password = $_POST['Rpassword'];

    if(empty($_POST['email'])){
        $emailErr = "Email is required";
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $emailErr = "email must be a valid email address";
        } else {
            $sql = "SELECT * FROM signup WHERE email = '$email'";
            $result = mysqli_query($conn,$sql);
            $row = mysqli_fetch_array($result);
            if(!empty($row)){
                $emailErr = "This Email already exists.";
            }
        }
    }

    // check username
    if(empty($_POST['name'])){
        $usernameErr = "Username is required.";
    }

    //check password
    if(empty($_POST['password'])){
        $passwordErr = "Password is required.";
    } else {
        if(strlen($password)<8){
            $passwordErr = "Password must contain at least 8 characters.";
        }
    }

    //check repeat password
    if ($password !== $repeat_password){
        $RpasswordsErr = "Password did not match.";
    }

    if($emailErr == "" and $usernameErr=="" and $passwordErr=="" and $RpasswordsErr==""){

        $sql2 = "INSERT INTO signup (email, username, pass) VALUES ('$email', '$username', '$repeat_password')";

        if(mysqli_query($conn, $sql2)){
            echo "<script type='text/javascript'> alert('Registered Successfully!') </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/signup.css">
    <link rel="shortcut icon" href="/img/Gentle_Paws__1_-removebg-preview.png" type="image/x-icon">
</head>
<body>
    <div class="form">
        <h2>Sign Up</h2>
        <form action="signup.php" method="POST">
            <p class="error"><?php echo $emailErr; ?></p>
            <input type="text" name="email" id="" placeholder="Email">
            
            <p class="error"><?php echo $usernameErr; ?></p>
            <input type="text" name="name" id="" placeholder="Full Name">
            
            <p class="error"><?php echo $passwordErr; ?></p>
            <input type="password" name="password" id="" placeholder="Password">
            
            <p class="error"><?php echo $RpasswordsErr; ?></p>
            <input type="password" name="Rpassword" id="" placeholder="Confirm Password">

            <input type="submit" name="submit" value="Sign Up" class="button">
        </form>
        <div class="login">
            Already have an account? <a href="login.php">Login Here</a>
        </div>
    </div>
</body>
</html>