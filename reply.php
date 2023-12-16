<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the necessary form fields are set
    if (
        isset($_POST['doctorEmail']) && isset($_POST['patientEmail']) && isset($_POST['patientname'])&&
        isset($_POST['report']) && isset($_POST['date']) && isset($_POST['time'])
    ) {
        // Retrieve form data
        $doctorEmail = $_POST['doctorEmail'];
        $patientEmail = $_POST['patientEmail'];
        $patient_name = $_POST['patientname'];

        $report = $_POST['report'];
        $date = $_POST['date'];
        $time = $_POST['time'];

        // Your database connection code
        $servername = "localhost:3308";
        $username = "root";
        $password = "";
        $db = "website";

        $conn = new mysqli($servername, $username, $password, $db);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL query to insert form data into the database table
        $sql = "INSERT INTO reports (doctor_email, patient_email, patient_name, report, report_date, report_time) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Bind parameters and execute the statement
            $stmt->bind_param("ssssss", $doctorEmail, $patientEmail, $patient_name, $report, $date, $time);
            $stmt->execute();

            // Check if the data was inserted successfully
            if ($stmt->affected_rows > 0) {
                echo "Report submitted successfully!";
                // Redirect to the inbox page or any other page after successful submission
                header("Location: index.html");
                exit();
            } else {
                echo "Error submitting report: " . $stmt->error;
            }
        } else {
            echo "Prepare statement error: " . $conn->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "All form fields are required.";
    }
} else {
    echo "Invalid request!";
}
?>
