<?php
include_once '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $fullname = $_POST['fullname'];
    $dob = $_POST['dob'];
    $preferences = $_POST['preferences'];
    $hobbies = implode(", ", $_POST['hobbies']);
    $gender = $_POST['gender'];
    $bio = $_POST['bio'];

    $database = new Database();
    $db = $database->getConnection();

    try {
        $query = "INSERT INTO usuarios (nombre, email, password, fullname, dob, preferences, hobbies, gender, bio) VALUES (:nombre, :email, :password, :fullname, :dob, :preferences, :hobbies, :gender, :bio)";
        $stmt = $db->prepare($query);

        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':dob', $dob);
        $stmt->bindParam(':preferences', $preferences);
        $stmt->bindParam(':hobbies', $hobbies);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':bio', $bio);

        if ($stmt->execute()) {
            session_start();
            $_SESSION['user'] = $nombre;
            header("Location: ../index.html");
            exit();
        } else {
            header("Location: registro.html?error=1");
            exit();
        }
    } catch (PDOException $e) {
        header("Location: registro.html?error=1");
        exit();
    }
}
?>