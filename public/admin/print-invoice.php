<?php

include "../../server/config.php";
include "../../server/pdf.php";
include "../../server/functions/functions.inc.php";

session_start();

if (isset($_SESSION['admin_id']) == "") {
    if (isset($_SESSION['admin_role']) == "admin") {
        header("Location: categories.php");
    } else {
        header("Location: admin-login.php");
    }
}

if (isset($_GET['id'])) {
    $id = get_safe_value($conn, $_GET['id']);
    $query = mysqli_query($conn, "select * from reparations where id='$id'");

    // Create a PDF instance
    $pdf = new PDF('P', 'mm', "A4");
    $pdf->AddPage();

    while ($data = mysqli_fetch_array($query)) {

        // Add client information
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Cell(0, 10, 'Information du Client', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(40, 10, 'Nom & Prenom:', 0, 0, 'L');
        $pdf->Cell(0, 10, $data["firstname"] . " " . $data["lastname"], 0, 1, 'L');
        $pdf->Cell(40, 10, 'Email:', 0, 0, 'L');
        $pdf->Cell(0, 10, $data["email"], 0, 1, 'L');
        $pdf->Cell(40, 10, 'Telephone:', 0, 0, 'L');
        $pdf->Cell(0, 10, $data["phone"], 0, 1, 'L');
        $pdf->Ln(10);

        // Add product information
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Cell(0, 10, 'Information de la commande', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(40, 10, 'ID:', 0, 0, 'L');
        $pdf->Cell(0, 10, $data["id"], 0, 1, 'L');
        $pdf->Cell(40, 10, 'Marque:', 0, 0, 'L');
        $pdf->Cell(0, 10, $data["brand"], 0, 1, 'L');
        $pdf->Cell(40, 10, 'Modele:', 0, 0, 'L');
        $pdf->Cell(0, 10, $data["model"], 0, 1, 'L');
        $pdf->Cell(40, 10, 'Reparation:', 0, 0, 'L');
        $pdf->Cell(0, 10, $data["type_repear"], 0, 1, 'L');
        $pdf->Cell(40, 10, 'Description:', 0, 0, 'L');
        $pdf->Cell(0, 10, $data["description"], 0, 1, 'L');
        $pdf->Cell(40, 10, 'Paiement:', 0, 0, 'L');
        $pdf->Cell(0, 10, $data["methode_payment"], 0, 1, 'L');
        $pdf->Cell(40, 10, 'Prix:', 0, 0, 'L');
        $pdf->Cell(0, 10, "2000 DA", 0, 1, 'L');
        $pdf->Cell(40, 10, 'Date:', 0, 0, 'L');
        $pdf->Cell(0, 10, $data["created_at"], 0, 1, 'L');
    }

    $pdf->Output();
} else {
    header("Location: facture.php");
}
