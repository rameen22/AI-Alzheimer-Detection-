<?php
session_start();
include "connect2.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);

    $sqlSelect = "SELECT * FROM registration WHERE email = '$email' AND status = 'active'";
    $resultSelect = mysqli_query($con, $sqlSelect);

    if (mysqli_num_rows($resultSelect) > 0) {
        // Email exists, generate and send OTP
        $otp = substr(str_shuffle("0123456789"), 0, 5);

        $subject = 'Forget Password - Verification code';
        $message_body = "Your verification code is: $otp.\nSincerely,";

        $mail = new PHPMailer(true);

        try {
            // SMTP settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'entertainment.pkk@gmail.com'; // Your Gmail username
            $mail->Password   = 'oepcksbqulxlyctf'; // Your Gmail password
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;

            // Email content
            $mail->setFrom('entertainment.pkk@gmail.com', 'Alzheimer');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message_body;

            $mail->send();

            // Store email and OTP in session
            $_SESSION['reset_email'] = $email;
            $_SESSION['reset_otp'] = $otp;

            // Redirect to OTP verification page
            header("Location: otp_verification.php");
            exit();
        } catch (Exception $e) {
            echo '<script>alert("Failed to send OTP");</script>';
            echo "Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo '<script>alert("No account found with this email");</script>';
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
  font-size:20px;
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
            <input type="email" name="email" required class="input"placeholder="Enter registered Email">
        <br><br>        <br><br>
        <br><br>
        <br><br>

        <button type="submit" name="submit" class="submit">Submit</button>
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