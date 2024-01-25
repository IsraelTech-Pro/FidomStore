<?php
// Database connection
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'fidom_db';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die('Connection failed: ' . $conn->connect_error);
}


// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
  $productId = $_POST['id'];

  // Delete the product from the database
  $deleteQuery = "DELETE FROM products WHERE id = $productId";
  if (mysqli_query($conn, $deleteQuery)) {
    echo 'success';
  } else {
    header('HTTP/1.1 500 Internal Server Error');
    echo 'Unable to delete the product.';
  }
}

// Close database connection
mysqli_close($conn);
?>
