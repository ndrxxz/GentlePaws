<?php 
session_start();
include('../conn.php'); // include your database connection here

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="css/admin_profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="shortcut icon" href="gentle paws logo.png" type="image/x-icon">
    <title>Registered Profile</title>
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
<!-- End Sidebar -->

<div class="container-fluid w-75 mt-1 mx-3">
    <?php 
        include('message.php');
        include('error.php');
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-black text-white">
                    <h4 class="fw-bold pt-3">Registered Users
                        <a href="admin_create.php" class="btn btn-primary float-end">Add User</a>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myTable" class="table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="px-5">ID</th>
                                    <th class="px-5">First Name</th>
                                    <th class="px-5">Last Name</th>
                                    <th class="px-5 text-center">Email</th>
                                    <th class="px-5">Contact Number</th>
                                    <th class="px-5 text-center">Created At</th>
                                    <th class="px-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    // to fetch the data from the database
                                    $query = "SELECT * FROM users WHERE verify_status = 1";
                                    $query_run = mysqli_query($conn, $query);

                                    if(mysqli_num_rows($query_run) > 0){
                                        foreach($query_run as $users){
                                ?>
                                    <tr>
                                        <td class="px-1 text-center"><?=$users['id']; ?></td>
                                        <td class="px-1 text-center"><?=$users['fname']; ?></td>
                                        <td class="px-1 text-center"><?=$users['lname']; ?></td>
                                        <td class="px-1 text-center"><?=$users['email']; ?></td>
                                        <td class="px-1 text-center"><?=$users['contact']; ?></td>
                                        <td class="px-1 text-center"><?=$users['created_at']; ?></td>
                                        <td class="px-3 py-2">
                                            <a href="user-edit.php?id=<?= $users['id']; ?>" class="btn btn-success btn-sm"><span><i class="bi bi-pencil-square"></i></span></a>
                                            <a href="user-delete.php?id=<?= $users['id']; ?>" class="btn btn-danger btn-sm del"><span><i class="bi bi-trash3-fill"></i></span></a>
                                        </td>
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

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    $(document).ready(function(){
        $('.del').on('click', function(e) {
            e.preventDefault();
            const href = $(this).attr('href')

            Swal.fire({
                title : 'Are you sure?',
                text : 'This record will be deleted permanently!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if(result.value){
                    document.location.href = href;
                }
            })

        });
    });
</script>
</body>
</html>