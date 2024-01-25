<?php
// Start the session
session_start();

// Check if the product ID is provided
if (isset($_POST['id'])) {
  $productId = $_POST['id'];

  // Retrieve the cart items from the session or initialize an empty array
  $cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();

  // Check if the product is already in the cart
  $productExists = false;
  foreach ($cartItems as &$item) {
    if ($item['id'] === $productId) {
      $item['quantity']++;
      $productExists = true;
      break;
    }
  }

  // If the product is not in the cart, add it
  if (!$productExists) {
    $cartItems[] = array(
      'id' => $productId,
      'quantity' => 1
    );
  }

  // Update the cart in the session
  $_SESSION['cart'] = $cartItems;

  // Return a success message
  echo json_encode(array('status' => 'success', 'message' => 'Product added to cart.'));
} else {
  // Return an error message
  echo json_encode(array('status' => 'error', 'message' => 'Product ID not provided.'));
}
