<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name = "author" content="Andrea Torres">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gentle Paws</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="home.css">
    <link rel="shortcut icon" href="gentle paws logo.png" type="image/x-icon">
</head>
<body>
    <nav>
        <div class="one">
            <img src="gentle paws logo.png" alt="Gentle Paws Logo" width="50" height="50">
            <h2 class="logo">Gentle Paws</h2>
        </div>
        <ul>
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About Us</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#contact">Contacts Us</a></li>
            <!--<li><a href="login.php">Login</a></li>-->
            <a href="login1.php" class="button" target="_blank">Login</a>
        </ul>
    </nav>
    <div id="home">
        <div class="content">
            <p class="p1">Welcome to</p>
            <p class="p2">Gentle Paws</p>
            <p class="p3">Gentle Paws is your go-to solution for hassle-free veterinary appointments. Say goodbye to long wait times and 
                phone calls – with Gentle Paws, scheduling appointments for your furry friends has never been easier. Whether you're a pet 
                owner looking to book appointments with ease or a veterinary clinic in need of streamlined appointment management, 
                Gentle Paws has you covered.</p>
        </div>
    </div>
    <div id="about">
        <h1 class="h1-about">About Us</h1>
        <div class="content-about">
            <!-- <img class="blue" src="/img/lucrezia-carnelos-WrG-lFojjW4-unsplash.jpg" alt="dog in blue bg" width="400" height="270"> -->
            <p class="about-p">Gentle Paws is a forward-thinking veterinary appointment system dedicated to simplifying the process of scheduling 
                appointments for pets. Founded with the vision of enhancing pet healthcare accessibility and efficiency, Gentle Paws 
                offers intuitive online booking features tailored for both pet owners and veterinary clinics. Our platform streamlines 
                appointment management, providing real-time availability updates and automated notifications. With a passionate team 
                committed to innovation and pet welfare, Gentle Paws aims to revolutionize the way pets receive care while empowering pet 
                owners with convenience and peace of mind.</p>
        </div>
        <a href="../index.php" class="button-about" target="_blank">Feedbacks</a>
    </div>
    <div id="services">
        <h1 class="services-heading">Services</h1>
        <p></p>
        <div class="cards1">
            <div class="card1">
                <i class="fa-solid fa-syringe" style="color: #fc7c8c;"></i>
                <h2>Vaccinations</h2>
                <p>Administration of essential vaccines to protect pets against common infectious diseases, such as rabies, distemper, parvovirus, and others.</p>
                <p class="prices">₱ 300 - ₱ 700</p>
            </div>
            <div class="card1">
                <i class="fa-solid fa-scissors" style="color: #fc7c8c;"></i>
                <h2>Grooming</h2>
                <p>Services such as bathing, brushing, nail trimming, and ear cleaning to maintain the hygiene and appearance of pets.</p>
                <p class="prices">₱ 350</p>
            </div>
            <div class="card1">
                <i class="fa-solid fa-pills" style="color: #fc7c8c;"></i>
                <h2>Deworming</h2>
                <p>It's a preventive measure done in veterinary clinics to keep pets healthy and prevent the spread of parasites to humans.</p>
                <p class="prices">₱ 150 - ₱ 450</p>
            </div>
        </div>
        <div class="cards2">
            <div class="card2">
                <i class="fa-solid fa-microscope" style="color: #fc7c8c;"></i>
                <h2>Diagnostic Testing</h2>
                <p>Various diagnostic tests including blood work, urinalysis, fecal exams, X-rays, ultrasound, and other imaging techniques to diagnose illnesses and monitor health conditions.</p>
                <p class="prices">₱ 250 - ₱ 1,000</p>
            </div>
            <div class="card2">
                <i class="fa-solid fa-stethoscope" style="color: #fc7c8c;"></i>
                <h2>Preventive Care</h2>
                <p>Recommendations and treatments to prevent common health issues such as dental disease, obesity, heartworms, and flea/tick infestations.</p>
                <p class="prices">₱ 250</p>
            </div>
            <div class="card2">
                <i class="fa-solid fa-heart-pulse" style="color: #fc7c8c;"></i>
                <h2>Surgery</h2>
                <p>Surgical procedures ranging from routine spaying and neutering to more complex surgeries such as tumor removals, orthopedic surgeries, and emergency procedures.</p>
                <p class="prices">₱ 1,500 - ₱ 7,000</p>
            </div>
        </div>
        <div class="cards3">
            <div class="card3">
                <i class="fa-solid fa-tooth" style="color: #fc7c8c;"></i>
                <h2>Dental Care</h2>
                <p>Dental exams, cleanings, and treatments to maintain oral health and prevent dental diseases in pets.</p>
                <p class="prices">₱ 850</p>
            </div>
        </div>
    </div>
    <div id="contact">
        <!-- <h1 class="contact-header">Contact Us</h1>
        <p class="contact-p">We would love to respond to your questions and help you with you concerns. Feel free to get in touch with us.</p> -->
        <div class="contact-box">
            <div class="contact-left">
                <h3>Send your message to us!</h3>
                <!-- <?php 
                    include('success.php');
                    include('warning.php');
                ?> -->
                <form action="mail.php" method="POST">
                    <div class="input-row">
                        <div class="input-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="" placeholder="Name">
                        </div>
                        <div class="input-group">
                            <label for="contact">Contact Number</label>
                            <input type="text" name="contact" id="" placeholder="Contact Number">
                        </div>
                    </div>
                    <div class="input-row">
                        <div class="input-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="" placeholder="Email">
                        </div>
                        <div class="input-group">
                            <label for="subject">Subject</label>
                            <input type="text" name="subject" id="" placeholder="Subject">
                        </div>
                    </div>
                    <label for="message">Message</label>
                    <textarea name="message" id="" rows="5"placeholder="Message"></textarea>

                    <button type="submit" name="submit">Submit</button>
                </form>
            </div>
            <div class="contact-right">
                <h3>Connect with Us</h3>
                <table>
                    <tr>
                        <td>Email: </td>
                        <td>gentlepaws35@gmail.com</td>
                    </tr>
                    <tr>
                        <td>Contact #: </td>
                        <td>09123456789</td>
                    </tr>
                    <tr>
                        <td>Address: </td>
                        <td>Pasig, Philippines</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <footer class="footer-distributed">
        <div class="footer-left">
            <div class="logo">
                <h3><span class="span-left">Gentle </span><span>Paws</span></h3>
            </div>
            <p class="footer-links">
                <a href="#home">Home</a>
                |
                <a href="#about">About Us</a>
                |
                <a href="#services">Services</a>
                |
                <a href="#contact">Contact Us</a>
            </p>
            <p class="footer-name">&#169; Copyright | 2024 <strong>MAT</strong>
                All rights reserved</p>
        </div>
        <div class="footer-center">
            <div>
                <i class="fa-solid fa-map-pin"></i>
                <p><span>Pasig,</span>
                    Philippines</p>
            </div>
            <div>
                <i class="fa fa-phone"></i>
                <p>09123456789</p>
            </div>
            <div>
                <i class="fa fa-envelope"></i>
                <p>gentlepaws35@gmail.com</p>
            </div>
        </div>
        <div class="footer-right">
            <p class="footer-about">
                <span>About the Company</span>
                <strong>Gentle Paws</strong> is a forward-thinking veterinary appointment system dedicated to simplifying the process of scheduling 
                appointments for pets. Founded with the vision of enhancing pet healthcare accessibility and efficiency, Gentle Paws 
                offers intuitive online booking features tailored for both pet owners and veterinary clinics.
            </p>
            <div class="footer-icons">
                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
            </div>
        </div>
    </footer>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript">
        window.addEventListener("scroll", function(){
            var nav = document.querySelector("nav");
            nav.classList.toggle("sticky", window.scrollY > 0);
        })
    </script>
</body>
</html>