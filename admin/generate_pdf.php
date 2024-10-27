<?php
require('./fpdf.php'); // Make sure the path is correct

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Transaction Report', 0, 1, 'C');
        $this->Ln(10);
    }
}

// Start PDF generation
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'I', 12);

// Sample data (you may replace this with your actual data retrieval logic)
$total_deposit = 1000.00; // Example total deposit
$pastDeposits = [200, 300, 500]; // Example past deposits
$labels = ['January', 'February', 'March']; // Example labels

$pdf->Cell(0, 10, 'Total Deposit: ₱' . number_format($total_deposit, 2), 0, 1);
$pdf->Ln(10);
$pdf->Cell(0, 10, 'Past Deposits:', 0, 1);

foreach ($pastDeposits as $index => $amount) {
    $pdf->Cell(0, 10, $labels[$index] . ': ₱' . number_format($amount, 2), 0, 1);
}

// Output the PDF
$pdf->Output('D', 'Transaction_Report.pdf'); // D for download
exit;
?>
