<?php
session_start();

if (!isset($_SESSION['reset_email'], $_SESSION['reset_otp'])) {
    header("Location: forget_password.php");
    exit();
}

if (isset($_POST['verify'])) {
    $entered_otp = $_POST['otp'];

    if ($entered_otp == $_SESSION['reset_otp']) {
        // Correct OTP, show password update form
        header("Location: update_password.php");
        exit();
    } else {
        echo '<script>alert("Incorrect OTP");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <title>Services</title>
</head>
<style>

    .otp-form{
        width: 380px;
  height: 280px;
  position: relative;
  margin: 6% auto;
  background: #fff;
  padding: 5px;
  border: black ;
 
  border-radius: 15px;
 
overflow:hidden ;    }
   @keyframes slideInFromLeft {
    0% {
        opacity: 0;
        transform: translateX(-50%);
    }
    100% {
        opacity: 1;
        transform: translateX(0%);
    }
}
.hidden {
            display: none;}

            .button-box{
  width: 220px;
  margin: 35px auto;
  position: relative;
  box-shadow: 0 0 20x 9px #ff61241f;
  border-radius: 30px;
}
.message{
    color:black;
font-size:20px;
font-weight:bolder;

}
.input{
    top:80px;
    left:30px;
  text-align: center;
  font-size:40px;
margin-right:50px;
width: 85%;
  transition: .5s;
  line-height: 8px;
  font-family: 'Times New Roman', Times, serif;
  padding:10px 0;
  margin: 5px 1px;
  float: left;
  height: 40px;

}

.submit:hover {
transform: scale(1.05); /* Increase size on hover */
box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3); /* Add a subtle shadow */
}
.submit{
    margin-top:650px;

    padding-top: 20px;
  width: 85%;
  padding: 15px 35px;
  cursor:pointer;
  font-weight:bold;
  font-family: 'Times New Roman', Times, serif;
  display: block;
  margin: auto;
  font-size:95px;
background-color:steelblue;
  border: 0;
  outline: none;
  border-radius: 20px;
  line-height: top 9px;
  font-size: medium;
}
  
.animate-onload {
    animation: slideInFromLeft 2s ease-out forwards;
}</style>
<body>
<div class="banner">
        <div class="navbar">
            <img src="brain-care-q.png" class="logo">
            <a href="aboutus.html">About</a>
            <a href="home.php">Home</a>
        </div>

        <div class="content ">

        <div class="otp-form">
			
        <form action="" method="POST">
            <div class="form-group"><br>
			<label class="message">Reset Account Password</label>
            <input type="text" name="otp" required class="input">
        <br><br>        <br><br>
        <br><br>
        <br><br>

        <button type="submit" name="verify"class="submit">Verify OTP</button>
    </form>
    </div>
</div></div></div>
   

    <div class="services"id="services">
        <h2>Our Services</h2>
        <div class="service-cards-container">

        <div class="service-card">
            <img src="Alzheimer/disease-removebg-preview.png" alt="Service 1"><br><br>
            <h3>Alzheimer Detection </h3>
            <p>"Early Detection, Lasting Memories."</p>
        </div>
       
        <div class="service-card">
            <img src="Alzheimer/istockphoto-1303715147-612x612.png" alt="Service 2"><br><br>
            <h3>Record Management</h3>
            <p>"Effortless Record-Keeping for You.".</p>
        </div>
        <div class="service-card">
            <img src="stagess.png" alt="3"><br><br><br>
            <h3>Stage Prediction</h3>
            <p id="stage">"Guiding You Through Stages."</p>
        </div>
        <div class="service-card">
            <img src="Alzheimer/BackgroundRemover.png" alt="Service 3"><br>
            <h3>Accurate Result</h3>
            <p>"Reliable Diagnosis, Reliable Care."</p>
        </div>
      </div>
    </div>
    <div class="footer">
        <div class="contact-info">
            <h3>Contact Info</h3><br>
            <div class="info">
                <i class="fa fa-phone"></i>
                <p>+1 (123) 456-7890</p>
            </div>
            <div class="info">
                <i class="far fa-envelope"></i>
                <p>info@example.com</p>
            </div>
        </div>
        

        <div class="quick-links">
            <h3>Quick Links</h3><br>
            <ul>
                <li><a href="aboutus.html">About</a></li>
                <li><a href="#Services">Services</a></li>

            </ul>
        </div>

        <div class="social-media">
            <h3>Social Media</h3><br>
            <i class="fab fa-facebook fa-3x"></i>
            <i class="fab fa-instagram fa-3x"></i>
            <i class="fab fa-twitter fa-3x"></i>

        </div>
    </div>
    

           

               
</body>

</html>
