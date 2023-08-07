<?php 
require('fpdf.php');

class PDF extends FPDF {
    function Header() {
        // Add your company logo and name here
        $this->Image('../../public/assets/hp.jpg',10,10,30);
        $this->SetFont('Arial', 'B', 25);
        $this->Cell(0, 10, 'Sallahly Company', 0, 1, 'C');

        // Add invoice title and number
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'FACTURE', 0, 1, 'R');
        
        // Line break
        $this->Ln(10);
    }

    function Footer() {
        // Add signature placeholder and company information
        $this->SetY(-40);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Signature: ______________________', 0, 1, 'L');
        $this->Cell(0, 10, 'Merci pour votre confiance!', 0, 0, 'C');
        $this->Cell(0, 10, 'Contacter nous: contact@sallahly.dz', 0, 0, 'R');
    }
}