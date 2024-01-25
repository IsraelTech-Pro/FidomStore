<?php
include 'config.php';
// Signin process
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Check if the email and password match the database records
  $signinQuery = "SELECT * FROM users WHERE email = ? AND password = ?";
  $stmt = $conn->prepare($signinQuery);
  $stmt->bind_param("ss", $email, $password);
  $stmt->execute();
  $signinResult = $stmt->get_result();

  if ($signinResult->num_rows > 0) {
    // Signin success
    echo 'success';
  } else {
    // Signin failure
    echo 'Invalid email or password.';
  }
}

$conn->close();
?>
