<?php
include_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    $database = new Database();
    $db = $database->getConnection();

    $query = "DELETE FROM usuarios WHERE id = :id";
    $stmt = $db->prepare($query);

    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "Usuario eliminado correctamente.";
    } else {
        echo "Error al eliminar el usuario.";
    }
}
?>