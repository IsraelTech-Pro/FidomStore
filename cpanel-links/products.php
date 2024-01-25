<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
  <style>
    /* General styles... */
    table {
      width: 100%;
      border-collapse: collapse;
    }

    table th,
    table td {
      padding: 8px;
      border: 1px solid #ddd;
    }

    /* Updated styles... */
    .body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      min-height: 100vh;
      text-align: center;
    }

    h1 {
      margin-bottom: 20px;
    }

    /* Apply responsive styles for smaller screens */
    @media only screen and (max-width: 600px) {
      table {
        font-size: 12px;
      }
    }
  </style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      // Delete product
      $('.delete-btn').click(function() {
        var productId = $(this).data('id');
        if (confirm('Are you sure you want to delete this product?')) {
          $.ajax({
            url: 'delete_product.php',
            type: 'POST',
            data: { id: productId },
            success: function(response) {
              alert('Product deleted successfully.');
              location.reload();
            },
            error: function(xhr, status, error) {
              console.log(xhr.responseText);
              alert('An error occurred while deleting the product.');
            }
          });
        }
      });
    });
  </script>
</head>
<body>
<?php include 'navbar.php'; ?>

  <div class="body">
  <?php
  include 'config.php';

  // Fetch all products from the database
  $selectQuery = "SELECT * FROM products";
  $result = mysqli_query($conn, $selectQuery);
  ?>

  <div style="overflow-x: auto;">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Price</th>
          <th>Categories</th>
          <th>Description</th>
          <th>Image</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['price']; ?></td>
            <td><?php echo $row['categories']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><img src="data:image/jpeg;base64,<?php echo base64_encode($row['image']); ?>" alt="Product Image" style="max-width: 100px; max-height: 100px;"></td>
            <td>
              <a href="edit_product.php?id=<?php echo $row['id']; ?>">Edit</a>
              <button class="delete-btn" data-id="<?php echo $row['id']; ?>">Delete</button>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <?php
  // Close database connection
  mysqli_close($conn);
  ?>
  </div>
</body>
</html>
