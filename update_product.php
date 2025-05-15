<?php
$input = json_decode(file_get_contents("php://input"), true);

if (!$input || !isset($input['id'])) {
    http_response_code(400);
    echo "Invalid input.";
    exit;
}

$id = intval($input['id']);
$title = $input['title'];
$price = floatval($input['price']);
$description = $input['description'];
$category = $input['category'];


include 'db.php';

$sql = "UPDATE products SET title = ?, price = ?, description = ?, category = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sdssi", $title, $price, $description, $category, $id);

if ($stmt->execute()) {
    echo "Product updated successfully.";
} else {
    http_response_code(500);
    echo "Failed to update product.";
}

$stmt->close();
$conn->close();
?>
