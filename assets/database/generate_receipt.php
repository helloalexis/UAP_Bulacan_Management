<?php

session_start();
generate_receipt();
function generate_receipt()
{

    require('../fpdf/fpdf.php');

    $member_name = $_SESSION["member_name"];
    $quantity = $_GET["quantity"];
    $membership_fee = $_SESSION["membership_fee"];

    $pdf = new FPDF('P', 'mm', 'A4');
    $pdf->AddPage();

    $logoPath = '../images/logo.png'; // Replace with the actual path to your logo image
    $pdf->Image($logoPath, 10, 10, 26);

    // Set font for organization name
    $pdf->SetFont('Arial', 'B', 16);

    // Organization information
    $pdf->Cell(0, 10, 'UNITED ARCHITECTS OF THE PHILIPPINES', 0, 1, 'C');

    // Switch to normal font for the chapter name

    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 5, 'BULACAN CHAPTER', 0, 1, 'C');

    $pdf->SetFont('Arial', '', 12);
    $text = 'The Integrated and Accredited Professional Organization of Architects';
    $pdf->MultiCell(0, 5, $text, 0, 'C');
    $pdf->Ln(20);

    // Set font for receipt information
    $pdf->SetFont('Arial', '', 12);

    // Receipt information
    $pdf->Cell(0, 10, 'Receipt Number: ' . uniqid(), 0, 1, 'R');

    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 0, 'OFFICIAL RECEIPT', 0, 1, 'L');


    // Date
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Date: ' . date('Y-m-d'), 0, 1, 'R');

    // Set font for member information
    $pdf->SetFont('Arial', '', 12);

    // Member information
    $pdf->Cell(0, 10, 'Member Name: ' . $member_name, 0, 1);

    // Membership type
    $pdf->Cell(0, 10, 'Membership Type: Annual Membership', 0, 1);

    // Membership details
    $quantity = $quantity;

    $pdf->Cell(0, 10, 'Quantity: x' . $quantity, 0, 1);
    $pdf->Cell(0, 10, 'Rate per Year: ' . number_format($membership_fee, 2) . " PHP", 0, 1);
    $pdf->Cell(0, 10, 'Total Membership Fee: ' . number_format($membership_fee * $quantity, 2) . " PHP", 0, 1);

    // Legal text
    $pdf->Ln(10);
    $pdf->SetFont('Arial', '', 10);
    $legalText = "By making this payment, you acknowledge and agree to abide by the terms and conditions set forth by the United Architects of the Philippines. This payment is non-refundable.";
    $pdf->MultiCell(0, 8, $legalText);

    // Thank you message
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Thank you for your continued support!', 0, 1, 'C');

    $date = date('Y-m-d');

    // Output the PDF
    $pdf->Output();

    exit();
}
