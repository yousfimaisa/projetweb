<?php
require_once(__DIR__ . "/../../libs/fpdf18/fpdf.php");

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Requête SQL
$sql = "SELECT id, nom_campagne, description, cd_promotion, statut FROM campagne_promotionnelle";
$result = $conn->query($sql);

// Création du PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 10);

// --- En-tête personnalisé ---
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetTextColor(0, 102, 204); // Bleu
$pdf->Cell(190, 10, utf8_decode("📋 Liste des Campagnes Promotionnelles"), 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0);
$pdf->Cell(190, 10, "Date: " . date("d/m/Y H:i"), 0, 1, 'R');
$pdf->Ln(5);

// --- En-têtes du tableau ---
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(0, 102, 204); // Bleu
$pdf->SetTextColor(255); // Blanc
$pdf->Cell(15, 10, 'ID', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Nom', 1, 0, 'C', true);
$pdf->Cell(65, 10, 'Description', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Code Promo', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Statut', 1, 1, 'C', true);

// --- Données du tableau ---
$pdf->SetFont('Arial', '', 11);
$pdf->SetTextColor(0);

$fill = false; // alternance de couleurs

while ($row = $result->fetch_assoc()) {
    $y = $pdf->GetY();
    $startX = $pdf->GetX();

    $pdf->SetFillColor($fill ? 230 : 255); // Gris clair / Blanc

    $pdf->Cell(15, 10, $row['id'], 1, 0, 'C', $fill);
    $pdf->Cell(40, 10, utf8_decode($row['nom_campagne']), 1, 0, 'C', $fill);

    // Gestion description avec MultiCell
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell(65, 10, utf8_decode($row['description']), 1, 'L', $fill);
    $pdf->SetXY($x + 65, $y);

    $pdf->Cell(30, 10, utf8_decode($row['cd_promotion']), 1, 0, 'C', $fill);
    $pdf->Cell(30, 10, utf8_decode($row['statut']), 1, 1, 'C', $fill);

    $fill = !$fill;
}

$pdf->Output();

// Fermer connexion
$conn->close();
?>
