<?php
include 'config.php'; 
// Get the product ID from the URL parameter
$productId = $_GET['id'];

// Fetch the product data from the database
$productQuery = "SELECT * FROM products WHERE id = $productId";
$productResult = mysqli_query($conn, $productQuery);
$product = mysqli_fetch_assoc($productResult);

// Fetch the related images from the product_images table
$imageQuery = "SELECT * FROM product_images WHERE product_id = $productId";
$imageResult = mysqli_query($conn, $imageQuery);
$images = mysqli_fetch_all($imageResult, MYSQLI_ASSOC);


// Handle adding a product to the cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $productId = $_POST['id'];

  // Retrieve the cart items from the session or initialize an empty array
  $cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();

  // Check if the product is already in the cart
  $productExists = false;
  foreach ($cartItems as $item) {
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
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Details</title>
  <style>
    /* General styles */
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: Arial, sans-serif;
    }

    /* Rest of the styles... */

    .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
    }

    .product-image {
      text-align: center;
      margin-bottom: 20px;
    }

    .product-image img {
      max-width: 100%;
      height: auto;
    }

    .product-title {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 10px;
      text-align: center;
    }

    .product-price {
      font-size: 18px;
      font-weight: bold;
      color:black;
      margin-bottom: 10px;
      text-align: center;
    }

    .product-description {
      margin-bottom: 10px;
      text-align: center;
    }

    .related-images {
      margin-top: 20px;
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
    }

    .related-images img {
      display: block;
      max-width: 200px;
      height: auto;
      margin: 10px;
    }
    .h2{
      text-align: center;
    }
    .btn {
    position: relative;
    align-items: center;
    display: inline-block;
    background-color: #007bff;
    color: #fff;
    left: 43%;
    right: 43%;
    padding: 5px;
    border-radius: 4px;
    text-decoration: none;
    transition: background-color 0.3s;
}

    .btn:hover {
      background-color: #0056b3;
    }
  </style>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
  <script>
    $(document).ready(function() {
      // AJAX call to load the related images
      $.ajax({
        url: 'getRelatedImages.php',
        method: 'GET',
        data: { id: <?php echo $productId; ?> },
        dataType: 'json',
        success: function(response) {
          var imagesHtml = '';
          response.forEach(function(image) {
            imagesHtml += '<a href="data:image/jpeg;base64,' + image.image + '" data-lightbox="related-images" data-title="Related Image"><img src="data:image/jpeg;base64,' + image.image + '" alt="Related Image"></a>';
          });
          $('.related-images').html(imagesHtml);
        },
        error: function(xhr, status, error) {
          console.log(xhr.responseText);
        }
      });
    });
  </script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      // Add to cart button click event
      $('.add-to-cart').click(function() {
        var productId = $(this).data('product-id');

        // Ajax request to add the product to the cart
        $.ajax({
          url: 'add_to_cart.php',
          method: 'POST',
          data: { id: productId },
          dataType: 'json',
          success: function(response) {
            // Display a success message
            alert(response.message);
          }
        });
      });
    });
  </script>
</head>
<body>
  <div class="container">
    <div class="product-image">
      <img src="data:image/jpeg;base64,<?php echo base64_encode($product['image']); ?>" alt="Product Image">
    </div>
    <h1 class="product-title"><?php echo $product['name']; ?></h1>
    <p class="product-price">GH<img style="height:15px; width: 15px;" src="images/ghana-cedis.png"> <?php echo $product['price']; ?></p>
    <p class="product-description"><?php echo $product['description']; ?></p>
    <button class="btn add-to-cart" data-product-id="<?php echo $product['id']; ?>">Add to cart</button>
    <h2 class="h2">Related Images</h2>
    <div class="related-images">
      <?php foreach ($images as $image): ?>
        <a href="data:image/jpeg;base64,<?php echo base64_encode($image['image']); ?>" data-lightbox="related-images" data-title="Related Image"><img src="data:image/jpeg;base64,<?php echo base64_encode($image['image']); ?>" alt="Related Image"></a>
      <?php endforeach; ?>
    </div>
  </div>
</body>
</html>
