<?php 
function build_calendar($month, $year){

    $mysqli =  new mysqli('localhost', 'root', '', 'gentlepaws');
    // $stmt = $mysqli->prepare('SELECT * FROM bookings WHERE MONTH(date) = ? AND YEAR(date) = ?');
    // $stmt -> bind_param('ss', $month, $year);
    // $bookings = array();
    // if($stmt->execute()){
    //     $result = $stmt -> get_result();
    //     if($result->num_rows > 0){
    //         while($row = $result->fetch_assoc()){
    //             $bookings[] = $row['date'];
    //         }
    //         $stmt -> close();
    //     }
    // }

    // Retrieve blocked dates from the database
    // $close = array();
    // $result = $mysqli->query("SELECT * FROM close");
    // while ($row = $result->fetch_assoc()) {
    //     $close[$row['date']] = array(
    //         'start' => $row['start'],
    //         'end' => $row['end']
    //     );
    // }

    $close = array();
    $result = $mysqli->query("SELECT date FROM close");
    while ($row = $result->fetch_assoc()) {
        $close[] = $row['date'];
    }


    $daysOfWeek = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'); // Array to hold the days of the week
    // $monthNumber = date_parse($month)['month'];
    $firstDayOfMonth = strtotime("$year-$month-01");
    // $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    $numberDays = date('t', $firstDayOfMonth);
    $dateComponents = getdate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    $dayOfWeek = $dateComponents['wday'];   
    $dateToday = date('Y-m-d');
    
    // $prev_month = date('m', mktime(0, 0, 0, $month-1, 1, $year));
    // $prev_year = date('Y', mktime(0, 0, 0, $month-1, 1, $year));
    // $next_month = date('m', mktime(0, 0, 0, $month+1, 1, $year));
    // $next_year = date('Y', mktime(0, 0, 0, $month+1, 1, $year));

    $prev_month = date('m', mktime(0, 0, 0, intval($month)-1, 1, $year));
    $prev_year = date('Y', mktime(0, 0, 0, intval($month)-1, 1, $year));
    $next_month = date('m', mktime(0, 0, 0, intval($month)+1, 1, $year));
    $next_year = date('Y', mktime(0, 0, 0, intval($month)+1, 1, $year));

    $calendar = "<center><h2>$monthName $year</h2>";
    $calendar .= "<a class='btn btn-danger btn-sm' href='?month=".$prev_month."&year=".$prev_year."'>Prev Month</a> ";
    $calendar .= "<a class='btn btn-primary btn-sm' href='?month=".date('m')."&year=".date('Y')."'>Current Month</a> ";
    $calendar .= "<a class='btn btn-success btn-sm' href='?month=".$next_month."&year=".$next_year."'>Next Month</a></center>";
    $calendar .= "<br><table class='table table-bordered'>";
    $calendar .= "<tr>";
    foreach($daysOfWeek as $day){
        $calendar .= "<th class='header'>$day</th>";
    }

    $calendar .= "</tr><tr>";
    $currentDay = 1;
    if($dayOfWeek > 0){
        for($k = 0; $k < $dayOfWeek; $k++){
            $calendar .= "<td class='empty'></td>";
        }
    }

    // $month = str_pad($month, 2, "0", STR_PAD_LEFT);
    $month = str_pad(intval($month), 2, "0", STR_PAD_LEFT);
    while($currentDay <= $numberDays){
        if($dayOfWeek == 7){
            $dayOfWeek = 0;
            $calendar .= "</tr><tr>";
        }

        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $date = "$year-$month-$currentDayRel";
        $dayName = strtolower(date('l', strtotime($date)));

        $eventNum = 0;
        $today = $date == date('Y-m-d')?'today':'';

        if(in_array($date, $close)){
            $calendar .= "<td><h4>$currentDay</h4><button class='btn btn-warning btn-sm w-75'>Closed</button>";
        }elseif($date < date('Y-m-d')){
            $calendar .= "<td><h4>$currentDay</h4><button class='btn btn-secondary btn-sm w-75'>N/A</button>";
        } else {
            $totalbookings = checkSlots($mysqli, $date);
            if($totalbookings == 10){
                $calendar .= "<td class='$today'><h4>$currentDay</h4><button class='btn btn-danger btn-sm w-75'>Full</button>";

            } else {
                $availableslots = 10 - $totalbookings;
                $calendar .= "<td class='$today'><h4>$currentDay</h4><a href='book.php?date=".$date."' class='btn btn-success btn-sm position-relative w-75'>Available <span class='position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger'>
                $availableslots
                <span class='visually-hidden'>unread messages</span>
            </span></a>";
        }
    }

        // else if(in_array($date, $bookings)){
        //     $calendar .= "<td class='$today'><h4>$currentDay</h4><button class='btn btn-danger btn-sm w-75'>FULL</button>";
        // }


        // $calendar .= "<td class='$today'><h4>$currentDay</h4><a class='btn btn-success btn-sm'>Book</a></td>";
        $currentDay++;
        $dayOfWeek++;
    }

    if($dayOfWeek < 7){
        $remainingDays = 7 - $dayOfWeek;
        for($i = 0; $i < $remainingDays; $i++){
            $calendar .= "<td class='empty'></td>";
        }
    }

    $calendar .= "</tr></table>";

    return $calendar;
}

function checkSlots($mysqli, $date){
    $stmt = $mysqli->prepare('SELECT * FROM bookings WHERE date = ?');
    $stmt -> bind_param('s', $date);
    $totalbookings = 0;
    if($stmt->execute()){
        $result = $stmt -> get_result();
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $totalbookings++;
            }
            $stmt -> close();
        }
    }

    return $totalbookings;

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/calendar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="shortcut icon" href="gentle paws logo.png" type="image/x-icon">
    <title>Calendar | Gentle Paws</title>
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

<div class="container-fluid w-75">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-body">
                <?php 
                    $dateComponents = getdate();
                    if(isset($_GET['month']) && isset($_GET['year'])){
                        $month = $_GET['month'];
                        $year = $_GET['year'];
                    } else {
                        // $month = $dateComponents['month'];
                        // $year = $dateComponents['year'];
                        $month = date('m');
                        $year = date('Y');
                    }

                    echo build_calendar($month, $year);
                ?>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
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