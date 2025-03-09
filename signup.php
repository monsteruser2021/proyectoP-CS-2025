<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script defer src="registro.js"></script>
</head>
<body class="pattern login" id="register">
    <!--REGISTER-->
    <div class="content">
        <div class="title"><span>REGISTRARSE</span></div>
        <form id="registerForm" class="registerForm" method="POST" action="inicioSesion/registrarse.php">
            <div class="item">
                <i class="fa-solid fa-signature"></i>
                <input type="text" id="username" name="username" placeholder="Ingrese su usuario" required>
            </div>
            <div class="item">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" id="email" name="email" placeholder="Ingrese su email" required>
            </div>
            <div class="item">
                <i class="fa-solid fa-key"></i>
                <input type="password" id="password" name="password" placeholder="Ingrese su contraseña" required>
            </div>
            <div class="item">
                <i class="fa-solid fa-key"></i>
                <input type="password" name="confirm_password" placeholder="Confirme su contraseña" required>
            </div>
            <div class="item">
                <label for="birthdate">Fecha de Nacimiento:</label>
                <input type="text" id="birthdate" name="dob" placeholder="Ingrese su fecha de nacimiento" required>
            </div>
            <div class="item">
                <label>¿Cuáles son tus hobbies?</label>
                <div>
                    <input type="checkbox" id="hobby1" name="hobbies[]" value="lectura" class="checkbox">
                    <label for="hobby1">Lectura</label>
                </div>
                <div>
                    <input type="checkbox" id="hobby2" name="hobbies[]" value="deporte" class="checkbox">
                    <label for="hobby2">Deporte</label>
                </div>
                <div>
                    <input type="checkbox" id="hobby3" name="hobbies[]" value="musica" class="checkbox">
                    <label for="hobby3">Música</label>
                </div>
            </div>
            <div class="select">
                <label>Género:</label>
                <div>
                    <input type="radio" id="gender_male" name="gender" value="masculino" required>
                    <label for="gender_male">Masculino</label>
                </div>
                <div>
                    <input type="radio" id="gender_female" name="gender" value="femenino" required>
                    <label for="gender_female">Femenino</label>
                </div>
                <div>
                    <input type="radio" id="gender_other" name="gender" value="otro" required>
                    <label for="gender_other">Otro</label>
                </div>
            </div>
            <div class="item">
                <label for="role_id">Rol:</label>
                <select id="role_id" name="role_id" required>
                    <option value="" disabled selected>Seleccione una opción</option>
                    <option value="1">Admin</option>
                    <option value="2">Usuario</option>
                </select>
            </div>
            <div class="item">
                <i class="fa-solid fa-pen"></i>
                <textarea name="bio" placeholder="Ingrese una breve biografía (opcional)"></textarea>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn" id="submitBtn">
                    Registrarse
                </button>
            </div>
            <div class="signup-link">
                Ya eres miembro? <a href="login.php">Inicia sesión ahora!</a>
            </div>
        </form>
    </div>

    <script>
        $(function() {
            $("#birthdate").datepicker({
                dateFormat: "yy-mm-dd"
            });
        });
    </script>
</body>
</html>