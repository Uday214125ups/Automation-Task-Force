<?php
session_start();
// Database connection
$servername = "localhost"; // Change this if necessary
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "dog_images_app"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}




// Query to fetch data
$sql = "insert into users values('".$_POST['email']."','".$_POST['username']."','".$_POST['password']."')"; 
$result = $conn->query($sql);



// Create table if not exists
$conn->query("
CREATE TABLE IF NOT EXISTS ".$_POST['username']."_products (
    id INT PRIMARY KEY auto_increment,
    title VARCHAR(255),
    price DECIMAL(10,2),
    description TEXT,
    category VARCHAR(100),
    image TEXT
)auto_increment = 20
");

// Fetch product data from Fake Store API
$apiUrl = "https://fakestoreapi.com/products";
$response = file_get_contents($apiUrl);
$products = json_decode($response, true);

if (is_array($products)) {
    foreach ($products as $product) {
        $id = $conn->real_escape_string($product['id']);
        $title = $conn->real_escape_string($product['title']);
        $price = $conn->real_escape_string($product['price']);
        $description = $conn->real_escape_string($product['description']);
        $category = $conn->real_escape_string($product['category']);
        $image = $conn->real_escape_string($product['image']);

        // Insert or update product
        $sql = "REPLACE INTO ".$_POST['username']."_products (id, title, price, description, category, image)
                VALUES ('$id', '$title', '$price', '$description', '$category', '$image')";
        $conn->query($sql);
    }

    echo json_encode([
        "status" => "success",
        "message" => "Products updated successfully.",
        "count" => count($products)
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to fetch product data."
    ]);
}




$_SESSION['signup']=true;
header("Location:lists.php");
          
                
?>
