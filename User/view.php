<?php 
include('../conn.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/schedule.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>View | Gentle Paws</title>
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

        <li class="sched-active">
            <a href="dashboard-test.php">
                <i class="fa-solid fa-calendar-days"></i>
                <span>Scheduling</span>
            </a>
        </li>

        <li>
            <a href="#" class="sub-btn">
                <i class="fa-solid fa-calendar-days"></i>
                <span>History</span>
                <i class="fas fa-angle-right dropdown"></i>
            </a>
        
        <div class="sub-menu">
            <a href="pending-appointment.php">
                <span>Pending</span>
            </a>
            <a href="approved-appointment.php">
                <span>Approved</span>
            </a>
            <a href="decline-appointment.php">
                <span>Decline</span>
            </a>
            <a href="completed-appointment.php">
                <span>Completed</span>
            </a>
            <a href="failed-appointment.php">
                <span>Failed</span>
            </a>
        </div>
            
        <li class="logout">
            <a href="logout.php">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</div>
<div class="container-fluid w-75 mt-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-black text-white">
                    <h4 class="fw-bold pt-3">Appointment Details
                        <a href="pending-appointment.php" class="btn btn-danger float-end">Back</a>
                    </h4>
                </div>
                <?php 
                    $id = mysqli_real_escape_string($conn, $_GET['id']);

                    $select = mysqli_query($conn, "SELECT * FROM appointment INNER JOIN users ON appointment.email=users.email WHERE users.id=$id AND status='Pending'") or die('query failed');
                    
                    if (mysqli_num_rows($select) > 0){
                        $fetch = mysqli_fetch_assoc($select);
                    }
                ?>
                <div class="card-body">
                    <div class="mb-3">
                        <input type="text" id="name" name="name" class="form-control" placeholder="Name" value="<?php echo $fetch['name'] ?>" required readonly>
                    </div>
                    <div class="mb-3">
                        <input type="text" id="contact" name="contact" class="form-control" placeholder="Contact Number" value="<?php echo $fetch['contact'] ?>" required readonly>
                    </div>
                    <div class="mb-3">
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="<?php echo $fetch['email'] ?>" required readonly>
                    </div>
                    <div class="mb-3">
                        <input type="text" id="date" name="date" class="form-control" placeholder="Date" value="<?php echo $fetch['date'] ?>" required readonly>
                    </div>
                    <div class="mb-3">
                        <input type="text" id="time" name="time" class="form-control" placeholder="Time" value="<?php echo $fetch['time'] ?>" required readonly>
                    </div>
                    <div class="mb-3">
                        <input type="text" id="petname" name="petname" class="form-control" placeholder="Pet Name" value="<?php echo $fetch['petname'] ?>" required readonly>
                    </div>
                    <div class="mb-3">
                        <input type="text" id="pet" name="pet" class="form-control" placeholder="Ex. Dog" value="<?php echo $fetch['type'] ?>" required readonly>
                    </div>
                    <div class="mb-3">
                        <input type="text" id="age" name="age" class="form-control" placeholder="Age" value="<?php echo $fetch['age'] ?>" required readonly>
                    </div>
                    <div class="mb-3">
                        <input type="text" id="breed" name="breed" class="form-control" placeholder="Breed" value="<?php echo $fetch['breed'] ?>" required readonly>
                    </div>
                    <div class="mb-3">
                        <input type="text" id="status" name="status" class="form-control" placeholder="Status" value="<?php echo $fetch['status'] ?>" required readonly>
                    </div>
                    <div class="mb-3">
                        <input type="text" id="reason" name="reason" class="form-control" required value="<?php echo $fetch['reason'] ?> " readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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