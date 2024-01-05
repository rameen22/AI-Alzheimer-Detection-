<?php

include 'connect2.php';

// Define the number of results per page
$resultsPerPage = 11;

// Fetch total records
$totalRecordsQuery = "SELECT COUNT(*) AS total FROM addpatient";
$totalResult = mysqli_query($con, $totalRecordsQuery);
$totalRecords = mysqli_fetch_assoc($totalResult)['total'];

// Calculate total pages
$totalPages = ceil($totalRecords / $resultsPerPage);

// Determine the current page number
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $currentPage = (int)$_GET['page'];
} else {
    $currentPage = 1;
}

// Calculate the starting row number for the SQL LIMIT clause
$startFrom = ($currentPage - 1) * $resultsPerPage;

// Modify your SQL query to include LIMIT
$sql = "SELECT * FROM addpatient LIMIT $startFrom, $resultsPerPage";

$result = mysqli_query($con, $sql);
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
    <link href="index2.php" rel="import" />
    <link href="viewPrescription.php" rel="import" />
    <link href="viewRecord.php" rel="import" />
    <link href="viewReport.php" rel="import" />
   <!-- <link href="downloadReport.html" rel="import" />-->
    <link href="home.php" rel="import" />
    <title>Patients Dashboard</title>
</head>
<style>      
.banner{
            background-image: url("depositphotos_.jpg");
            background-attachment: fixed;
        }
.container{
    text-align:center;
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
    
.btn {
        padding: 8px 12px;
        border: none;
        border-radius: 4px;
        background-color: #3498db;
        cursor: pointer;
        transition: background-color 0.3s ease;
        font-size: 14px;
        text-transform: uppercase;
        margin-right: 5px;
        color: white;

    }
    .btn:hover {
        background-color: green; /* Change to the color you prefer on hover */
        color: white;

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

                <!-- Doctor Selection Table -->
                <div class="container mt-4">
                    <table class="table table-bordered " >
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Dr.Name</th>

                                <th scope="col">Email</th>
                                <th scope="col">Experience</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include 'connect2.php';

                            $sql = "SELECT * FROM addpatient LIMIT $startFrom, $resultsPerPage";
                            $result = mysqli_query($con, $sql);
                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $id = $row['id'];
                                    $drname = $row['drname'];

                                    $name = $row['name'];
                                    $age = $row['age'];
                                    $experience = $row['experience'];

                                    echo '<tr>
                                            <th scope="row">' . $id . '</th>
                                            <td>' . $drname . '</td>
                                            <td>' . $name . '</td>
                                            <td>' . $experience . '</td>
                                            <td>
                                                <a href="doctor_details.php?id=' . $id . '" class="btn ">Select Doctor</a>
                                            </td>
                                        </tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php
            if ($totalPages > 1) {
                echo '<ul class="pagination">';

                for ($page = 1; $page <= $totalPages; $page++) {
                    if ($page == $currentPage) {
                        echo '<li class="page-item active"><a class="page-link" href="?page=' . $page . '">' . $page . '</a></li>';
                    } else {
                        echo '<li class="page-item"><a class="page-link" href="?page=' . $page . '">' . $page . '</a></li>';
                    }
                }
            

            echo '</ul>';
}?>
                

            

                <!-- Doctor Details and Forms -->
                <div class="container mt-4">
                    <?php
                    include 'connect2.php';

                    if (isset($_GET['id'])) {
                        $doctor_id = $_GET['id'];

                        $sql = "SELECT * FROM addpatient WHERE id = $doctor_id";
                        $result = mysqli_query($con, $sql);
                        if ($result) {
                            $doctor_details = mysqli_fetch_assoc($result);
                            // Display the doctor's details here
                        }

                        echo '<div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Upload MRI</h5>
                                    <form action="upload_mri.php" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="doctor_id" value="' . $doctor_id . '">
                                        <div class="mb-3">
                                            <label for="mriFile" class="form-label">Select MRI File</label>
                                            <input type="file" class="form-control" id="mriFile" name="mri_file">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Upload MRI</button>
                                    </form>
                                </div>
                            </div>';

                        echo '<div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Fee Payment</h5>
                                    <form action="process_fee_payment.php" method="post">
                                        <input type="hidden" name="doctor_id" value="' . $doctor_id . '">
                                        <div class="mb-3">
                                            <label for="paymentAmount" class="form-label">Payment Amount</label>
                                            <input type="text" class="form-control" id="paymentAmount" name="payment_amount" placeholder="Enter Payment Amount">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Pay Fee</button>
                                    </form>
                                </div>
                            </div>';
                    }
                    ?>
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
