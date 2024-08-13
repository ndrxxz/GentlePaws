<?php 
include('../conn.php');

// // Query to fetch counts for each status
// $sql = "SELECT status, COUNT(*) AS count FROM appointment GROUP BY status";
// $result = $conn->query($sql);

// $data = array();
// while($row = $result->fetch_assoc()) {
//     $data[$row['status']] = $row['count'];
// }

// // Convert data to JSON format
// echo json_encode($data);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="css/admin_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="shortcut icon" href="gentle paws logo.png" type="image/x-icon">
    <title>Admin Dashboard</title>
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
            <a href="admin_login.php">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</div>
<!-- End Sidebar -->

<div class="container-fluid w-75">
    <!-- <div class="row">
        <div class="col-md-12 mt-2">
            <div class="card card-body">
                <h4 class="fw-bold">Dashboard</h4>
            </div>
        </div>
    </div> -->
    <div class="row">
        <div class="col-md-4 mb-3 mt-3">
            <div class="card card-body p-3 border-dark border-top-0 border-end-0 border-bottom-0 border-4">
                <p class="text-sm mb-0 text-capitalize fw-bold">Total Users</p>
                <!-- <i class="bi bi-people-fill text-end h1"></i> -->
                <h5 class="fw-bolder mb-0">
                    <?php 
                        $query = "SELECT * FROM users";
                        $result = mysqli_query($conn, $query);
                        $totalCount = mysqli_num_rows($result);
                        echo $totalCount;
                    ?>
                </h5>
            </div>
        </div>
        <div class="col-md-4 mb-3 mt-3">
            <div class="card card-body p-3 border-info border-top-0 border-end-0 border-bottom-0 border-4">
                <p class="text-sm mb-0 text-capitalize fw-bold">Total Appointments</p>
                <h5 class="fw-bolder mb-0">
                    <?php 
                        $todayDate = date('Y-m-d');
                        $query = "SELECT * FROM bookings";
                        $result = mysqli_query($conn, $query);
                        $totalCount = mysqli_num_rows($result);
                        echo $totalCount;
                    ?>
                </h5>
            </div>
        </div>
        <div class="col-md-4 mb-3 mt-3">
            <div class="card card-body p-3 border-secondary border-top-0 border-end-0 border-bottom-0 border-4">
                <p class="text-sm mb-0 text-capitalize fw-bold">Total Pendings</p>
                <h5 class="fw-bolder mb-0">
                    <?php 
                        $query = "SELECT * FROM bookings WHERE status='Pending'";
                        $result = mysqli_query($conn, $query);
                        $totalCount = mysqli_num_rows($result);
                        echo $totalCount;
                    ?>
                </h5>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card card-body p-3 border-primary border-top-0 border-end-0 border-bottom-0 border-4">
                <p class="text-sm mb-0 text-capitalize fw-bold">Approved</p>
                <h5 class="fw-bolder mb-0">
                    <?php 
                        $query = "SELECT * FROM bookings WHERE status='Approved'";
                        $result = mysqli_query($conn, $query);
                        $totalCount = mysqli_num_rows($result);
                        echo $totalCount;
                    ?>
                </h5>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card card-body p-3 border-warning border-top-0 border-end-0 border-bottom-0 border-4">
                <p class="text-sm mb-0 text-capitalize fw-bold">Declined</p>
                <h5 class="fw-bolder mb-0">
                    <?php 
                        $query = "SELECT * FROM bookings WHERE status='Decline'";
                        $result = mysqli_query($conn, $query);
                        $totalCount = mysqli_num_rows($result);
                        echo $totalCount;
                    ?>
                </h5>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card card-body p-3 border-success border-top-0 border-end-0 border-bottom-0 border-4">
                <p class="text-sm mb-0 text-capitalize fw-bold">Completed</p>
                <h5 class="fw-bolder mb-0">
                    <?php 
                        $query = "SELECT * FROM bookings WHERE status='Completed'";
                        $result = mysqli_query($conn, $query);
                        $totalCount = mysqli_num_rows($result);
                        echo $totalCount;
                    ?>
                </h5>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card card-body p-3 border-danger border-top-0 border-end-0 border-bottom-0 border-4">
                <p class="text-sm mb-0 text-capitalize fw-bold">Failed</p>
                <h5 class="fw-bolder mb-0">
                    <?php 
                        $query = "SELECT * FROM bookings WHERE status='Failed'";
                        $result = mysqli_query($conn, $query);
                        $totalCount = mysqli_num_rows($result);
                        echo $totalCount;
                    ?>
                </h5>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mt-3 bg-white">
            <h5 class="text-center mt-3">No. of Appointment per Week</h5>
            <canvas id="weeklyAppointmentsChart"></canvas>
        </div>

        <div class="col-md-6 mt-3 bg-white">
            <h5 class="text-center mt-3">No. of Appointment per Month</h5>
            <canvas id="monthlyAppointmentsChart"></canvas>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mt-3 bg-white">
            <h5 class="text-center mt-3">Appointment per Hour</h5>
            <canvas id="hourlyAppointmentsChart"></canvas>
        </div>
        <div class="col-md-4 mt-3 bg-white">
            <h5 class="text-center mt-3">Appointment Status</h5>
            <canvas id="myChart"></canvas>
        </div>
        <div class="col-md-6 mt-3 bg-white">
            <h5 class="text-center mt-3">Services</h5>
            <canvas id="serviceAppointmentsChart"></canvas>
        </div>
    </div>

    <div class="row">
        
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Fetch data from server
    fetch('status.php')
    .then(response => response.json())
    .then(data => {
        const statuses = Object.keys(data);
        const counts = Object.values(data);

        // Create chart
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: statuses,
                datasets: [{
                    label: 'Appointment Status Counts',
                    data: counts,
                    backgroundColor: [
                        'rgba(13, 110, 253, 0.5)',
                        'rgba(25, 135, 84, 0.5)',
                        'rgba(255, 193, 7, 0.5)',
                        'rgba(220, 53, 69, 0.5)',
                        'rgba(108, 117, 125, 0.5)'
                    ],
                    borderColor: [
                        'rgba(13, 110, 253, 1)',
                        'rgba(25, 135, 84, 1)',
                        'rgba(255, 193, 7, 1)',
                        'rgba(220, 53, 69, 1)',
                        'rgba(108, 117, 125, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
<script>
    // Fetch data from server
    fetch('weeks.php')
    .then(response => response.json())
    .then(data => {
        const weeks = Object.keys(data);
        const appointmentCounts = Object.values(data);

        // Create chart
        var ctx = document.getElementById('weeklyAppointmentsChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: weeks,
                datasets: [{
                    label: 'Appointments per Week',
                    data: appointmentCounts,
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    });
</script>
<script>
    // Fetch data from server
    fetch('month.php')
    .then(response => response.json())
    .then(data => {
        const months = Object.keys(data);
        const appointmentCounts = Object.values(data);

        // Create chart
        var ctx = document.getElementById('monthlyAppointmentsChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Appointments per Month',
                    data: appointmentCounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    });
</script>
<script>
    // Fetch data from server
fetch('hour.php')
    .then(response => response.json())
    .then(data => {
        // Initialize arrays to store labels and data
        const labels = [];
        const appointmentCounts = [];

        // Loop through the data and extract hour and count
        for (let hour = 1; hour <= 12; hour++) {
            // Adjust count index to 12-hour format
            let countIndex = hour;
            if (hour === 12) {
                countIndex = 0; // 12:00 PM is counted as 0 in the data
            }
            const count = data[countIndex];

            // Append "AM" or "PM" based on hour
            const ampm = hour >= 12 ? 'PM' : 'AM';
            // Convert hour to 12-hour format
            const displayHour = hour === 0 ? 12 : hour;

            // Construct label with AM/PM indicator
            const label = `${displayHour}:00 ${ampm}`;

            // Add label and count to respective arrays
            labels.push(label);
            appointmentCounts.push(count);
        }

        // Create chart
        var ctx = document.getElementById('hourlyAppointmentsChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Appointments per Hour',
                    data: appointmentCounts,
                    backgroundColor: 'rgba(153, 102, 255, 0.5)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    })
    .catch(error => {
        console.error('Error fetching data:', error);
    });
</script>
<script>
    // Fetch data from server
    fetch('services.php')
    .then(response => response.json())
    .then(data => {
        const serviceTypes = Object.keys(data);
        const appointmentCounts = Object.values(data);

        // Create chart
        var ctx = document.getElementById('serviceAppointmentsChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'polarArea',
            data: {
                labels: serviceTypes,
                datasets: [{
                    label: 'Appointments by Service',
                    data: appointmentCounts,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(25, 135, 84, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 159, 64, 0.5)',
                        'rgba(201, 203, 207, 0.5)'
                    ],
                        borderColor: [
                        'rgb(255, 99, 132, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(25, 135, 84, 1)',
                        'rgb(75, 192, 192, 1)',
                        'rgb(54, 162, 235, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgb(201, 203, 207, 1)'
                    ],
                        borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    });
</script>
</body>
</html>