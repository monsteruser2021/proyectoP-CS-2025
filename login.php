<?php
session_start();
require_once 'config/connection.php';

$connection = new Connection();
$pdo = $connection->connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role_id'] = $user['role_id'];
        $_SESSION['user_id'] = $user['id'];

        // Registrar la actividad de inicio de sesión
        $sql = "INSERT INTO user_activities (user_id, activity_type, description) VALUES (:user_id, 'login', 'El usuario ha iniciado sesión.')";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user['id']);
        $stmt->execute();

        // Redirigir según el rol del usuario
        if ($user['role_id'] == 1) {
            header('Location: home/dashboard.php'); // Admin
        } else {
            header('Location: home/vitalMind.php'); // Usuario regular
        }
        exit;
    } else {
        echo "Credenciales incorrectas.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script defer src="login.js"></script>
    <style>
        /* Estilo personalizado para el acordeón */
        #accordion h3 {
            background-color: white;
            border: 1px solid #ddd;
            padding: 10px;
            font-size: 1em;
            cursor: pointer;
            font-weight: normal;
            margin: 0;
            color: black; /* Siempre negro */
        }

        #accordion h3.ui-accordion-header-active {
            background-color: #f0f0f0;
        }

        #accordion div {
            border: 1px solid #ddd;
            border-top: none;
            padding: 10px;
            color: black; /* Siempre negro */
        }

        .faq-container {
            margin-top: 20px;
        }
    </style>
</head>
<body class="pattern login" id="login">
    <!--LOGIN-->
    <div class="content">
        <div class="title"><span>INGRESAR</span></div>
        <form id="loginForm" class="loginForm" action="login.php" method="POST">
            <div class="item">
                <i class="fa-solid fa-user"></i>
                <input type="text" id="username" name="username" placeholder="Ingrese su usuario" required>
            </div>
            <div class="item">
                <i class="fa-solid fa-key"></i>
                <input type="password" id="password" name="password" placeholder="Ingrese su contraseña" required>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn" value="Ingresar">Iniciar sesión</button>
            </div>
            <div class="signup-link">
                No eres miembro? <a href="signup.php">Regístrate ahora!</a>
            </div>
        </form>
        
        <div id="faq" class="faq-container">
            <h3>Preguntas Frecuentes</h3>
            <div id="accordion" class="faq">
                <h3>¿Debo estar registrado para poder ingresar?</h3>
                <div>
                    <p>Si, solo tendrás acceso si te registras primero.</p>
                </div>
                <h3>¿A quién está dirigido la página?</h3>
                <div>
                    <p>A todas aquellas personas que quieran aprender sobre la salud mental.</p>
                </div>
                <h3>¿Cómo apoyar la página?</h3>
                <div>
                    <p>¡Comparte nuestra página en tus redes sociales!</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $("#accordion").accordion();
        });
    </script>
</body>
</html>