<?php 
session_start();
include("../GentlePaws/conn.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Feedback Form | Gentle Paws</title>
    <link rel="shortcut icon" href="gentle paws logo.png" type="image/x-icon">
</head>
<body>
      <div class="containers">
        <div class="box form-box">
   



        <?php 
            if(isset($_POST['submit'])){
                $rating = $_POST['rating'];
                $name = $_POST['name'];
                $email = $_POST['email'];
                $review = $_POST['review'];

         
                
            //verifying the unique email 

            
    
            

                if (mysqli_query($conn,"INSERT INTO review(rating , name, email, review) VALUES('$rating','$name','$email','$review')") or die("Error Occured"));{
                echo "<div class='message'>
                <p>Feedback Successfully!</p>
              </div> <br>";
            header("Location: index.php");
            }
        }
            else{
            
            
        
        ?>
            
            <header>YOUR FEEDBACK IS  IMPORTANT</header>
            
            <form action ="" method = "post">
          
                <div class = "field input">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name"  autocomplete="off" required>
                </div>

                <div class = "field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete ="off" required>
                </div>
                <td><label for="rating">Rating :</label></td>
         <td>
         <select id="rating" name="rating" required>
            <option value="" selected>Select Rating </option>
            <option value="Excellent">Excellent</option>
            <option value="Very Good">Very Good</option>
            <option value="Good">Good</option>
            <option value="Poor">Poor</option>
         </select>
            </td>
            <br>
            </br>
                <form id="myform">
                    Your Review: <br>
               
                    <textarea name="review" id="review" cols="60" rows="6" placeholder="Leave your message....." required></textarea>
                
                

                <div class = "field">
                    <input type="submit" class="btn" name="submit" id="Login" value="Submit" required>
                </div>
                </form>
        </div>
        <?php } ?>
      </div>
</body>
</html>