<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Product</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f8f8;
    }

    .container {
      max-width: 500px;
      margin: 50px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .form-group input[type="text"],
    .form-group input[type="number"],
    .form-group input[type="file"],
    .form-group textarea,
    .form-group select {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border-radius: 4px;
      border: 1px solid #ccc;
    }

    .form-group button {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      font-weight: bold;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .form-group button:hover {
      background-color: #0056b3;
    }

    .message {
      margin-top: 20px;
      font-weight: bold;
      color: red;
    }
  </style>
</head>
<body>
  <div>
    <?php include 'navbar.php'; ?>
    <div class="container">
      <h1>Add Product</h1>
      <form id="productForm" action="insertData.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="name">Product Name</label>
          <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
          <label for="price">Price</label>
          <input type="number" id="price" name="price" required>
        </div>
        <div class="form-group">
          <label for="description">Product Description</label>
          <textarea id="description" name="description" required></textarea>
        </div>
        <div class="form-group">
          <label for="category">Category</label>
          <select id="category" name="category" required>
            <option value="">Select Category</option>
            <option value="category1">Category 1</option>
            <option value="category2">Category 2</option>
            <option value="category3">Category 3</option>
            <!-- Add more options as needed -->
          </select>
        </div>
        <div class="form-group">
          <label for="image">Main Card Image</label>
          <input type="file" id="image" name="image" required>
        </div>
        <div class="form-group">
          <label for="images">Product Images</label>
          <input type="file" id="images" name="images[]" multiple required>
        </div>
        <div class="form-group">
          <button type="submit">Add Product</button>
        </div>
      </form>
      <div id="message" class="message"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      $(document).ready(function() {
        $('#productForm').submit(function(e) {
          e.preventDefault();
          var formData = new FormData(this);

          $.ajax({
            url: 'insertData.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
              $('#message').text(response);
              $('#productForm')[0].reset();
            }
          });
        });
      });
    </script>
  </body>
</html>
