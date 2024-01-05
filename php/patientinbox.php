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

$logged_in_patient_email = $_SESSION['email']; // Retrieve doctor's email from the session

// Define how many records you want to display per page
$records_per_page = 9; // You can adjust this as needed

// Fetch total records
$total_records_query = "SELECT COUNT(*) AS total FROM reports WHERE patient_email = ?";
$stmt_total = $conn->prepare($total_records_query);
$stmt_total->bind_param("s", $logged_in_patient_email);
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
$sql = "SELECT id, doctor_email, patient_name, report, report_date, report_time FROM reports WHERE patient_email = ? LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sii", $logged_in_patient_email, $start_from, $records_per_page);
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

    <link rel="stylesheet" href="indexStyle.css" />
    <link href="index.html" rel="import" />
    <link href="AddNewPatientInfo.php" rel="import" />
    <link href="doctor_inbox.php" rel="import" />
    <link href="uploadMRI.html" rel="import" />
    <link href="GenerateReport.html" rel="import" />
    <link href="viewPrescription.php" rel="import" />

    <link href="home.php" rel="import" />
</head>


<style>
   
        
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

.pagination{
    margin-left: 205px;
}

    
    .download-link {
        margin-right: 5px;

        text-decoration: none;
        padding: 8px 12px;
       /* Blue border */
        border-radius: 4px;
        color: white; /* Blue text color */
        transition: background-color 0.3s ease, color 0.3s ease;
        background-color: #3498db;
        text-transform: uppercase;
margin top: 2px;
    }

    .download-link:hover {
        background-color: green; /* Blue background color on hover */
        color: white; /* White text color on hover */
    }
.btn{
    background-color: #f44336; /* Red */
        color: white;
        padding: 8px 12px;
        margin-right: 5px;
        text-decoration: none;
height: 38px;
        border: none;
        border-radius: 4px;
        transition: background-color 0.3s ease, color 0.3s ease;
        text-transform: uppercase;
}
.btn:hover {
        background-color: black; /* Change to the color you prefer on hover */
        color:white;
    }
    


    </style>
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
                <div class="container mt-2">
    <table class="table">
        <!-- Table header -->
       <thead>
            <tr>
                <th>ID</th>
                <th>Doctor Email</th>
                <th>Date</th>
                <th>Time</th>
                <th>Report</th>

            </tr>
        </thead>
        <tbody>
            <?php
            // Updated SQL query to use LIMIT to fetch records for the current page
            $sql = "SELECT id, doctor_email, patient_name, report, report_date, report_time FROM reports WHERE patient_email = ? LIMIT ?, ?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                // Calculate the starting record for the query based on current page
                $start_from = ($current_page - 1) * $records_per_page;

                $stmt->bind_param("sii", $logged_in_patient_email, $start_from, $records_per_page);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $counter = ($current_page - 1) * $records_per_page + 1;
                
                    while ($row = $result->fetch_assoc()) {
                        $id = $row['id'];

                        $docter_email = $row['doctor_email']; // Fix the variable name here
                        $patient_name = $row['patient_name']; // Fix the variable name here

                        $report = $row['report'];
                        $report_date = $row['report_date'];
                        $report_time = $row['report_time'];
                
                        echo '<tr>
        <td>' . $id . '</td>
        <td>' . $docter_email . '</td>
        <td>' . $report_date . '</td>
        <td>' . $report_time . '</td>
        <td>   
        <a href="download_report.php?id=' . $id . '&doctor_email=' . $docter_email  .  '&patient_name=' . $patient_name .  '&report=' . $report . '&report_date=' . $report_date . '&report_time=' . $report_time . '" class="download-link"><i class="fas fa-download"></i>
        Download Report</a>
        <a href="delinbox.php?deleteid=' . $id . '" class="btn btn-primary">Delete</a>

        </td>
    </tr>';
                    }
                } else {
                    echo '<tr>
                            <td colspan="10">No reports found .</td>
                          </tr>';
                }}
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var el = document.getElementById("wrapper");
    var toggleButton = document.getElementById("menu-toggle");

    toggleButton.onclick = function () {
        el.classList.toggle("toggled");
    };
</script>
<script>
    function replyFunction(email) {
        // Redirect to a reply page or implement the logic for replying to the specific email
        window.location.href = 'reply_page.php?email=' + email; // Redirect to a reply page with the email as a parameter
    }

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