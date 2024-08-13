<?php 
session_start();
include('../conn.php');
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('Location: login1.php');
}

if(isset($_POST['update_profile'])){
    $update_fname = mysqli_real_escape_string($conn, $_POST['firstName']);
    $update_lname = mysqli_real_escape_string($conn, $_POST['lastName']);
    $update_email = mysqli_real_escape_string($conn, $_POST['email']);
    $update_contact = mysqli_real_escape_string($conn, $_POST['contact']);

    // Contact number validation
    if(!preg_match('/^(09|\+639)\d{9}$/', $update_contact)) {
        $_SESSION['warning'] = "Contact number must start with '09' or '+63' and be 11 digits long.";
        header("Location: user_profile.php");
        exit(0);
    }

    mysqli_query($conn, "UPDATE users SET fname = '$update_fname', lname = '$update_lname', email = '$update_email', 
    contact = '$update_contact' WHERE id = '$user_id'") or die('query failed');
    
    $_SESSION['success'] = "Updated Successfully!";
    
    
    $new_password = mysqli_real_escape_string($conn, $_POST['pass']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['cpass']);

    if (!empty($new_password) && !empty($confirm_password)) {
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$/', $new_password)) {
            $_SESSION['warning'] = "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
            header("Location: user_profile.php");
            exit(0);
        }
        if ($new_password != $confirm_password) {
            $_SESSION['warning'] = "Passwords do not match.";
            header("Location: user_profile.php");
            exit(0);
        }

        mysqli_query($conn, "UPDATE users SET pass = '$confirm_password' WHERE id = '$user_id'") or die('query failed');
        $_SESSION['success'] = "Password updated successfully.";
        header("Location: user_profile.php");
        exit(0);
    }
    
    $update_image = $_FILES['update_image']['name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    //$error = $_FILES['profile']['error'];
    $update_image_folder = '../User/uploaded_img/'.$update_image;

    if(!empty($update_image)){
        if($update_image_size > 2000000){
            // echo "<script>alert('The file is too large!')</script>";
            $_SESSION['warning'] = "The file is too large!";
            header("Location: user_profile.php");
            exit(0);
        } 

        $allowed_types = array('image/jpeg', 'image/png', 'image/jpg');
        $file_type = mime_content_type($update_image_tmp_name);

        if(!in_array($file_type, $allowed_types)) {
            $_SESSION['warning'] = "Only JPEG, PNG, and JPG files are allowed.";
            header("Location: user_profile.php");
            exit();
        } else {
            $sql = mysqli_query($conn, "UPDATE users SET image = '$update_image' WHERE id = '$user_id'") or die('query failed');
            if($sql){
                move_uploaded_file($update_image_tmp_name, $update_image_folder);
            }
            // echo '<script> alert("Image Updated Successfully!") </script>';
            $_SESSION['success'] = "Image Updated Successfully!";
            header("Location: user_profile.php");
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
    <link rel="stylesheet" href="css/user_profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="shortcut icon" href="gentle paws logo.png" type="image/x-icon">
    <title>User Profile | Gentle Paws</title>
</head>
<body>
<div class="sidebar">
    <div class="logo">Gentle Paws</div>
    <ul class="menu">
        <li class="active">
        <a href="user_dashboard.php" >
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        </li>
        <li class="user_active">
        <a href="user_profile.php" class="sub-btn">
            <i class="fas fa-user"></i>
            <span>Profile</span>
            <!-- <i class="fas fa-angle-right dropdown"></i> -->
        </a>

        <li>
            <a href="calendar.php">
                <i class="fa-solid fa-calendar-days"></i>
                <span>Scheduling</span>
            </a>
        </li>
        
        <li>
            <a href="history.php" class="sub-btn">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span>History</span>
            </a>

        </li>

        <li class="logout">
            <a href="logout.php">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</div>
<div class="container">  
    <div class="profile-picture">
        <?php
        $select = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'") or die('query failed');
        if (mysqli_num_rows($select) > 0){
            $fetch = mysqli_fetch_assoc($select);
        }

        if($fetch['image'] == ''){
            echo '<img src="../img/blank.png" class="js-image">';
        } else {
            echo '<img src="../User/uploaded_img/'.$fetch['image'].'" class="js-image">';
        }
        
        ?>
    </div>
    <?php
        include('success.php');
        include('warning.php');
    ?>
    <div class="user-form">
        <h2 class="fw-bold">Edit Profile</h2>
        <form action="user_profile.php" method="POST" enctype="multipart/form-data">
             <!--Your form fields go here--> 
            <input type="text" id="firstName" name="firstName" value="<?php echo $fetch['fname'] ?>" placeholder="First Name">

            <input type="text" id="lastName" name="lastName" value="<?php echo $fetch['lname'] ?>" placeholder="Last Name">

            <input type="email" id="email" name="email" value="<?php echo $fetch['email'] ?>" placeholder="Email">

            <input type="text" id="contact" name="contact" value="<?php echo $fetch['contact'] ?>" placeholder="Contact Number">

            <input type="password" name="pass" id="" placeholder="New Password">

            <input type="password" name="cpass" id="" placeholder="Confirm Password">

            <input onchange="display_image(this.files[0])" type="file" name="update_image" accept="image/jpg, image/png, image/jpg">

            <button type="submit" name="update_profile">Save Changes</button>
        </form>
    </div>
</div>


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    console.log(URL);
    function display_image(file){
        let img = document.querySelector(".js-image");
        img.src = URL.createObjectURL(file);
    }
</script>

<script>
    $(document).ready( function() {
        $('.sub-btn').click( function() {
        $(this).next('.sub-menu').slideToggle();
        $(this).find('.dropdown').toggleClass('rotate');
        });
    });
</script>
</body>
</html>




