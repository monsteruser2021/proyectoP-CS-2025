<?php
include_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];

    $database = new Database();
    $db = $database->getConnection();

    $query = "SELECT * FROM usuarios WHERE id = :id";
    $stmt = $db->prepare($query);

    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo json_encode($user);
    } else {
        echo "Usuario no encontrado.";
    }
}
?>