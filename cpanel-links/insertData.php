<?php
// Database configuration
// Database connection
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'fidom_db';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die('Connection failed: ' . $conn->connect_error);
}

$name = $_POST['name'];
$price = $_POST['price'];
$description = $_POST['description'];
$category = $_POST['category'];
$image = $_FILES['image']['tmp_name'];

// Read the file contents
$imageData = file_get_contents($image);

// Escape special characters in the file data
$imageData = $conn->real_escape_string($imageData);

$sql = "INSERT INTO products (name, price, description, categories, image) VALUES ('$name', '$price', '$description', '$category', '$imageData')";

if ($conn->query($sql) === TRUE) {
    echo "Product added successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
