<?php
session_start();

include "connect2.php";

if (isset($_POST['login'])) {
    $email = $_POST['email']; // Corrected variable name
    $password = $_POST['password'];
    $usertype = $_POST["usertype"];

    $sqlLogin = "SELECT * FROM registration WHERE email ='".$email."' AND password = '".$password."' AND status = 'active'";
    $resultLogin = mysqli_query($con, $sqlLogin);

    if (mysqli_num_rows($resultLogin) > 0) {
        $rememberme = isset($_POST['rememberme']) ? $_POST['rememberme'] : '';

        if ($rememberme == "checked") {
            setcookie('email', $email);
            setcookie('password', $password);
        } else {
            setcookie('email', '');
            setcookie('password', '');
        }

        if ($row = mysqli_fetch_assoc($resultLogin)) {
            $_SESSION['id'] = $row['id'];
            $email = $row['email'];

            if ($row['usertype'] == 'doctor') {
                // Save doctor ID in session
                $_SESSION['id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                header('location:index.html');
            } elseif ($row['usertype'] == 'patient') {
                // Redirect to patient page
                $_SESSION['email'] = $row['email'];
                header('location:index2.php');
            }
        }
    } else {
        echo "<script>alert('Incorrect email or password');</script>";
    }
}?>
<?php

// Use the correct namespace
 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

include "connect2.php";

// SIGNUP PROCESS CODE
if (isset($_POST['register'])) {
    $otp_str = str_shuffle("0123456789");
    $otp = substr($otp_str, 0, 5);

    $act_str = rand(100000, 10000000);
    $activation_code = str_shuffle("abcdefghijklmno" . $act_str);

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $usertype = $_POST['usertype'];

    $selectDatabase = "SELECT * FROM registration WHERE email = '$email'";
    $selectResult = mysqli_query($con, $selectDatabase);

    if (mysqli_num_rows($selectResult) > 0) {
        // Email already exists
        echo "<script>alert('Email already registered')</script>";
    } else {
        // Check password length
        if (strlen($password) != 8) {
            echo "<script>alert('Password must be  8 characters long')</script>";
        } else {
            // Email doesn't exist, send OTP and redirect to OTP page
            $subject = 'Verification code for Verify Your Email Address';
            $message_body = "For verify your email address, enter this verification code when prompted: $otp.\nSincerely,";

            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'entertainment.pkk@gmail.com'; // your Gmail username
                $mail->Password   = 'oepcksbqulxlyctf'; // your Gmail password
                $mail->SMTPSecure = 'ssl';
                $mail->Port       = 465;

                // Recipients
                $mail->setFrom('entertainment.pkk@gmail.com', 'Alzheimer');
                $mail->addAddress($email, $username);

                // Content
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $message_body;

                $mail->send();

                // OTP sent successfully, store details in session and redirect to OTP page
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                $_SESSION['usertype'] = $usertype;
                $_SESSION['otp'] = $otp;
                $_SESSION['activation_code'] = $activation_code;

                header("Location: email_verify.php");
                exit();
            } catch (Exception $e) {
                // Error in sending email
                echo "<script>alert('Failed to send OTP');</script>";
                echo "Mailer Error: {$mail->ErrorInfo}";
            }
        }
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

.animate-onload {
    animation: slideInFromLeft 2s ease-out forwards;
}</style>
<body>
<div class="banner">
        <div class="navbar">
            <img src="brain-care-q.png" class="logo">
            <a href="#" onclick="toggleLogin()">Login</a>
            <a href="aboutus.html">About</a>
            <a href="home.php">Home</a>
        </div>

        <div class="content animate-onload">
    <h1>Detecting Alzheimer Early<br> Preserving a Lifetime of Memories</h1>
</div>
    </div>

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
    <div class="overlay_login" id="overlaylogin">
        <div class="form-box" id="form">
            <div class="button-box">
                <div id="btn"></div>
                <button type="button" class="toggle-btn" onclick="login()">Log in </button>
                <button type="button" class="toggle-btn" onclick="Register()">Register</button>
                <button type="button" class="close-btn" onclick="closeForm()">X</button>
            </div>
            <form id="login" class="input" action=" " method="post">
                <input type="email" class="input-field" name="email" placeholder="Email"
                    value="<?php if(isset($_COOKIE['email'])){ echo $_COOKIE['email']; }?>" autocomplete="off" required>
                <input type="password" class="input-field" name="password" placeholder="Password "
                    value="<?php if(isset($_COOKIE['password'])){ echo $_COOKIE['password']; }?>" autocomplete="off"
                    required>
                <br><br><br><br>
                <br><br><button type="submit" class="submit" value="login" name="login">Login</button><br><br><br><br>
                <div class="styletext">
                    <input type="checkbox" name="rememberme" value="checked"
                        <?php if(isset($_COOKIE['email'])){ echo 'checked'; }?>><label class="rem">Remember me</label>
                    <label class="forgot"><a href="forgetpass.php">Forgot Password?</a></label>
                </div>
            </form>
            <form id="Register" class="input" action="" method="post">
    <br>
    <input type="text" class="input-field" name="username" placeholder="Username" required>
    <input type="email" class="input-field" name="email" placeholder="Email" autocomplete="off" required>
    <input type="password" class="input-field" name="password" placeholder="Password must be exactly 8 characters long" pattern=".{8,}" title="Password must be exactly 8 characters long" required>
    <div class="selecttype">
        <label>
            <input type="radio" name="usertype" value="patient" checked> Patient
        </label>
        <label>
            <input type="radio" name="usertype" value="doctor"> Doctor
        </label>
    </div>
    <button type="submit" class="submit" value="register" name="register">Register</button>
    <br><br><br>
    <p class="styletext">Already Have an Account? Login</p>
</form>


            <script>
                var x = document.getElementById("login");
                var y = document.getElementById("Register");
                var z = document.getElementById("btn");
                var verificationForm = document.getElementById("verification");

                function Register() {
                    x.style.left = "-400px";
                    y.style.left = "50px";
                    z.style.left = "110px";
                }

                function login() {
                    x.style.left = "-45px";
                    y.style.left = "450px";
                    z.style.left = "0px";
                }

                function toggleLogin() {
                    var overlay = document.getElementById("overlaylogin");
                    overlay.style.display = "block";
                    login();
                }

                function closeForm() {
                    var overlay = document.getElementById("overlaylogin");
                    overlay.style.display = "none";
                }


            </script>
</body>

</html>
