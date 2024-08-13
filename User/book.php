<?php
session_start();
// include('conn.php');

$user_id = $_SESSION['user_id'];

$mysqli = new mysqli('localhost', 'root', '', 'gentlepaws');
$bookings = array();
if(isset($_GET['date'])){
    $date = $_GET['date'];
    $stmt = $mysqli->prepare('SELECT * FROM bookings where date = ?');
    $stmt -> bind_param('s', $date);
    
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            while($row = $result -> fetch_assoc()){
                $bookings[] = $row['timeslot'];
            }

            $stmt -> close();
        }
    }
}

if(isset($_POST["submit"])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    // $date = mysqli_real_escape_string($conn, $_POST['date']);
    $timeslot = $_POST['timeslot'];
    $petname = $_POST['petname'];
    $type = $_POST['type'];
    $age = $_POST['age'];
    $breed = $_POST['breed'];
    $status = $_POST['status'];
    $reason = $_POST['reason'];

    $stmt = $mysqli->prepare('SELECT * FROM bookings where date = ? AND timeslot = ?');
    $stmt -> bind_param('ss', $date, $timeslot);
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            $msg = "<div class='alert alert-danger'Already Booked</div>";
        } else {
            $stmt = $mysqli -> prepare('INSERT INTO bookings (fname, lname, contact, email, date, timeslot, petname, type, age, breed, status, reason) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt -> bind_param('ssssssssssss', $fname, $lname, $contact, $email, $date, $timeslot, $petname, $type, $age, $breed, $status, $reason);
            $stmt -> execute();
            $msg = "<div class='alert alert-success'>Booking Successful</div>";
            $bookings[] = $timeslot;
            $stmt -> close();
            $mysqli -> close();
        }
    }

    

}


$duration = 30;
$cleanup = 0;
$start = "09:00";
$end = "17:00";

function timeslots($duration, $cleanup, $start, $end){
    $start = new DateTime($start);
    $end = new DateTime($end);
    $interval = new DateInterval("PT".$duration."M");
    $cleanupInterval = new DateInterval("PT".$cleanup."M");
    $slots = array();

    for($intStart = $start; $intStart < $end; $intStart->add($interval)->add($cleanupInterval)){
        $endPeriod = clone $intStart;
        $endPeriod -> add($interval);

        if($endPeriod > $end){
            break;
        }

        $slots[] = $intStart -> format("h:iA")."-". $endPeriod -> format("h:iA");
    }

    return $slots;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/book.css">
    <link rel="shortcut icon" href="gentle paws logo.png" type="image/x-icon">
    <title>Appointment Form</title>
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
<div class="container-fluid w-75 mt-3 px-5 bg-white">
    <div class="row justify-content-center text-align-center mt-4">
        <h1 class="text-center mb-5">Book for Date: <?php echo date('F d, Y', strtotime($date)); ?></h1>
            <div class="col-md-12">
                <?php echo (isset($msg)) ? $msg : ""; ?>
            </div>
            <?php $timeslots = timeslots($duration, $cleanup, $start, $end); 
                foreach($timeslots as $ts){
            ?>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <?php if(in_array($ts, $bookings)){ ?>
                            <button class="btn btn-danger w-100"><?php echo $ts; ?></button>
                        <?php } else { ?>
                            <button class="btn btn-success book w-100" data-timeslot="<?php echo $ts; ?>"><?php echo $ts; ?></button>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        <div class="row justify-content-center text-align-center mt-5">
            <div class="col-md-6">
                <button class="btn btn-success ms-4"></button><span> Available</span> <span><button class="btn btn-danger ms-5"></button> Not Available</span>
            </div>
        </div>
    </div>
</div>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Booking: <span id="slot"></span></h4>
                <button type="button" class="close btn btn-danger" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="" method="POST" id="myForm">
                            <div class="form-group mb-3">
                                <label for="timeslot">Timeslot</label>
                                <input type="text" name="timeslot" id="timeslot" class="form-control" readonly>
                            </div>

                            <?php
                            $query = "SELECT * FROM users WHERE id = ?";
                            $stmt = $mysqli->prepare($query);
                            
                            if ($stmt === false) {
                                die('Error preparing query: ' . $mysqli->error);
                            }
                            
                            $stmt->bind_param('i', $user_id);
                            $stmt->execute();
                            
                            if ($stmt->error) {
                                die('Error executing query: ' . $stmt->error);
                            }
                            
                            $result = $stmt->get_result();
                            
                            if ($result === false) {
                                die('Error getting result: ' . $mysqli->error);
                            }

                            if ($result->num_rows > 0) {
                                $users = $result->fetch_assoc();
                                ?>
                                <div class="form-group mb-3">
                                    <label for="firstname">First Name</label>
                                    <input type="text" id="firstname" name="fname" class="form-control" value="<?php echo $users['fname']; ?>" required readonly>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="lastname">Last Name</label>
                                    <input type="text" id="lastname" name="lname" class="form-control" value="<?php echo $users['lname']; ?>" required readonly>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="contact">Contact</label>
                                    <input type="text" id="contact" name="contact" class="form-control" value="<?php echo $users['contact']; ?>" required readonly>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="email">Email</label>
                                    <input type="text" id="email" name="email" class="form-control" value="<?php echo $users['email']; ?>" required readonly>
                                </div>
                                <?php
                            } else {
                                echo 'No Data Found for user ID ' . $user_id;
                            }
                            $stmt->close();
                            ?>

                            <div class="form-group mb-3">
                                <label for="petname">Pet Name</label>
                                <input type="text" id="petname" name="petname" class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="type">Type</label>
                                <input type="text" id="type" name="type" class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="age">Age</label>
                                <input type="text" id="age" name="age" class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="breed">Breed</label>
                                <input type="text" id="breed" name="breed" class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="reason">Reason</label><br>
                                <select name="reason" id="services" class="w-100 py-1">
                                    
                                    <?php
                                    $query = "SELECT * FROM services";
                                    $query_run = $mysqli->query($query);

                                    if ($query_run->num_rows > 0) {
                                        while ($services = $query_run->fetch_assoc()) {
                                            echo '<option value="' . $services['name'] . '">' . $services['name'] . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">No Services Available</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="status">Status</label>
                                <input type="text" id="status" name="status" value="Pending" class="form-control" readonly>
                            </div>

                            <div class="form-group float-end">
                                <button class="class btn btn-primary submit" type="submit" name="submit">Submit</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- <script src="https://code.jquery.com/jquery-3.7.0.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(".book").click(function(){
        let timeslot = $(this).attr('data-timeslot');
        $("#slot").html(timeslot);
        $("#timeslot").val(timeslot);
        // $("#services").val(services);
        $("#myModal").modal("show");
    });

    $(document).ready( function() {
        $('.sub-btn').click( function() {
        $(this).next('.sub-menu').slideToggle();
        $(this).find('.dropdown').toggleClass('rotate');
        });
    });
</script>

<script>
  $(document).ready(function() {
    $('#myModal').on('shown.bs.modal', function () {
      $('#myForm').submit(function(e) {
        e.preventDefault(); // Prevent default form submission

        // Display SweetAlert confirmation
        Swal.fire({
          title: 'Are you sure?',
          text: 'Once you submit this appointment you cannot cancel it',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes'
        }).then((result) => {
          if (result.isConfirmed) {
            // If user confirms, submit the form
            $(this).unbind('submit').submit();
          }
        });
      });
    });
  });
</script>
</body>
</html>