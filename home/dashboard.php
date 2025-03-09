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

// Obtener la cantidad de usuarios por rol
$sql = "SELECT role_id, COUNT(*) as count FROM usuarios GROUP BY role_id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$adminCount = 0;
$userCount = 0;

foreach ($results as $result) {
    if ($result['role_id'] == 1) {
        $adminCount = $result['count'];
    } elseif ($result['role_id'] == 2) {
        $userCount = $result['count'];
    }
}

// Obtener las actividades de los usuarios
$sql = "SELECT activity_type, COUNT(*) as count FROM user_activities GROUP BY activity_type";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$activityResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<script>console.log('Admin Count: " . $adminCount . "');</script>";
echo "<script>console.log('User Count: " . $userCount . "');</script>";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="../jqplot/src/jquery.jqplot.css">
    <style>
        .chart-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 400px;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Dashboard</h2>
        <a href="dashboard.php" class="active">Inicio</a>
        <a href="user_management.php">Mantenimiento de Usuarios</a>
        <a href="general_query.php">Consulta General</a>
        <a href="activity_report.php">Reporte de Actividades</a>
        <a href="generate_report.php">Generar Reportes de Fallas</a>
        <a href="../InicioSesion/CerrarSesion.php">Cerrar sesión</a>
    </div>
    <div class="main">
        <h1>Bienvenido al Dashboard</h1>
        <div class="card">
            <h3>Gráfica de Usuarios</h3>
            <div id="chart1" class="chart-container"></div>
        </div>
        <div class="card">
            <h3>Actividades de Usuarios</h3>
            <div id="chart2" class="chart-container"></div>
        </div>
    </div>
    <script src="../jqplot/src/jquery.min.js"></script>
    <script src="../jqplot/src/jquery.jqplot.js"></script>
    <script src="../jqplot/src/plugins/jqplot.pieRenderer.js"></script>
    <script src="../jqplot/src/plugins/jqplot.canvasTextRenderer.js"></script>
    <script src="../jqplot/src/plugins/jqplot.canvasAxisLabelRenderer.js"></script>
    <script src="../jqplot/src/plugins/jqplot.highlighter.js"></script>
    <script src="../jqplot/src/plugins/jqplot.cursor.js"></script>
    <script>
    $(document).ready(function(){
        var userData = [
            ['Administradores', <?php echo $adminCount; ?>],
            ['Usuarios', <?php echo $userCount; ?>]
        ];
        
        console.log(userData);

        $.jqplot('chart1', [userData], {
            seriesDefaults: {
                renderer: $.jqplot.PieRenderer,
                rendererOptions: {
                    showDataLabels: true,
                    dataLabels: 'value',
                    diameter: 200,
                    padding: 20,
                    margin: 50
                }
            },
            legend: { 
                show: true, 
                location: 's',
                placement: 'outsideGrid' 
            },
            grid: {
                drawGridLines: false,
                gridLineColor: '#FFFFFF',
                background: '#FFFFFF',
                borderColor: '#CCCCCC',
                borderWidth: 0.5,
                shadow: false
            },
            highlighter: {
                show: true,
                useAxesFormatters: false,
                tooltipFormatString: '%s: %d'
            },
            cursor: {
                show: false
            }
        });

        var activityData = [
            <?php 
            foreach ($activityResults as $result) {
                echo "['" . $result['activity_type'] . "', " . $result['count'] . "],";
            }
            ?>
        ];
        
        console.log(activityData);

        $.jqplot('chart2', [activityData], {
            seriesDefaults: {
                renderer: $.jqplot.PieRenderer,
                rendererOptions: {
                    showDataLabels: true,
                    dataLabels: 'value',
                    diameter: 200,
                    padding: 20,
                    margin: 50
                }
            },
            legend: { 
                show: true, 
                location: 's',
                placement: 'outsideGrid' 
            },
            grid: {
                drawGridLines: false,
                gridLineColor: '#FFFFFF',
                background: '#FFFFFF',
                borderColor: '#CCCCCC',
                borderWidth: 0.5,
                shadow: false
            },
            highlighter: {
                show: true,
                useAxesFormatters: false,
                tooltipFormatString: '%s: %d'
            },
            cursor: {
                show: false
            }
        });
    });
    </script>
</body>
</html>