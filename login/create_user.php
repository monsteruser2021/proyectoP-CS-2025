<?php
include_once '../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $dob = $_POST['dob'];
    $preferences = $_POST['preferences'];
    $hobbies = implode(", ", $_POST['hobbies']);
    $gender = $_POST['gender'];
    $bio = $_POST['bio'];

    $database = new Database();
    $db = $database->getConnection();

    $query = "INSERT INTO usuarios (nombre, email, password, fullname, dob, preferences, hobbies, gender, bio) 
              VALUES (:nombre, :email, :password, :fullname, :dob, :preferences, :hobbies, :gender, :bio)";
    $stmt = $db->prepare($query);

    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':fullname', $fullname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':dob', $dob);
    $stmt->bindParam(':preferences', $preferences);
    $stmt->bindParam(':hobbies', $hobbies);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':bio', $bio);

    if ($stmt->execute()) {
        $_SESSION['user'] = $nombre;
        header("Location: ../index.html");
        exit();
    } else {
        echo "<script>alert('Ha ocurrido un error al registrar el usuario.'); window.location.href='registro.html';</script>";
    }
}
?>