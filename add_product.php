<?php
session_start();

include 'db.php'; // connection to your DB

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['product_name'];
    $price = $_POST['product_price'];
    $desc = $_POST['product_description'];
    $link = $_POST['product_image_link'];
    $cat = $_POST['cataegory'];

    $stmt = $conn->prepare("INSERT INTO ".$_SESSION['login']."_products (title, price, description,category,image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sdsss", $name, $price, $desc,$cat,$link);

    if ($stmt->execute()) {
        header("Location: dashboard.php?status=success");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
header("Location:login_products.php");
}
?>
