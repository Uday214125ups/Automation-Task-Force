<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dog_images_app";


// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
