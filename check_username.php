<?php


include 'db.php';

if (isset($_POST['username'])) {
    $username = $conn->real_escape_string($_POST['username']);

    // Query to check if the username exists
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    // Check if the username already exists
    if ($result->num_rows > 0) {
        echo "taken";  // Username is already taken
    } else {
        echo "available";  // Username is available
    }
}

$conn->close();
?>
