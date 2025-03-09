<?php
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

// Obtener las actividades de los usuarios
$sql = "SELECT ua.*, u.username FROM user_activities ua JOIN usuarios u ON ua.user_id = u.id WHERE ua.activity_type = 'login' ORDER BY ua.activity_date DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$activities = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Actividades</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
  <div class="sidebar">
        <h2>Dashboard</h2>
        <a href="dashboard.php">Inicio</a>
        <a href="user_management.php">Mantenimiento de Usuarios</a>
        <a href="general_query.php">Consulta General</a>
        <a href="activity_report.php" class="active">Reporte de Actividades</a>
        <a href="generate_report.php">Generar Reportes de Fallas</a>
        <a href="../InicioSesion/CerrarSesion.php">Cerrar sesión</a>
    </div>
    <div class="main">
        <h1>Reporte de Actividades</h1>
        <?php if (count($activities) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Tipo de Actividad</th>
                    <th>Descripción</th>
                    <th>Fecha de Actividad</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($activities as $activity) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($activity['username']); ?></td>
                    <td><?php echo htmlspecialchars($activity['activity_type']); ?></td>
                    <td><?php echo htmlspecialchars($activity['description']); ?></td>
                    <td><?php echo htmlspecialchars($activity['activity_date']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>No hay actividades registradas.</p>
        <?php endif; ?>
    </div>
</body>
</html>