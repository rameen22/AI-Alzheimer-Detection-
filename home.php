
<?php
session_start();
$message='';
if(isset($_SESSION['email_alert'])){
    $message="Email ID Already Exists!!";
}
//else{
    //$message="Registeraion Successfull...";
//

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
        <form id="login" class="input" action="login.php" method="post">
            <input type ="email" class="input-field" name="email" placeholder="Email" required>
            <input type ="text" class="input-field"  name="password" placeholder="Password" required>
            <br><br><br><br>  <br><br><button  type="submit" class="submit">Login</button><br><br><br><br>
            <p class="styletext">Dont't Have an Account?<br><br><br>Register Now</p>
        </form>
        <form id="Register" class="input" action="connect.php" method="post">
            <center><h3>  <p style="color:red;"><?php echo $message; ?> </p>  </h3> </center>
            <br>
        <input type ="text" class="input-field" name="username" placeholder="Username" required>
            <input type ="email" class="input-field" name="email"placeholder="Email" required>
            <input type ="password" class="input-field"name="password" placeholder="Password " required>
            <div class="selecttype">
                <label>
                    <input type="radio" name="usertype" value="patient" checked> Patient
                </label>
                <label>
                    <input type="radio" name="usertype" value="doctor"> Doctor
                </label>
            </div>
            <button  type="submit" class="submit" >Register</button>
            <br><br><br><p class="styletext">Alrady Have an Account?Login</p class="selecttext"><p>
            
        </form>
        </div> 
        </div><?php unset($_SESSION['email_alert']);?>
 </body>
        <script>
var x = document.getElementById("login");
var y = document.getElementById("Register");
var z = document.getElementById("btn");

function Register() {
x.style.left ="-400px";
y.style.left ="50px";
z.style.left ="110px";

}

function login() {
x.style.left ="-45px";
y.style.left ="450px";
z.style.left ="0px";}

function toggleLogin() {
            var overlay = document.getElementById("overlaylogin");
            overlay.style.display = "block";
            login()
        }
        function closeForm() {
    var overlay = document.getElementById("overlaylogin");
    overlay.style.display = "none";
}


</script>
</body>
</html>
