<?php
// Database connection
include 'config.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $productId = $_POST['id'];
  $name = $_POST['name'];
  $price = $_POST['price'];
  $description = $_POST['description'];
  $category = $_POST['category']; // New category value

  // Check if a new image is uploaded
  if ($_FILES['image']['name']) {
    $image = $_FILES['image']['tmp_name'];
    $imageData = addslashes(file_get_contents($image));

    // Update product details and image in the database
    $updateQuery = "UPDATE products SET name='$name', price='$price', description='$description', categories='$category', image='$imageData' WHERE id=$productId";
  } else {
    // Update product details without changing the image
    $updateQuery = "UPDATE products SET name='$name', price='$price', description='$description', categories='$category' WHERE id=$productId";
  }

  if (mysqli_query($conn, $updateQuery)) {
    echo 'Product updated successfully.';
  } else {
    echo 'Failed to update product.';
  }
}

// Close database connection
mysqli_close($conn);
?>
<script>
  $(document).ready(function() {
    // Handle form submission with Ajax
    $('form').submit(function(e) {
      e.preventDefault(); // Prevent regular form submission

      var formData = new FormData(this);

      $.ajax({
        url: 'update_product.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          alert('Product updated successfully.');
          window.location.href = 'products.php'; // Redirect to products.php
        },
        error: function(xhr, status, error) {
          console.log(xhr.responseText);
          alert('Failed to update product.');
        }
      });
    });
  });
</script>
