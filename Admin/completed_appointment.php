<?php 
include ('../conn.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="css/admin_appointment.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="shortcut icon" href="gentle paws logo.png" type="image/x-icon">
    <title>Completed Appointments</title>
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
                    
                </a>
    
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

            <li class="close_active">
                <a href="close.php">
                    <i class="fa-solid fa-lock"></i>
                    <span>Close</span>
                </a>
            </li>

            <li class="services_active">
                <a href="admin_services.php">
                    <i class="fa-solid fa-paw"></i>
                    <span>Services</span>
                </a>
            </li>
                
            <li class="logout">
                <a href="../User/logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>
<!--End of Sidebar-->
<!-------------------------------Content------------------------->
<div class="container-fluid w-75 mt-1">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-black text-white">
                    <h4 class="fw-bold pt-3">Completed Appointments</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myTable" class="table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="px-5">ID</th>
                                    <th class="px-5">First Name</th>
                                    <th class="px-5">Last Name</th>
                                    <th class="px-5">Contact Number</th>
                                    <th class="px-5 text-center">Email</th>
                                    <th class="px-5">Date</th>
                                    <th class="px-5">Time</th>
                                    <th class="px-5">Pet's Name</th>
                                    <th class="px-5">Pet Type</th>
                                    <th class="px-5">Age</th>
                                    <th class="px-5">Breed</th>
                                    <th class="px-5">Reason</th>
                                    <th class="px-5">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $query = "SELECT * FROM bookings WHERE status='Completed'";
                                    $query_run = mysqli_query($conn, $query);

                                    if(mysqli_num_rows($query_run) > 0){
                                        foreach($query_run as $bookings){
                                ?>
                                    <tr>
                                        <td class="px-1 text-center"><?=$bookings['id'];?></td>
                                        <td class="px-1 text-center"><?=$bookings['fname'];?></td>
                                        <td class="px-1 text-center"><?=$bookings['lname'];?></td>
                                        <td class="px-1 text-center"><?=$bookings['contact'];?></td>
                                        <td class="px-1 text-center"><?=$bookings['email'];?></td>
                                        <td class="px-1 text-center"><?=date('M d, Y', strtotime($bookings['date']));?></td>
                                        <td class="px-1 text-center"><?=$bookings['timeslot'];?></td>
                                        <td class="px-1 text-center"><?=$bookings['petname'];?></td>
                                        <td class="px-1 text-center"><?=$bookings['type'];?></td>
                                        <td class="px-1 text-center"><?=$bookings['age'];?></td>
                                        <td class="px-1 text-center"><?=$bookings['breed'];?></td>
                                        <td class="px-1 text-center"><?=$bookings['reason'];?></td>
                                        <td class="px-1 text-center"><?=$bookings['status'];?></td>
                                    </tr>
                                <?php 
                                        }
                                    } else {
                                        // echo "<h5>No Record Found!</h5>";
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