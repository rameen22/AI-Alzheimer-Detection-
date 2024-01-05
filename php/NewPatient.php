<?php
include 'connect2.php';
// Start the session
session_start();

// Retrieve the doctor's email from the session
$dremail = $_SESSION['email']; 
if(isset($_POST['submit'])){
 
    $name = $_POST['name'];
    $email = $_POST['email'];

    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $inherited = $_POST['inherited'];

    $sql="insert into newpatient(name,Email, age, gender, inherited)
    values('$name' , '$email', '$age','$gender','$inherited')";
    $result=mysqli_query($con,$sql);
    if($result){
        header('location:AddPatientInfo.php');
    }
    else{
        die(mysqli_error($con));
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
    <link href="indexStyle.css" rel="import" />

    <link href="home.php" rel="import" />
    <title>addnew</title>

    <style>
        
        .container {
            max-width: 600px;
            margin: auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .banner{
    background-image: url("brain-model-side-view-brain-mri-imaging-background.jfif");
    background-attachment: fixed;
}
        .form-control {
            border-radius: 0;
        }

        .form-check-label {
            margin-left: 1rem;
        }

        .btn-primary {
            background-color: steelblue;
            border: none;
            border-radius: 50px;
            padding: 10px 30px;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #24537e;
        }

        .btn-container {
            text-align: center;
            margin-top: 20px;
        }

        label {
            font-weight: bold;
        }

        .form-check-input {
            margin-top: 0.25rem;
        }

        .stage-fields {
            display: none;
        }
    </style>
</head>

<body><div class="banner">
    
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
                </nav><br><br>

                <div class="container my-2 addnew" >
    <form id="addpatient" class="input" method="post">

        <div class="row mb-3">
        <h2 class="text-center mb-4"><i class="fas fa-hospital-user"></i>  Add New Patient</h2>

        
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Email:</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" placeholder="Doctor Email" name="email" value="<?php echo $dremail;?>"readonly>
            </div>
        </div>
        <label class="col-sm-2 col-form-label">Name:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Enter Patient Name" name="name" autocomplete="off" required>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Age:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Enter Patient Age" name="age" autocomplete="off"required>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Gender:</label>
            <div class="col-sm-10">
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" id="radio1" name="gender" value="Male">
                    <label class="form-check-label" for="radio1">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" id="radio2" name="gender" value="Female">
                    <label class="form-check-label" for="radio2">Female</label>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label >Does any family member has this disease?</label>
            <div class="col-sm-10">
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" id="radio1" name="inherited" value="Yes">
                    <label class="form-check-label" for="radio1">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" id="radio2" name="inherited" value="No">
                    <label class="form-check-label" for="radio2">No</label>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-12 text-center">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>

    </form>
</div>
    </body></html>