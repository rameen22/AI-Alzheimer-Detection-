<?php
session_start();

include 'connect2.php';

// Check if the email is set in the session (for logged-in user)
if (!isset($_SESSION['email'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: login.php"); // Change this to your login page
    exit();
}
$servername = "localhost:3308";
$username = "root";
$password = "";
$db = "website";

$conn = new mysqli($servername, $username, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$logged_in_doctor_email = $_SESSION['email']; // Retrieve doctor's email from the session

// Define the number of results per page
$records_per_page = 8; // You can adjust this as needed

// Fetch total records

$total_records_query = "SELECT COUNT(*) AS total FROM newpatient WHERE email = ?";
$stmt_total = $conn->prepare($total_records_query);
$stmt_total->bind_param("s", $logged_in_doctor_email);
$stmt_total->execute();
$total_result = $stmt_total->get_result();
$total_records = $total_result->fetch_assoc()['total'];


// Calculate total pages
$total_pages = ceil($total_records / $records_per_page);


// Get current page or set a default
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $current_page = $_GET['page'];
} else {
    $current_page = 1; // Default page
}

// Calculate the starting record for the query based on current page
$start_from = ($current_page - 1) * $records_per_page;

// Modify your SQL query to include LIMIT
$sql = "SELECT * FROM newpatient WHERE email = ? LIMIT ?,?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sii", $logged_in_doctor_email, $start_from, $records_per_page);
$stmt->execute();
$result = $stmt->get_result();

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
    <link href="home.php" rel="import" />
    <title>Add Patient Info</title>
</head>
<style>
.banner{
    background-image: url("brain-model-side-view-brain-mri-imaging-background.jfif");
    background-attachment: fixed;}
   

    .table-container{
        width:1200px;
    }
.btn{
    background-color:white;
}

</style>
<body>
<div class="banner">
    
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
                <div class="btn-container">
                                <a href="newpatient.php" 
                                class="btn btn-secondary text-dark newbutton ">Add New Patient</a>
                            </div>
                <div class="table-container">
                <div class="container">
                    <div class="row">
                        <div class="col-md-18">
                          
                                <table class="table table-bordered table-striped" style="background-color: white;">
                                    <thead class="table-gray">
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Name</th>

                                            <th scope="col">Age</th>
                                            <th scope="col">Gender</th>
                                            <th scope="col">Inherited Disease</th>
                                            <th scope="col">Operation</th>
                                        </tr>
                                 
                                    </thead>
                                    <tbody>
                                        <?php

$sql = "SELECT * FROM newpatient WHERE email = ? LIMIT ?, ?";
$stmt = $conn->prepare($sql);
 
 if ($stmt) {
     // Calculate the starting record for the query based on the current page
     $start_from = ($current_page - 1) * $records_per_page;
 
     $stmt->bind_param("sii", $logged_in_doctor_email, $start_from, $records_per_page);
     $stmt->execute();
     $result = $stmt->get_result();
     if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {{

                                                $id = $row['id'];
                                                $name = $row['name'];
                                                $email = $row['email'];

                                                $age = $row['age'];
                                                $gender = $row['gender'];
                                                $inherited = $row['inherited'];
                                                echo '<tr>
                                                            <th scope="row">' . $id . '</th>
                                                            <td>' . $name . '</td>

                                                            <td>' . $age . '</td>
                                                            <td>' . $gender . '</td>
                                                            <td>' . $inherited . '</td>
                                                            <td>
                                                                <a href="updatePatientRec.php?updateid=' . $id . '" class="btn btn-primary" style="background-color: steelblue; border: none;">Update</a>
                                                                <a href="deletePatientRec.php?deleteid=' . $id . '" class="btn btn-primary" style="background-color: red; border: none;">Delete</a>
                                                            </td>
                                                        </tr>';
                                            }
                                        }} else {
                                            echo '<tr>
                                                    <td colspan="10">No records found.</td>
                                                </tr>';
                                        }
                                    } else {
                                        echo 'Prepare statement error: ' . $conn->error;
                                    }
                                    
                                        ?>
                                    </tbody>
                                </table>

                            </div>
                            
         
<!-- Pagination -->
<?php
if ($total_pages > 1) {
    echo '<ul class="pagination">';
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $current_page) {
            echo '<li class="page-item active"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
        } else {
            echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
        }
    }
    echo '</ul>';
}
?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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