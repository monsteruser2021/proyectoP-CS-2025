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

$users = $pdo->query("SELECT * FROM usuarios")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta General</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap">
</head>
<body>
    <div class="sidebar">
        <h2>Dashboard</h2>
        <a href="dashboard.php">Inicio</a>
        <a href="user_management.php">Mantenimiento de Usuarios</a>
        <a href="general_query.php" class="active">Consulta General</a>
        <a href="activity_report.php">Reporte de Actividades</a>
        <a href="generate_report.php">Generar Reportes de Fallas</a>
        <a href="../InicioSesion/CerrarSesion.php">Cerrar sesión</a>
    </div>
    <div class="main">
        <h1>Consulta General de Usuarios</h1>
        <a href="generate_pdf.php" class="btn-pdf" target="_blank">Reporte PDF</a>
        <div class="card">
            <h3>Usuarios Registrados</h3>
            <table>
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Hobbies</th>
                        <th>Género</th>
                        <th>Rol</th>
                        <th>Biografía</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['dob']) ?></td>
                            <td><?= htmlspecialchars($user['hobbies']) ?></td>
                            <td><?= htmlspecialchars($user['gender']) ?></td>
                            <td><?= htmlspecialchars($user['role_id'] == 1 ? 'Admin' : 'Usuario') ?></td>
                            <td><?= htmlspecialchars($user['bio']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>