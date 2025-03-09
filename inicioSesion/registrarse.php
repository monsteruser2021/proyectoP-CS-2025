<?php
require_once '../config/connection.php';

try {
    $connection = new Connection();
    $pdo = $connection->connect();

    // Obtener los datos del formulario
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $dob = $_POST['dob'];
    $hobbies = isset($_POST['hobbies']) ? implode(',', $_POST['hobbies']) : '';
    $gender = $_POST['gender'];
    $role_id = $_POST['role_id'];
    $bio = $_POST['bio'];

    // Insertar los datos en la base de datos
    $sql = "INSERT INTO usuarios (username, email, password, dob, hobbies, gender, role_id, bio) VALUES (:username, :email, :password, :dob, :hobbies, :gender, :role_id, :bio)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':dob', $dob);
    $stmt->bindParam(':hobbies', $hobbies);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':role_id', $role_id);
    $stmt->bindParam(':bio', $bio);

    if ($stmt->execute()) {
        echo "Registro exitoso!";
        // Redirigir a la página de inicio de sesión u otra página
        header('Location: ../login.php');
    } else {
        echo "Error al registrar el usuario.";
    }
} catch (PDOException $e) {
    echo "Error al registrar el usuario: " . $e->getMessage();
}
?>