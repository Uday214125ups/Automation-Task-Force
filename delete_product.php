<?php
session_start();
$data = json_decode(file_get_contents("php://input"), true);


include 'db.php';

$id = intval($data['id']);
$table = $_SESSION['login'] . "_products";

$stmt = $conn->prepare("DELETE FROM `$table` WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();
$conn->close();

echo "Deleted successfully.";
?>
