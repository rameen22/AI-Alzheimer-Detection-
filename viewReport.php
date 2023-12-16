<?php
include 'connect2.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="index2styles.css" >
    <link rel="stylesheet" href="indexStyle.css" />
    <style>*{
    overflow:hidden;}
        </style>
    <link href="index2.html" rel="import" />
    <link href="viewPrescription.php" rel="import" />
    <link href="viewRecord.php" rel="import" />
    <link href="viewReport.php" rel="import" />
    <!--<link href="downloadReport.html" rel="import" />-->
    <link href="home.php" rel="import" />
    <title>View Report</title>
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
                <a href="index2.html" class="list-group-item list-group-item-action bg-transparent second-text active"><i
                        class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="viewPrescription.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-eye me-2"></i>View Priscription</a>
                        <a href="viewRecord.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                            class="fas fa-eye me-2"></i>View Record</a>
                            <a href="viewReport.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                                class="fas fa-eye me-2"></i>View Report</a>
                        <!--<a href="downloadReport.html" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                            class="fas fa-download me-2"></i>Download Report</a>-->
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
           
            <!--<div class="container-fluid px-8 ">
                <div class="row g-2 my-2  ">
                   
                <div class="col-md-5 ">
                    <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                        <div>
                            <h3 class="fs-2 "></h3>
                            <p class="fs-5">Report</p>
                        </div>
                        <i
                            class="fas fa-notes-medical fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                    </div>
                </div>
                </div>-->
                <div class="container-fluid px-8">
                <div class="row g-2 my-2">
                   
                
                </div>
                </div>
            <h2 class="text-center mb-4">Report</h2>                <div class="container my-4">
                <table class="table table-bordered table-striped" style="background-color: white;">
                <thead class="table-dark">
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Doctor Name</th>
                        <th scope="col">Patient Name</th>
                        <th scope="col">Age</th>
                        <th scope="col">Disease</th>
                        <th scope="col">stage</th>
                        <th scope="col">Prescription</th>
                        
                      </tr>
                    </thead>
              
                    <tbody>
              
                      <?php
              
                      $sql = "Select * from prescriptions";
                      $result = mysqli_query($con, $sql);
                      if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                          $id = $row['id'];
                          $doctorname = $row['doctorname'];
                          $patientname = $row['patientname'];
                          $age = $row['age'];
                          $disease = $row['disease'];
                          $stage = $row['stage'];
                          $prescription = $row['prescription'];
                          echo '<tr>
                                                  <th scope="row">' . $id . '</th>
                                                  <td>' . $doctorname . '</td>
                                                  <td>' . $patientname . '</td>
                                                  <td>' . $age . '</td>
                                                  <td>' . $disease. '</td>
                                                  <td>' . $stage. '</td>
                                                  <td>' . $prescription . '</td>
                                            
                                                </tr>';
                        }
                      }
              
              
                      ?>
              
              
              
              
                    </tbody>
                  </table>
                </div>

                
            
                  

                
    <!-- /#page-content-wrapper -->
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