<?php
session_start();

// Check if the email is set in the session (for logged-in user)
if (!isset($_SESSION['email'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: login.php"); // Change this to your login page
    exit();
}

$logged_in_patient_email = $_SESSION['email']; // Retrieve patient's email from the session
?>
<?php
$servername = "localhost:3308";
$username = "root";
$password = "";
$db = "website";
$conn = new mysqli($servername, $username, $password, $db);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = ''; // Initialize an empty message variable
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctor_email = $_POST['doctor'];
    $patient_email = $_POST['patient'];
    $patient_name = $_POST['patientname'];

    $target_directory = "images/"; // Path to your uploads folder
    $target_file = $target_directory . basename($_FILES["imagefile"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["imagefile"]["tmp_name"]);
    if ($check !== false) {
        $mri_width = 176; // Change this to the width of MRI images
        $mri_height = 208; // Change this to the height of MRI images

        list($width, $height) = $check;

        // Check if the image dimensions match those of an MRI
        if ($width === $mri_width && $height === $mri_height) {
            // Move the uploaded file to the designated folder
            if (move_uploaded_file($_FILES["imagefile"]["tmp_name"], $target_file)) {
                // Insert the file path into the database
                $image_path = $target_file; // Store the path in the variable
                $sql = "INSERT INTO mri_images (doctor_email, patient_email, image, patient_name) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param("ssss", $doctor_email, $patient_email, $image_path, $patient_name);
                    if ($stmt->execute()) {
                        $message = "MRI Successfully sent to Doctor";
                    } else {
                        $message = "Error inserting data: " . $stmt->error;
                    }
                } else {
                    $message = "Prepare statement error: " . $conn->error;
                }
            } else {
                $message = "Error moving the file to the server";
            }
        } else {
            $message = "INVALID! Kindly Upload MRI";
        }
    } else {
        $message = "File is not an image";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="index2styles.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link href="index2.php" rel="import" />
    <link href="viewPrescription.php" rel="import" />
    <link href="viewRecord.php" rel="import" />
    <link href="connect2.php" rel="import" />

    <link href="viewReport.php" rel="import" />
   <!-- <link href="downloadReport.html" rel="import" />-->
    <link href="home.php" rel="import" />
    <title>Patients Dashboard</title>
</head>
<style>@import url('https://fonts.googleapis.com/css?family=Baloo+Bhaijaan|Ubuntu');

*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Ubuntu', sans-serif;
}
.payment{
    
  max-width: 360px;
  margin: 80px auto;
  height: auto;
  padding: 35px;
  padding-top: 70px;
  border-radius: 5px;
  color: #808080;

  position: relative;
}
.message{
text-align:center;
  color: steelblue;
  font-size: 16px;
  font-weight: bold;


}
.payment h2{
  text-align: center;
  letter-spacing: 2px;
  margin-bottom: 40px;
  color: #0d3c61;
}
.mri{
    float: left;
    width: 540px;
}
/* Position icons and labels */
.label {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    align-items: center;
    color: #555555;
}
.note-div {
            background-color: #ffe599;
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
       
/* Adjust input styles */
.input {
    padding: 13px 10px 13px 35px;
    width: 100%;
    text-align: center;
    border: 2px solid #dddddd;
    border-radius: 5px;
    letter-spacing: 1px;
    word-spacing: 3px;
    outline: none;
    font-size: 16px;
    color: #121212;
    position: relative;
}

/* Adjust icons within inputs */
.input i {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 18px;
    color: #555555;
}
  #mri {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            width:530px ;
        }

        #mri label {
            margin-right: 10px;
            Font-weight:bold;
        }
        .input:focus {
    border-color: #0d3c61;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    outline: none;
  }

  /* Style for labels when input fields are focused */
  .input:focus + .label {
    color: #0d3c61;
    transform: translateY(-20px);
    font-size: 12px;
    opacity: 1;
  }

  /* Style for icons when input fields are focused */
  .input:focus + .label + i {
    color: #0d3c61;
  }

        #imagefile {
            flex: 1;
        }

        #button {
            font-size: 16px;
            font-weight: bold;
            text-align: left;
            margin-left: 5px;
            background-color: #2196F3;
            color: #fff;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
.input-group{
    width: 560px;
}
        #button:hover {
            background-color: #0d3c61;
        }
.content-container {
  max-width: 600px; /* Adjust the max-width as needed */
  margin: 40px auto; /* Center the content horizontally */
  background:   color: #808080
; /* Set a background color */
height:590px;
  padding: 20px; /* Adjust padding for space around content */
  border-radius: 10px; /* Add some border radius for a rounded look */
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Add a subtle shadow for depth */
}
.card-grp{
  display: flex;
  justify-content: space-between;
  
}

.card-item{
  width: 48%;
}

.space{
  margin-bottom: 20px;
}

.icon-relative{
  position: relative;
}


.btn{
  margin-top: 12px;
  background: steelblue;
  padding: 2px;
  text-align: center;

  color: #f8f8f8;
  border-radius: 10px;
  cursor: pointer;
width: 180px;
float:right;
height: 45px;
margin-right: 30px;
box-shadow: 0 0 5px rgba(0, 0, 0, 0.4);
border:none;
}
.btn:hover{
    background: green;

}

.btn-secondary{
  margin-top: 2px;
  background: #808080;
  padding: 4px;
  text-align: center;
  color: #f8f8f8;
  border-radius: 5px;
  cursor: pointer;
width: 90px;
margin-left: 26px;
height: 35px;
border shadow:4px;
}



.payment-logo{
  position: absolute;
  top: -50px;
  left: 50%;
  transform: translateX(-50%);
  width: 100px;
  height: 100px;
  background: #f8f8f8;
  border-radius: 50%;
  box-shadow: 0 0 5px rgba(0,0,0,0.2);
  text-align: center;
  line-height: 85px;
}

.payment-logo:before{
  content: "";
  position: absolute;
  top: 5px;
  left: 5px;
  width: 90px;
  height: 90px;
  background: #2196F3;
  border-radius: 50%;
}

.payment-logo p{
  position: relative;
  color: #f8f8f8;
  font-family: 'Baloo Bhaijaan', cursive;
  font-size: 58px;
}
.banner{
            background-image: url("depositphotos_.jpg");
            background-attachment: fixed;
        }

@media screen and (max-width: 420px){
  .card-grp{
    flex-direction: column;
  }
  .card-item{
    width: 100%;
    margin-bottom: 15px;
  }
  .btn{
    margin-top: 10px;
  }
}</style>
<body>
<div class="banner" >
        <div class="d-flex" id="wrapper">
            <!-- Sidebar -->
            <div class="bg-white" id="sidebar-wrapper">
                <div class="navbar navbar-expand-lg navbar-light py-2 px-4">
                    <img style width="200px" height="30px" src="brain-care-q.png">
                </div>
                <div class="list-group list-group-flush my-3">
                    <a href="index2.php"
                        class="list-group-item list-group-item-action bg-transparent second-text active"><i
                            class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="patientinbox.php"
                        class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                            class="fas fa-eye me-2"></i>Inbox</a>
                    <a href="availableDoctors.php"
                        class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                            class="fas fa-eye me-2"></i>Available Doctors</a>
                            <a href="availableDoctors.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                                class="fas fa-upload me-2"></i>Send MRI</a>
                    
                    <a href="home.php"
                        class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i
                            class="fas fa-power-off me-2"></i>Logout</a>
                </div>
            </div>
            <!-- /#sidebar-wrapper -->


            <!-- Page Content -->
            <div id="page-content-wrapper">
                <nav class="navbar navbar-expand-lg navbar-light py-2 px-4" style="background-color: white;">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                        <h2 class="fs-2 m-0">Dashboard</h2>
                    </div>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user me-2"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="#">Profile</a></li>
                                    <li><a class="dropdown-item" href="#">Settings</a></li>
                                    <li><a class="dropdown-item" href="home.php">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav><div class="content-container">
    
        
        <?php
        include 'connect2.php';

        if (isset($_GET['id'])) {
            $doctor_id = $_GET['id'];
            $sql = "SELECT * FROM addpatient WHERE id = $doctor_id";
            $result = mysqli_query($con, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $doctor_email = $row['name'];
                $age = $row['age'];
                $experience = $row['experience'];
            }}
               ?>

              <div class="doctor-details"><h3 style="text-align:center"><i class="fas fa-hospital-user"></i><strong>Patient Form</strong></h3>
                      <p>________________________________________________________________
                      <div class="note-div">
                                <p>"Please ensure the MRI image you upload is clear and of high quality. This is essential for accurate diagnosis and treatment by your doctor."</p>
                            </div>
                    </div>
                    <form method="POST" enctype="multipart/form-data" class="row-md-4">
    <div class="mb-4 row align-items-center">
        
        <label class="col-sm-3 col-form-label">
        <i class="fa fa-stethoscope"></i><strong> Doctor Email:</strong>
        </label>
        <div class="col-sm-9">
            <input type="email" class="form-control" name="doctor" value="<?php echo $doctor_email; ?>" readonly>
        </div>
    </div>
    <div class="mb-4 row align-items-center">
        <label class="col-sm-3 col-form-label">
            <i class="bi bi-envelope-fill"></i><strong> Patient Email:</strong>
        </label>
        <div class="col-sm-9">
            <input type="email" class="form-control" id="patientEmail" name="patient" value="<?php echo $logged_in_patient_email; ?>" readonly>
        </div>
        </div>
    <div class="mb-4 row align-items-center">
        <label class="col-sm-3 col-form-label">
            <i class="bi bi-person-fill"></i><strong>Patient Name:</strong>
        </label>
        <div class="col-sm-9">
            <input type="text" class="form-control"  name="patientname" id="patientname" required >
        </div>
    </div>
    <div class="mb-3 row align-items-center">
        <div class="col-sm-10">
            <div class="input-group">
                <span class="input-group-text"><i class="fa fa-upload" aria-hidden="true"></i></span>
                <input type="file" class="form-control" name="imagefile" id="imagefile" required>
            </div>
        </div>
    </div>
                    <div class="message">
                    <?php echo $message; ?> 
                   </div><div id="btn2">
                    <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block"><i class="bi bi-send"></i>
  Send</button>
                </div></form> 
                
            

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };
    </script>
</body>
</html>