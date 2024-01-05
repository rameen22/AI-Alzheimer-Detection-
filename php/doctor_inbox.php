<?php
session_start();

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

// Define how many records you want to display per page
$records_per_page = 10; // You can adjust this as needed

// Fetch total records
$total_records_query = "SELECT COUNT(*) AS total FROM mri_images WHERE doctor_email = ?";
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

// Fetch records for the current page
$sql = "SELECT patient_email, image , patient_name FROM mri_images WHERE doctor_email = ? LIMIT ?, ?";
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
    <link href="AddNewPatientInfo.php" rel="import" />
    <link href="doctor_inbox.php" rel="import" />
    <link href="uploadMRI.html" rel="import" />
    <link href="GenerateReport.html" rel="import" />
    <link href="viewPrescription.php" rel="import" />

    <link href="home.php" rel="import" />
    <title>Doctors Dashboard</title>
</head>


<style>
      .reply-form-container {
        display: none;
        position: fixed;
        width: 700px;
        top: 45%;
        left: 55%;
        transform: translate(-50%, -50%);
        background-color: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.6);
        z-index: 1000;
    }
    .close-icon {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
        size:25px;
    }

    /* Styling for form fields */
    .form-group {
        margin-bottom: 20px;
    }

    /* Style for the form submit button */
    .submit-button {
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        background-color: steelblue;
        color: white;
        transition: background-color 0.3s ease;
        width: 270px;
        margin-left: 170px;

    }
.pagination{
    margin-left: 205px;
}
    .submit-button:hover {
        background-color: #2980b9;
    }
        
.banner{
            background-image: url("depositphotos_.jpg");
            background-attachment: fixed;
        }
    /* Add hover effect to table rows */
    table tbody tr:hover {
        background-color: white;
        cursor: pointer; /* Change cursor on hover */
    }
   
    table tbody{
        background-color:#f5f5f5;
    
    }
            table thead{
        background-color:steelblue;
color:white;
    }
   
table, th, td {
  border: 1px solid #808080
;
  border-collapse: collapse;
}
.inbox-container {

    transition: filter 0.3s ease-in-out;
}

.blur-background {
    /* Apply a blur effect */
    filter: blur(5px); /* Adjust the blur amount as needed */
}

.action-button {
        padding: 8px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        font-size: 14px;
        text-transform: uppercase;
        margin-right: 5px;
    }
    .action-button:hover {
        background-color: black; /* Change to the color you prefer on hover */
    }

    .reply-button {
        background-color: #4caf50;
        color: white;
    
    }
.btn{
    background-color: #f44336; /* Red */
        color: white;
        padding: 8px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        font-size: 14px;
        text-transform: uppercase;
        margin-right: 5px;        
}
.btn:hover {
        background-color: black; /* Change to the color you prefer on hover */
    }
    
    .download-link {
        text-decoration: none;
        padding: 8px 12px;
       /* Blue border */
        border-radius: 4px;
        color: white; /* Blue text color */
        transition: background-color 0.3s ease, color 0.3s ease;
        background-color: #3498db;
    }

    .download-link:hover {
        background-color: black; /* Blue background color on hover */
        color: white; /* White text color on hover */
    }

    </style>
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
           
                <BR>
                <h2 style="text-align:center">INBOX</h2>
                <div class="container mt-2"id="inboxContainer">
    <table class="table">
        <!-- Table header -->
       <thead>
            <tr>
                <th>Record ID</th>
                <th>Patient Email</th>
                <th>Patient Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Updated SQL query to use LIMIT to fetch records for the current page
            $sql = "SELECT id, patient_email, patient_name, image FROM mri_images WHERE doctor_email = ? LIMIT ?, ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    // Calculate the starting record for the query based on the current page
    $start_from = ($current_page - 1) * $records_per_page;

    $stmt->bind_param("sii", $logged_in_doctor_email, $start_from, $records_per_page);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row['id']; // Fetch the ID column
            $patient_email = $row['patient_email'];
            $image_path = $row['image']; // Full path including filename
            $patient_name = $row['patient_name'];



                        echo '<tr>
                                <td>' . $id . '</td>
                                <td>' . $patient_email . '</td>
                                <td>' . $patient_name . '</td>

                                <td>
                                <a href="' . $image_path . '" download="' . basename($image_path) . '" class="download-link"><i class="fas fa-download"></i> Download MRI</a>
                                <button class="action-button reply-button" onclick="openReplyForm(\'' . $patient_email . '\')">Reply</button>

                                <a href="delete_record.php?deleteid=' . $id . '" class="btn btn-primary">Delete</a>
                                </td>
                            </tr>';
                    }
                } else {
                    echo '<tr>
                            <td colspan="10">No MRI images found for this doctor.</td>
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
<div class="reply-form-container" id="replyForm">
<span class="close-icon fa-lg" onclick="closeReplyForm()">&times;</span>
   <strong> <h2 style="text-align:center">      Report</h2></strong>
   <p>___________________________________________________________________________________________________</p>

    <form action="reply.php" method="POST">
        <div class="form-group">
           <strong> <label for="doctorEmail">Doctor Email</label></strong>
            <input type="text" class="form-control" id="doctorEmail" name="doctorEmail" value="<?php echo $logged_in_doctor_email; ?>" readonly>
        </div>
        <div class="form-group">
           <strong> <label for="patientEmail">Patient Email</label></strong>
            <input type="text" class="form-control" id="patientEmail" name="patientEmail" readonly>
        </div>
        <div class="form-group">
           <strong> <label for="patientEmail">Patient Name</label></strong>
            <input type="text" class="form-control" id="patientname" name="patientname"  value="<?php echo $patient_name; ?>" readonly>
        </div>
        <div class="form-group">
            <strong><label for="report">Prescription</label></strong>
            <textarea class="form-control" id="report" name="report" rows="3">Disease Stage: </textarea>
        </div>
        <div class="form-group">
           <strong> <label for="date">Date</label></strong>
            <input type="date" class="form-control" id="date" name="date">
        </div>
        <div class="form-group">
           <strong> <label for="time">Time</label></strong>
            <input type="time" class="form-control" id="time" name="time">
        </div>
        <button type="submit" class="submit-button">Send Report</button>
    </form>
</div>

<script>function openReplyForm(patientEmail) {
    // Show the reply form
    document.getElementById('replyForm').style.display = 'block';

    // Add blur effect to the inbox container
    document.getElementById('inboxContainer').classList.add('blur-background');
    
    // Set the patient email in the form field
    document.getElementById('patientEmail').value = patientEmail;
}

function closeReplyForm() {
    // Hide the reply form
    document.getElementById('replyForm').style.display = 'none';

    // Remove blur effect from the inbox container
    document.getElementById('inboxContainer').classList.remove('blur-background');
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var el = document.getElementById("wrapper");
    var toggleButton = document.getElementById("menu-toggle");

    toggleButton.onclick = function () {
        el.classList.toggle("toggled");
    };
</script>
<script>

    function deleteFunction(email) {
        // Implement the logic to delete the record from the database based on the email
        if (confirm("Are you sure you want to delete this record?")) {
            // Make an AJAX call or redirect to a backend endpoint to delete the record
            window.location.href = 'delete_record.php?email=' + email; // Redirect to a delete endpoint with the email as a parameter
        }
    }
</script>
    </body>

</html>