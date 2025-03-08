<?php
include_once 'db.php';

$database = new Database();
$db = $database->getConnection();

$query = "SELECT * FROM usuarios";
$stmt = $db->prepare($query);
$stmt->execute();

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($users);
?>