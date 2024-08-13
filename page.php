<?php 
include('conn.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="feedback.css">
    <title>Feedbacks | Gentle Paws</title>
    <link rel="shortcut icon" href="gentle paws logo.png" type="image/x-icon">
</head>
<body>
    <div class="container mt-3">
        <div class="row justify-content-center align-items-center inner-row">
            <div class="col-md-9">
                <div class="card mx-5">
                    <div class="card-header bg-black text-white">
                        <h4 class="fw-bold pt-3">Feedbacks</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="comments" class="table-borderless">
                                <?php 
                                    $query = "SELECT * FROM review LIMIT 2";
                                    $query_run = mysqli_query($conn, $query);

                                    if(mysqli_num_rows($query_run) > 0){
                                    foreach($query_run as $row){
                                ?>
                                    <tr>
                                        <th>Name: </th>
                                        <td class="ps-3"><?=$row['name'];?></td>
                                    </tr>
                                    <tr>
                                        <th>Email: </th>
                                        <td class="ps-3"><?=$row['email'];?></td>
                                    </tr>
                                    <tr>
                                        <th>Rating: </th>
                                        <td class="ps-3"><?=$row['rating'];?></td>
                                    </tr>
                                    <tr>
                                        <th>Comment/s: </th>
                                        <td class="ps-3"><?=$row['review'];?></td>
                                    </tr>
                                    <tr>
                                        
                                    </tr>
                                <?php 
                                    }
                                } else {
                                    echo "<h5>No Record Found!</h5>";
                                }
                                ?>
                            </table>
                            <button class="btn btn-primary mt-3"> Show more Comments </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  $(document).ready( function () {
    $('#myTable').DataTable();
  });
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        var commentCount = 2;
        $("button").click(function() {
            commentCount = commentCount + 2;
            $("#comments").load("load-comments.php", {
                commentNewCount: commentCount 
            });
        });
    });
</script>
</body>
</html>