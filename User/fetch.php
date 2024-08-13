<?php 

include('../conn.php');

if(isset($_POST['request'])){
    $request = mysqli_real_escape_string($conn, $_POST['request']);

    $query = "SELECT * FROM bookings WHERE status = '$request'";
    $query_run = mysqli_query($conn, $query);
    $count = mysqli_num_rows($query_run);
}
?>

<div class="card-body">
    <div class="table-responsive">
        <table id="myTable" class="table-bordered table-striped">
        <?php 
            if($count){
        ?>
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
                <?php 
                } else {
                    echo "No Records Found!";
                }
            ?>
            </thead>
            <tbody>
                <?php 
                    

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