<?php 
session_start();
include('../conn.php');
$id = $_SESSION['user_id'];

if(!isset($_SESSION['user_id'])){
    header('Location: login1.php');
}else{
        $sql = "SELECT * FROM users WHERE id='$id'";
		$query = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($query);
}

// $email = $_SESSION['email'];

// if(isset($_SESSION['email'])) {
//         $sql = "SELECT * FROM users WHERE email='$email'";
// 		$query = mysqli_query($conn, $sql);
// 		$row = mysqli_fetch_array($query);
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="shortcut icon" href="gentle paws logo.png" type="image/x-icon">
    <title>User Dashboard | Gentle Paws</title>
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
<!--End of sidebar-->

<!--Main Content-->
<div class="container-fluid w-100">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-body mt-2">
                <h4>Hi, <?php echo $row['fname'];?>!</h4>
                <h1 class="fw-bold">Welcome Back!</h1>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card my-3">
                <h4 class="px-3 pt-3 fw-bold">My Upcoming Appointments</h4>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-white table-bordered">
                            <thead>
                                
                                <tr>
                                    <th class="px-5 text-center">Pet Name</th>
                                    <th class="px-5 text-center">Date</th>
                                    <th class="px-5 text-center">Time</th>
                                    <th class="px-5 text-center">Reason</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    // Query to get all the appointments for a specific user from the database
                                    $query = "SELECT petname, date, timeslot, reason FROM bookings INNER JOIN users ON bookings.email=users.email WHERE users.id=$id AND status='Approved'";
                                    $query_run = mysqli_query($conn, $query);

                                    if(mysqli_num_rows( $query_run ) > 0) {
                                        foreach($query_run as $fetch){
                                ?>
                                <tr>
                                    <td class="px-1 text-center"><?=$fetch['petname']; ?></td>
                                    <td class="px-1 text-center"><?=date('M d, Y', strtotime($fetch['date'])); ?></td>
                                    <td class="px-1 text-center"><?=$fetch['timeslot']; ?></td>
                                    <td class="px-1 text-center"><?=$fetch['reason']; ?></td>
                                </tr>
                                <?php  
                                        }//end of loop
                                    } else {
                                        // echo "No Upcoming Appointment.";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
  $(document).ready( function () {
    $('#myTable').DataTable();
  });

  $(document).ready( function() {
        $('.sub-btn').click( function() {
        $(this).next('.sub-menu').slideToggle();
        $(this).find('.dropdown').toggleClass('rotate');
        });
    });
</script>
</body>
</html>