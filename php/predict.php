<?php
$message = ''; // Initialize an empty message variable
$result = ''; // Initialize an empty result variable

// Check if a POST request was made
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $target_dir = "images/"; 
    $target_file = $target_dir . basename($_FILES["imagefile"]["name"]); // Path to the uploaded file
    $uploadOk = 1; 
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // Get the file extension

    // Check if image file is an actual image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["imagefile"]["tmp_name"]); // Get image information
        if ($check !== false) {
            $uploadOk = 1; // File is an image
        } else {
            $message = "File is not an image.";
            $uploadOk = 0; // File is not an image, set upload status to fail
        }
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $message = "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["imagefile"]["tmp_name"], $target_file)) {
            $image_path = $target_file; // Path to the uploaded image

            $reference_mri_path = 'mildDem15.jpg';

            // Execute a Python script passing image paths as arguments and capture the result
            $result = exec("python model.py \"$image_path\" \"$reference_mri_path\"");
            // $result contains the output or result from your Python script
        } else {
            $message = "File upload failed.";
        }
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
    <link rel="stylesheet" href="indexStyle.css" />
    <link href="index.html" rel="import" />
    <link href="AddPatientInfo.php" rel="import" />
    <link href="prescriptionform.php" rel="import" />
    <link href="uploadMRI.html" rel="import" />
    <link href="GenerateReport.html" rel="import" />
    <link href="viewPrescription.php" rel="import" />

    <link href="home.php" rel="import" />
    <title>Doctors Dashboard</title><style>
    .attractive-div {
        background-color: #ffffff;
        border: 1px solid #ccc;
        margin-top: 50px;
        border-radius: 10px;
        padding: 20px;
        width: 580px;
        margin-left: 250px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
    
    .div-title {
        color: #333333;
        font-size: 24px;
        margin-bottom: 10px;
        float: left;
    }
    
    .result-content {
        color: #555555;
        font-size: 18px;
    }
   
        .attractive-div {
            background-color: #ffffff;
            border: 1px solid #ccc;
            margin-top: 50px;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .div-title {
            color: #333333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .result-content {
            color: #555555;
            font-size: 20px;
            margin-bottom: 15px;
        }
        .banner{
            background-image: url("brain-model-side-view-brain-mri-imaging-background.jfif");
            background-attachment: fixed;
        }
    </style>
</head>
    
   


<body>

    
    <div class="banner">
        <div class="d-flex" id="wrapper">
            <!-- Sidebar -->
            <div class="bg-white" id="sidebar-wrapper">
                <div class="navbar navbar-expand-lg navbar-light py-2 px-4">
                    <img style="width: 200px; height: 30px; " src="brain-care-q.png" class="logo">
                </div>
                <div class="list-group list-group-flush my-3">
                    <a href="index.html" class="list-group-item list-group-item-action bg-transparent second-text active"><i
                            class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="AddNewPatientInfo.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                        
                        <i class="fas fa-user me-2"></i>Profile</a>
                    <a href="doctor_inbox.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                            class="fa fa-envelope me-2"></i>Inbox</a>
                            
                            <a href="NewPatient.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                                class="fas fa-plus me-2"></i>Add Patient</a>
                            <a href="AddPatientRecord.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                                class="fas fa-plus me-2"></i>Add Patient Record</a>
                               
                    <a href="uploadMRI.html" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                            class="fas fa-upload me-2"></i>Upload MRI & Generate Report</a>
                    <a href="home.php" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i
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
                </nav>
                <<div class="attractive-div">
        <h1 class="div-title"> Result</h1>
<br><br>
        <div id="result">
            <?php
            if (!empty($result)) {
                echo "<h3 class='result-content'> $result</h3>";
            } elseif (!empty($message)) {
                echo "<h3 class='result-content'>$message</h3>";
            }
            ?>
        </div>

        <!-- Optional: Add icons for a professional look -->
        <div class="text-muted">
            <p><i class="fas fa-calendar-day"></i> <?php echo date('Y-m-d'); ?></p>        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>