<?php
require_once('../connexion/connexion.php');
require_once('../vendor/autoload.php');

use Dompdf\Dompdf;

$req = $connexion->query("
    SELECT b.id, b.code, b.date, b.statut, a.titre AS activite, v.nom AS visiteur
    FROM billet b
    JOIN activite a ON b.activite = a.id
    JOIN vente ve ON b.vente = ve.id
    JOIN visiteur v ON ve.visiteur = v.id
    WHERE b.statut = 'valide'
");

$html = '
<h2 style="text-align:center;">🎫 Rapport des billets vendus</h2>
<table border="1" cellspacing="0" cellpadding="6" width="100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Code</th>
            <th>Date</th>
            <th>Activité</th>
            <th>Visiteur</th>
        </tr>
    </thead>
    <tbody>';

$i = 1;
while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
    $html .= "<tr>
        <td>{$i}</td>
        <td>{$row['code']}</td>
        <td>{$row['date']}</td>
        <td>{$row['activite']}</td>
        <td>{$row['visiteur']}</td>
    </tr>";
    $i++;
}
$html .= '</tbody></table>';

// Génération du PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("rapport_billets_vendus.pdf", ["Attachment" => false]);
exit;
