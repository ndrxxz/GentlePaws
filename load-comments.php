<?php
include("conn.php");

    $commentNewCount = $_POST['commentNewCount'];
    
    $sql = "SELECT * FROM review LIMIT $commentNewCount ";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<P>";
            echo "<b>Name: </b>" . $row['name'];
            echo "</P>";
            echo "<p>";
            echo "<b>Email: </b>" . $row['email'];
            echo "</P>";
            echo "<b>Rating: </b>" . $row['rating'];
            echo "</b>";
            echo "<br>";
            echo "<P>";
            echo "<b>Review: </b>" . $row['review'];
            echo "<br>";
            echo "<br>";
            echo "</p>";
            echo "<hr>";
            echo "<br>";
        }
    } else {
        echo "there are no comments!";

    }
    ?> 