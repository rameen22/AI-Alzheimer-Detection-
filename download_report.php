<?php
require('fpdf186/fpdf.php');

function formatReport($text, $wordsPerLine) {
    $words = explode(' ', $text);
    $lines = [];
    $currentLine = '';

    foreach ($words as $word) {
        $currentLine .= $word . ' ';

        if (str_word_count($currentLine) >= $wordsPerLine) {
            $lines[] = trim($currentLine);
            $currentLine = '';
        }
    }

    if (!empty($currentLine)) {
        $lines[] = trim($currentLine);
    }

    return $lines;
}

if (isset($_GET['doctor_email']) && isset($_GET['patient_name']) && isset($_GET['report']) && isset($_GET['report_date']) && isset($_GET['report_time'])) {
    $doctor_email = $_GET['doctor_email'];
    $patient_name = $_GET['patient_name'];

    $report = $_GET['report'];
    $report_date = $_GET['report_date'];
    $report_time = $_GET['report_time'];

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
    $pdf->SetX(10); // Set X position
    $pdf->Cell(0, 10, 'Date: ' . $report_date . '       Time: ' . $report_time, 0, 1, 'R');

    $pdf->SetLineWidth(0.5);
    $pdf->Cell(190, 0, '', 'T');

    $pdf->Ln(3); // Reduce space between sections
    // Display Doctor Name, Patient Name, and Age in a row with spacing
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(95, 10, 'Patient Name: ' . $patient_name, 0, 0, 'L');
    $pdf->Cell(95, 10, 'Doctor Email: ' . $doctor_email, 0, 1, 'R');

    // Report content aligned to the right side
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Prescription:', 0, 1);
    $pdf->Ln(5); // Reduce space between sections

    $pdf->SetFont('Arial', '', 12);

    // Format report content to have 6 words per line
    $formattedReport = formatReport($report, 10);
    foreach ($formattedReport as $line) {
        $pdf->MultiCell(0, 10, $line);
    }

    $pdf->Output('D', 'alzheimer_report.pdf');
} else {
    // Handle missing data
}
?>