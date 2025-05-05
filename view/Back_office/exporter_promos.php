<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../libs/fpdf18/fpdf.php';

// Connexion à la base de données
$db = config::getConnexion();
$req = $db->query("SELECT * FROM promotions");
$promos = $req->fetchAll();

// Création du PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 10);

// En-tête
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetTextColor(0, 102, 204);
$pdf->Cell(0, 10, utf8_decode('📋 Liste des Promotions'), 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0);
$pdf->Cell(0, 10, "Date d'export : " . date("d/m/Y H:i"), 0, 1, 'R');
$pdf->Ln(5);

// En-têtes de colonnes
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(0, 102, 204); // Bleu
$pdf->SetTextColor(255); // Blanc
$pdf->Cell(40, 10, 'Code', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Date Debut', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Date Fin', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Valeur', 1, 1, 'C', true);

// Données
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0);

$fill = false;
foreach ($promos as $promo) {
    $pdf->SetFillColor($fill ? 240 : 255); // Alternance gris clair / blanc
    $pdf->Cell(40, 10, utf8_decode($promo['code_promotion']), 1, 0, 'C', $fill);
    $pdf->Cell(50, 10, $promo['date_debut'], 1, 0, 'C', $fill);
    $pdf->Cell(50, 10, $promo['date_fin'], 1, 0, 'C', $fill);
    $pdf->Cell(30, 10, $promo['valeur'] . '%', 1, 1, 'C', $fill);
    $fill = !$fill;
}

// Exporter le fichier
$pdf->Output('D', 'promotions.pdf'); // D = téléchargement
