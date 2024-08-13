<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/admin_create.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="shortcut icon" href="gentle paws logo.png" type="image/x-icon">
    <title>Admin Create</title>
</head>
<body>
<div class="sidebar">
    <div class="logo">Gentle Paws</div>
    <ul class="menu">
        <li class="active">
            <a href="admin_dashboard.php" >
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="user_active">
            <a href="admin_registered_profile.php" class="sub-btn">
                <i class="fas fa-user"></i>
                <span>Users</span>
                <!-- <i class="fas fa-angle-right dropdown"></i> -->
            </a>
        
        <!-- <div class="sub-menu">
            <a href="#">
                <i class="fa-solid fa-person"></i>
            <span>Owner</span>
            </a>
            <a href="#">
                <i class="fa-solid fa-dog"></i>
                <span>Pet</span>
            </a>
        </div> -->

        <li class="appointment_active">
            <a href="#" class="sub-btn">
                <i class="fa-solid fa-calendar-days"></i>
                <span>Appointments</span>
                <i class="fas fa-angle-right dropdown"></i>
            </a>
        
        <div class="sub-menu">
            <a href="pending-appointment.php">
                <span>Pending</span>
            </a>
            <a href="approved_appointment.php">
                <span>Approved</span>
            </a>
            <a href="decline_appointment.php">
                <span>Decline</span>
            </a>
            <a href="completed_appointment.php">
                <span>Completed</span>
            </a>
            <a href="failed_appointment.php">
                <span>Failed</span>
            </a>
        </div>
            
        <li class="logout">
            <a href="../User/logout.php">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</div>
<!-- End Sidebar -->
<div class="container-fluid w-75 mt-3">
    <?php 
        include('message.php');
        include('error.php');
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-black text-white">
                    <h4 class="fw-bold pt-3">Add User
                    <a href="admin_registered_profile.php" class="btn btn-danger float-end">Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="admin_code.php" method="POST">
                        <div class="mb-3">
                            <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="contact" class="form-control" placeholder="Contact Number" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" name="pass" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" name="cpass" class="form-control" placeholder="Confirm Password" required>
                        </div>
                        <div class="mb-3">
                            <button type="submit" name="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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