<?php
include_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];

    $database = new Database();
    $db = $database->getConnection();

    $query = "UPDATE usuarios SET nombre = :nombre, email = :email WHERE id = :id";
    $stmt = $db->prepare($query);

    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':email', $email);

    if ($stmt->execute()) {
        echo "Usuario actualizado correctamente.";
    } else {
        echo "Error al actualizar el usuario.";
    }
}
?>