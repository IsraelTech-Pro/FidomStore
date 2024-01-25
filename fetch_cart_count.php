<?php
// Start the session
session_start();

// Check if the cart items exist in the session
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
  $cartItems = $_SESSION['cart'];
} else {
  // Set cart count to 0 if cart is empty
  $cartCount = 0;
}

// Calculate the cart count
$cartCount = count($cartItems);

// Return the cart count as a JSON response
$response = array('cartCount' => $cartCount);
echo json_encode($response);
