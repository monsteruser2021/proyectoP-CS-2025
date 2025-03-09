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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $report_title = $_POST['report_title'];
    $report_description = $_POST['report_description'];
    $admin_id = $_SESSION['user_id'];

    $sql = "INSERT INTO admin_reports (admin_id, report_name, report_data) VALUES (:admin_id, :report_title, :report_description)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':admin_id', $admin_id);
    $stmt->bindParam(':report_title', $report_title);
    $stmt->bindParam(':report_description', $report_description);

    if ($stmt->execute()) {
        echo "Reporte generado exitosamente!";
    } else {
        echo "Error al generar el reporte.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Reportes de Fallas</title>
    <link rel="stylesheet" href="dashboard.css">
    <style>
        .form-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px auto;
            width: 80%;
            max-width: 600px;
            display: flex;
            flex-direction: column;
            align-items: center; /* Centrar horizontalmente */
        }

        .form-container .item {
            margin-bottom: 15px;
            text-align: left;
            width: 100%; /* Hacer que los elementos hijos tomen todo el ancho del contenedor */
        }

        .form-container .item label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-container .item input, .form-container .item textarea {
            width: 100%; /* Hacer que los inputs y textareas tomen todo el ancho del contenedor */
        }

        .form-container .btn-group {
            text-align: center;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Dashboard</h2>
        <a href="dashboard.php">Inicio</a>
        <a href="user_management.php">Mantenimiento de Usuarios</a>
        <a href="general_query.php">Consulta General</a>
        <a href="activity_report.php">Reporte de Actividades</a>
        <a href="generate_report.php" class="active">Generar Reportes de Fallas</a>
        <a href="../InicioSesion/CerrarSesion.php">Cerrar sesión</a>
    </div>
    <div class="main">
        <h1>Generar Reportes de Fallas</h1>
        <div class="form-container">
            <form method="POST">
                <div class="item">
                    <label for="report_title">Título del Reporte:</label>
                    <input type="text" id="report_title" name="report_title" required>
                </div>
                <div class="item">
                    <label for="report_description">Descripción de la Falla:</label>
                    <textarea id="report_description" name="report_description" rows="10" required></textarea>
                </div>
                <div class="btn-group">
                    <button type="submit" class="btn">Generar Reporte</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>