<?php
session_start();
include('../conn.php');

if(isset($_POST['submit'])){
    $services = mysqli_real_escape_string($conn, $_POST['services']);

    $query = "INSERT INTO services (name) VALUES ('$services')";
    $query_run = mysqli_query($conn , $query);

    if(!$query_run){
        $_SESSION['error'] = "Failed";
        header("Location: admin_services.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Adding Service Successful";
        header("Location: admin_services.php");
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="css/services.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="shortcut icon" href="gentle paws logo.png" type="image/x-icon">
    <title>Services</title>
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
                    <h4 class="fw-bold pt-3">Services
                    <button type="button" class="btn btn-primary float-end book" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Service</button>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myTable" class="table-bordered table-striped w-100">
                            <thead>
                                <tr>
                                    <th class="px-5 py-1 text-center">ID</th>
                                    <th class="px-5 py-1 text-center">Service Name</th>
                                    <th class="px-5 py-1 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $query = "SELECT * FROM services";
                                    $query_run = mysqli_query($conn, $query);

                                    if(mysqli_num_rows($query_run ) > 0) {
                                        foreach($query_run as $services){
                                ?>
                                <tr>
                                    <td class="px-1 text-center"><?= $services['id']; ?></td>
                                    <td class="px-1 text-center"><?= $services['name']; ?></td>
                                    <td class="px-3 py-2">
                                        <button type="button" class="btn btn-success btn-sm edit"><span><i class="bi bi-pencil-square"></i></span></button>
                                        <a href="services-delete.php?id=<?= $services['id']; ?>" class="btn btn-danger btn-sm del"><span><i class="bi bi-trash3-fill"></i></span></a>
                                    </td>
                                </tr>
                                <?php
                                        }
                                    } else {

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

<!-- Adding Data -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Service</span></h4>
                <button type="button" class="close btn btn-danger" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="" method="POST">
                            <div class="form-group mb-3">
                                <label for="">Service Name</label>
                                <input type="text" name="services" class="form-control" required>
                            </div>

                            <div class="form-group float-end">
                                <button class="class btn btn-primary" type="submit" name="submit">Submit</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Adding Data -->

<!-- Editing Data -->
<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Service</span></h4>
                <button type="button" class="close btn btn-danger" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="services-edit.php" method="POST">
                            <input type="hidden" name="update_id" id="update_id">

                            <div class="form-group mb-3">
                                <label for="">Service Name</label>
                                <input type="text" name="services" id="name" class="form-control" required>
                            </div>

                            <div class="form-group float-end">
                                <button class="class btn btn-primary" type="submit" name="update">Update</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Editing Data -->

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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

    $(".book").click(function(){
        $("#myModal").modal("show");
    });

    $(document).ready(function(){
        $('.edit').on('click', function() {
            $('#editModal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children('td').map(function() {
                return $(this).text();
            }).get();

            console.log(data);

            $('#update_id').val(data[0]);
            $('#name').val(data[1]);
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>