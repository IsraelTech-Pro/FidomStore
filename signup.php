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

// Signup process
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fname = $_POST['fname'];
  $sname = $_POST['sname'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Check if the email is already registered
  $checkEmailQuery = "SELECT * FROM users WHERE email = ?";
  $stmt = $conn->prepare($checkEmailQuery);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $checkEmailResult = $stmt->get_result();

  if ($checkEmailResult->num_rows > 0) {
    echo 'Email is already registered.';
  } else {
    // Insert new user into the database
    $insertQuery = "INSERT INTO users (firstname, secondname, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ssss", $fname, $sname, $email, $password);

    if ($stmt->execute()) {
      echo 'Signup successful.';
    } else {
      echo 'Error: ' . $stmt->error;
    }
  }
}

$conn->close();
?>
