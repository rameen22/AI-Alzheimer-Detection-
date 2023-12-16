<?php
require('fpdf186/fpdf.php');

if (
    isset($_GET['id']) &&
    isset($_GET['doctorname']) &&
    isset($_GET['patientname']) &&
    isset($_GET['disease']) &&
    isset($_GET['stage']) &&
    isset($_GET['prescription'])
) {
    $id = $_GET['id'];
    $doctorname = $_GET['doctorname'];
    $patientname = $_GET['patientname'];
    $disease = $_GET['disease'];
    $stage = $_GET['stage'];
    $report = $_GET['prescription'];

    $pdf = new FPDF('P', 'mm', array(210, 250)); // A4 width (210mm) and reduced height (250mm)
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetLineWidth(0.5);
    $pdf->Rect(5, 5, 200, 287);

    // Set background image
    $pdf->Image('finalbg.jpg', 0, 0,  210, 250); // Adjust the image path and dimensions

    // Logo at the top
    $pdf->Image('brain-care-q.png', 10, 10, 55); // Adjust position and size

    // Date and Time row aligned to the right side
    // Modify this part as needed for your specific layout
    $pdf->SetX(10); // Set X position
    $pdf->Cell(0, 10, 'Date: ' . date("Y-m-d") . '       Time: ' . date("h:i:sa"), 0, 1, 'R');

    $pdf->SetLineWidth(0.5);
    $pdf->Cell(190, 0, '', 'T');

    $pdf->Ln(3); // Reduce space between sections
    $pdf->SetX(10); // Set X position

    // Display Doctor Name, Patient Name, and Age in a row with spacing
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(95, 10, 'Patient Name: ' . $patientname, 0, 0, 'L');
    $pdf->Cell(95, 10, 'Doctor Name: ' . $doctorname, 0, 1, 'R');

    $pdf->Ln(5); // Reduce space between sections

    // Rest of your content...
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Prescription:', 0, 1);
    $pdf->Ln(7); // Reduce space between sections

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Disease Detected: ' . $disease, 0, 1, 'L');
    $pdf->Ln(1); // Reduce space between sections

    $pdf->Cell(0, 10, 'Stage: ' . $stage, 0, 1, 'L');
    $pdf->Ln(1); // Reduce space between sections

    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Comments:', 0, 1);
    $pdf->Ln(1); // Reduce space between sections

    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 10, $report);

    $pdf->Output('D', 'alzheimer_report.pdf');
} else {
    // Handle missing data
}
?>