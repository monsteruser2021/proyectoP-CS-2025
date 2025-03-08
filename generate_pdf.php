<?php
require 'vendor/autoload.php';
include_once 'db.php';

use Dompdf\Dompdf;

$database = new Database();
$db = $database->getConnection();

$query = "SELECT * FROM usuarios";
$stmt = $db->prepare($query);
$stmt->execute();

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$html = '<h1>Lista de Usuarios</h1>';
$html .= '<table border="1" cellpadding="10">';
$html .= '<tr><th>ID</th><th>Nombre</th><th>Email</th></tr>';

foreach ($users as $user) {
    $html .= '<tr>';
    $html .= '<td>' . $user['id'] . '</td>';
    $html .= '<td>' . $user['nombre'] . '</td>';
    $html .= '<td>' . $user['email'] . '</td>';
    $html .= '</tr>';
}

$html .= '</table>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("usuarios.pdf", array("Attachment" => false));
?>