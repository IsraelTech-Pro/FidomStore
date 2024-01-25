<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Product</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
    }

    h1 {
      margin-bottom: 20px;
      text-align: center;
    }

    form {
      max-width: 400px;
      margin: 20px auto; /* Center the form horizontally */
    }

    label {
      display: block;
      margin-bottom: 10px;
    }

    input[type="text"],
    input[type="number"],
    textarea,
    input[type="file"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      resize: vertical;
    }

    input[type="submit"] {
      display: block;
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #45a049;
    }

    .preview-image {
      max-width: 200px;
      max-height: 200px;
      margin-bottom: 10px;
    }
    </style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      // Handle form submission
      $('form').submit(function(e) {
        e.preventDefault(); // Prevent regular form submission

        var form = $(this);
        var formData = new FormData(form[0]);

        // Update product details via Ajax
        $.ajax({
          url: 'update_product.php',
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {
            alert('Product updated successfully.');
            window.location.href = 'products.php';
          },
          error: function(xhr, status, error) {
            console.log(xhr.responseText);
            alert('Failed to update product.');
          }
        });
      });
    });
  </script>
</head>
<body>
  <?php
  // Database connection
  include 'config.php';

  // Fetch product details from the database
  $productId = $_GET['id'] ?? null;
  if ($productId) {
    $selectQuery = "SELECT * FROM products WHERE id = $productId";
    $result = mysqli_query($conn, $selectQuery);
    $product = mysqli_fetch_assoc($result);

    if (!$product) {
      echo 'Product not found.';
      exit;
    }
  } else {
    echo 'Product ID not provided.';
    exit;
  }

// Fetch categories from the database
$categoryQuery = "SELECT DISTINCT categories FROM products";
$categoryResult = mysqli_query($conn, $categoryQuery);
$categories = mysqli_fetch_all($categoryResult, MYSQLI_ASSOC);

  ?>

  <h1>Edit Product</h1>

  <form enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?php echo $product['name']; ?>">

    <label for="price">Price:</label>
    <input type="number" id="price" name="price" value="<?php echo $product['price']; ?>">

    <label for="category">Category:</label>
<select id="category" name="category">
  <?php foreach ($categories as $category): ?>
    <option value="<?php echo $category['categories']; ?>" <?php if ($category['categories'] == $product['categories']) echo 'selected'; ?>>
      <?php echo $category['categories']; ?>
    </option>
  <?php endforeach; ?>
</select>


    <label for="description">Description:</label>
    <textarea id="description" name="description" rows="4" cols="50"><?php echo $product['description']; ?></textarea>

    <label for="image">Image:</label>
    <img src="data:image/jpeg;base64,<?php echo base64_encode($product['image']); ?>" alt="Product Image" class="preview-image">
    <input type="file" id="image" name="image">

    <input type="submit" value="Update Product">
  </form>

  <?php
  // Close database connection
  mysqli_close($conn);
  ?>
</body>