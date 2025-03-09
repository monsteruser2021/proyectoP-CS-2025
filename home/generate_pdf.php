<?php
require_once '../vendor/autoload.php';

use Dompdf\Dompdf;

session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit;
}

// Verifica el rol del usuario
if ($_SESSION['role_id'] !== 1) {
    echo "Acceso denegado. Solo los administradores pueden acceder a esta página.";
    exit;
}

require_once '../config/connection.php';
$connection = new Connection();
$pdo = $connection->connect();

// Obtener datos de la consulta general
$sql = "SELECT * FROM usuarios";  // Cambia esto según tu consulta
$stmt = $pdo->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Crear nuevo PDF
$pdf = new Dompdf();
$html = '<h1>Reporte de Consulta General</h1>';
$html .= '<table border="1" cellspacing="3" cellpadding="4">';
$html .= '<tr><th>ID</th><th>Nombre de Usuario</th><th>Email</th></tr>'; // Ajusta según tu tabla

foreach ($data as $row) {
    $html .= '<tr>';
    $html .= '<td>' . $row['id'] . '</td>';  // Ajusta según tu tabla
    $html .= '<td>' . $row['username'] . '</td>';  // Ajusta según tu tabla
    $html .= '<td>' . $row['email'] . '</td>';  // Ajusta según tu tabla
    $html .= '</tr>';
}

$html .= '</table>';

$pdf->loadHtml($html);
$pdf->setPaper('A4', 'landscape');
$pdf->render();
$pdf->stream('reporte_consulta_general.pdf', ['Attachment' => 0]);
?>