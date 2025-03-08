<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script defer src="login.js"></script>
</head>
<body class="pattern login" id="login">
    <!--LOGIN-->
    <div class="content">
        <div class="title"><span>INGRESAR</span></div>
        <form id="loginForm" class="loginForm" action="inicioSesion/inicioSesion.php" method="POST">
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
                <button type="button" class="btn-back">
                    <a href="../index.html">Volver al inicio</a>
                </button>
            </div>
            <div class="signup-link">
                No eres miembro? <a href="signup.php">Regístrate ahora!</a>
            </div>
        </form>
    </div>
</body>
</html>