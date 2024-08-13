<?php 
    session_start();

    include("../GentlePaws/conn.php");
    // if(!isset($_SESSION["valid"])){
    //     header("location: index.php");
    // }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <link rel ="stylesheet" type="text/css" href="style.css">
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

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width-device-width, initial-scale-1.0">
        <link rel="stylesheet" href="style.css">
        <title>Feedbacks | Gentle Paws</title>
        <link rel="shortcut icon" href="gentle paws logo.png" type="image/x-icon">
    </head>
    <body>
      
        <main>
            <div class="main-box top">
            
                    <div class="bottom">
                        <div class="box">
                            <div id="comments">
                            <?php
                            $sql = "SELECT * FROM review LIMIT 2";
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
                            </div>

                                <button> Show more Comments </button>

                        </div>
                     </div>

                   
                    </div>
                    
                     </div>

                    </div>
                </div>
                
            </div>

        </main>
    </body>
</html>