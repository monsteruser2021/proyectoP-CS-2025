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

$searchResult = [];
$searchMessage = '';
$editUser = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $dob = $_POST['dob'];
        $hobbies = $_POST['hobbies'];
        $gender = $_POST['gender'];
        $role_id = $_POST['role_id'];
        $bio = $_POST['bio'];

        $sql = "INSERT INTO usuarios (username, email, password, dob, hobbies, gender, role_id, bio) VALUES (:username, :email, :password, :dob, :hobbies, :gender, :role_id, :bio)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $username, 'email' => $email, 'password' => $password, 'dob' => $dob, 'hobbies' => $hobbies, 'gender' => $gender, 'role_id' => $role_id, 'bio' => $bio]);
    } elseif ($action === 'edit') {
        $user_id = $_POST['user_id'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $role_id = $_POST['role_id'];

        $sql = "UPDATE usuarios SET username = :username, email = :email, role_id = :role_id WHERE id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $username, 'email' => $email, 'role_id' => $role_id, 'user_id' => $user_id]);
    } elseif ($action === 'delete') {
        $user_id = $_POST['user_id'];

        $sql = "DELETE FROM usuarios WHERE id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
    } elseif ($action === 'search') {
        $username = $_POST['username'];
        $sql = "SELECT * FROM usuarios WHERE username LIKE :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => '%' . $username . '%']);
        $searchResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($searchResult)) {
            $searchMessage = "No se encontró ningún usuario.";
        }
    } elseif ($action === 'show_edit_form') {
        $user_id = $_POST['user_id'];
        $sql = "SELECT * FROM usuarios WHERE id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        $editUser = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

$users = $pdo->query("SELECT * FROM usuarios")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento de Usuarios</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap">
</head>
<body>
    <div class="sidebar">
        <h2>Dashboard</h2>
        <a href="dashboard.php">Inicio</a>
        <a href="user_management.php">Mantenimiento de Usuarios</a>
        <a href="general_query.php">Consulta General</a>
        <a href="../InicioSesion/CerrarSesion.php">Cerrar sesión</a>
    </div>
    <div class="main">
        <h1>Mantenimiento de Usuarios</h1>
        <div class="card">
            <h3>Incluir Usuario</h3>
            <form method="POST">
                <input type="hidden" name="action" value="add">
                <input type="text" name="username" placeholder="Usuario" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <input type="date" name="dob" placeholder="Fecha de Nacimiento" required>
                <input type="text" name="hobbies" placeholder="Hobbies" required>
                <input type="text" name="gender" placeholder="Género" required>
                <select name="role_id" required>
                    <option value="1">Admin</option>
                    <option value="2">Usuario</option>
                </select>
                <textarea name="bio" placeholder="Biografía"></textarea>
                <button type="submit">Incluir</button>
            </form>
        </div>
        <div class="card">
            <h3>Buscar Usuario</h3>
            <form method="POST">
                <input type="hidden" name="action" value="search">
                <input type="text" name="username" placeholder="Buscar por nombre de usuario" required>
                <button type="submit">Buscar</button>
            </form>
            <?php if ($searchMessage): ?>
                <p><?= htmlspecialchars($searchMessage) ?></p>
            <?php endif; ?>
        </div>
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
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $displayUsers = (!empty($searchResult)) ? $searchResult : $users;
                    foreach ($displayUsers as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['dob']) ?></td>
                            <td><?= htmlspecialchars($user['hobbies']) ?></td>
                            <td><?= htmlspecialchars($user['gender']) ?></td>
                            <td><?= htmlspecialchars($user['role_id'] == 1 ? 'Admin' : 'Usuario') ?></td>
                            <td><?= htmlspecialchars($user['bio']) ?></td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <input type="hidden" name="action" value="show_edit_form">
                                    <button type="submit">Editar</button>
                                </form>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <button type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php if ($editUser): ?>
            <div class="card">
                <h3>Editar Usuario</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="user_id" value="<?= htmlspecialchars($editUser['id']) ?>">
                    <input type="text" name="username" value="<?= htmlspecialchars($editUser['username']) ?>" placeholder="Usuario" required>
                    <input type="email" name="email" value="<?= htmlspecialchars($editUser['email']) ?>" placeholder="Email" required>
                    <select name="role_id" required>
                        <option value="1" <?= $editUser['role_id'] == 1 ? 'selected' : '' ?>>Admin</option>
                        <option value="2" <?= $editUser['role_id'] == 2 ? 'selected' : '' ?>>Usuario</option>
                    </select>
                    <button type="submit">Guardar Cambios</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>