<?php

require_once '../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $dob = $_POST['dob'];
    $hobbies = implode(',', $_POST['hobbies']);
    $gender = $_POST['gender'];
    $role_id = $_POST['role_id'];
    $bio = !empty($_POST['bio']) ? $_POST['bio'] : null;

    try {
        $connection = new Connection();
        $pdo = $connection->connect();

        $sql = "INSERT INTO usuarios (username, email, password, dob, hobbies, gender, role_id, bio) 
                VALUES (:username, :email, :password, :dob, :hobbies, :gender, :role_id, :bio)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'dob' => $dob,
            'hobbies' => $hobbies,
            'gender' => $gender,
            'role_id' => $role_id,
            'bio' => $bio,
        ]);

        echo "<script>
        alert('Usuario registrado exitosamente');
        window.location.href = '../login.php';
        </script>";

    } catch (\Throwable $th) {
        echo "<script>
        alert('Error al registrar el usuario: " . addslashes($th->getMessage()) . "');
        window.location.href = '../registrarse.php';
        </script>";
    }
}