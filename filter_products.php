<?php
include 'config.php';

if (isset($_POST['category'])) {
  $selectedCategory = $_POST['category'];

  // Fetch products from the selected category
  $sql = "SELECT * FROM products WHERE categories = '$selectedCategory'";

  // Execute the SQL query
  $result = mysqli_query($conn, $sql);

  // Generate HTML for the filtered products
  $html = '';
  while ($row = mysqli_fetch_assoc($result)) {
    // Convert BLOB image data to base64
    $imageData = base64_encode($row['image']);

    $html .= '
    <div class="col">
      <div class="card">
        <img height="150px" width="150px" src="data:image/jpeg;base64,'. $imageData .'" alt="Product Image">
        <div class="card-body">
          <div class="body-position">
            <h5 class="card-title">'. $row['name'] .'</h5>
            <p class="card-text">'. $row['description'] .'</p>
            <p class="card-price">GHS'. $row['price'] .'</p>
            <button style="border:none" class="btn add-to-cart" data-product-id="'. $row['id'] .'">Add</button>
            <a style="font-size: 13px;" href="view_productdetails.php?id='. $row['id'] .'" class="btn">View</a>
          </div>
        </div>
      </div>
    </div>
    ';
  }

  // Free the result set
  mysqli_free_result($result);

  // Close the database connection
  mysqli_close($conn);

  // Return the generated HTML
  echo $html;
}
?>
<?php
// Start the session
session_start();

// Here, you would implement your logic to fetch the cart count from your data source.
// This could involve querying a database or retrieving data from a session or cookie, depending on how your cart system is implemented.
// For demonstration purposes, let's assume the cart count is stored in a session variable named 'cart_count'.

$cartCount = isset($_SESSION['cart_count']) ? $_SESSION['cart_count'] : 0;

$response = array(
  'cartCount' => $cartCount
);

// Set the response header to JSON
header('Content-Type: application/json');

// Return the JSON response
echo json_encode($response);
?>
