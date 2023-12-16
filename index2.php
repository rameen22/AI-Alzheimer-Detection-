      

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="index2styles.css" />
    <link rel="stylesheet" href="indexStyles.css" />

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
    

        /* Table styles */
        .doctors-list table {
    height: 100px; /* Set a fixed height for the table */
    overflow-y: scroll; /* Always show the scrollbar */
    margin-left: 310px;
    margin-top: 130px;
    width: 600px;
    border-collapse: collapse;
    border-radius: 5px;
    margin-bottom: 20px;
    border-top-left-radius: 10px;
}

    

        .doctors-list th,
        .doctors-list td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .doctors-list th {
            background-color: steelblue;
            color: white;
            font-weight: bold;
        }

        /* Styling alternate rows */
        .doctors-list tbody tr:nth-child(even) {
            background-color: #e0e0e0 ;
        }

        /* Hover effect */
        .doctors-list tbody tr:hover {
            background-color:  #f2f2f2;
            cursor: pointer;
        }.banner{
            background-image: url("consultation-doctor-on-presentation-vector.jpg");
            background-attachment: fixed;
        }
    /* Custom styles for the guidelines div */
    .guidelines-container {
        background-color: #f8f9fa;
        border-radius: 110px;
        padding: 20px;
        margin: 190px;
        padding-left: 85px;


    }

    .guidelines-container h2 {
        color: #333333;
        font-size: 34px;
        margin-bottom: 20px;
        font-family: "Times New Roman", Times, serif;

    }

    .guidelines-content {
        color: #555555;
        font-size: 20px;
        font-family: "Times New Roman", Times, serif;

    }

    .guidelines-content ul {
        padding-left: 20px;
        list-style: none;
    }

    .guidelines-content ul li {
        margin-bottom: 10px;
    }

    .guidelines-content ul li:before {
        content: "\2022"; /* Bullet character */
        color: steelblue; /* Change bullet color */
        font-weight: bold;
        display: inline-block;
        width: 1em;
        margin-left: -1em;
    }
        </style>
    

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
              
                <div class="content-container">
        <!-- Guidelines for patients -->
        <div class="guidelines-container">
            <h2>Guidelines</h2>
            <div class="guidelines-content">
                <h4>Welcome to our platform! Here are some guidelines to help you navigate:</h4>
                <ul>
                <li>Select "Available Doctors" to see the list of doctors available for consultation.</li>
                <li>Choose a doctor from "Available Doctors" to send your MRI .</li>
                    <li>Select "Inbox" to view reports sent by your doctor.</li>
                    <li>For Accurate Results,Upload Clear MRI image</li>

                </ul>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
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