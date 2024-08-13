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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="css/history.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="shortcut icon" href="gentle paws logo.png" type="image/x-icon">
    <title>History | Gentle Paws</title>
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
        
        <li class="history-active">
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
<div class="container-fluid w-75 mt-1">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-black text-white">
                    <div class="row">
                        <div class="col-md-5">
                            <h4 class="fw-bold pt-3">History</h4>
                        </div>
                        <div class="col-md-7 d-flex justify-content-end align-items-center pe-5">
                            <div class="row">
                                <div class="col-md-8">
                                    <select name="status" id="status" class="form-select">
                                        <option value="">Select Status</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Approved">Approved</option>
                                        <option value="Decline">Decline</option>
                                        <option value="Completed">Completed</option>
                                        <option value="Failed">Failed</option>
                                        
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <a href="history.php" class="btn btn-danger">Reset</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myTable" class="table-bordered table-striped">
                            <thead>
                                <tr>
                                    <!-- <th class="px-5">ID</th> -->
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
                                    $query = "SELECT * FROM bookings INNER JOIN users ON bookings.email=users.email WHERE users.id=$id AND status IN ('Pending', 'Approved', 'Decline', 'Completed', 'Failed', 'Cancelled')";
                                    $query_run = mysqli_query($conn, $query);

                                    if(mysqli_num_rows($query_run) > 0){
                                        foreach($query_run as $bookings){
                                ?>
                                    <tr>
                                        <!-- <td class="px-1 text-center"><?=$bookings['id'];?></td> -->
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

  $(document).ready( function() {
        $('.sub-btn').click( function() {
        $(this).next('.sub-menu').slideToggle();
        $(this).find('.dropdown').toggleClass('rotate');
        });
    });
</script>
<script>
    $(document).ready( function () {
        $('#status').on('change', function(){
            var value = $(this).val();

            $.ajax({
                url: "fetch.php",
                type: "POST",
                data: 'request=' + value,  //The request being sent to the server.
                success: function (data) {
                    $(".card-body").html(data);   //Setting the output from the server as the content of the element with id container.
                }
            });
        });
    });
</script>
</body>
</html>