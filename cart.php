<?php

// Start the session
session_start();

// Check if the cart items exist in the session
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
  $cartItems = $_SESSION['cart'];
} else {
  // Redirect to the homepage or display an empty cart message
  header('Location: dashboard.php');
  exit();
}

// Check if the delete button is clicked
if (isset($_POST['delete_button'])) {
  $deleteId = $_POST['delete_item'];
  // Remove the item from the cart
  foreach ($cartItems as $key => $item) {
    if ($item['id'] == $deleteId) {
      unset($cartItems[$key]);
      break;
    }
  }
  // Update the session cart items
  $_SESSION['cart'] = $cartItems;
}

// Fetch the product data from the database
include 'config.php'; 

// Prepare the placeholder string for the product IDs
$placeholders = implode(',', array_fill(0, count($cartItems), '?'));

// Prepare the SQL statement to fetch the products
$query = "SELECT * FROM products WHERE id IN ($placeholders)";
$stmt = $conn->prepare($query);

// Bind the product IDs as parameters
$stmt->bind_param(str_repeat('i', count($cartItems)), ...array_column($cartItems, 'id'));

// Execute the query
$stmt->execute();

// Get the result set
$result = $stmt->get_result();

// Fetch the product data and store it in an array
$products = array();
while ($row = $result->fetch_assoc()) {
  $products[] = $row;
}

// Close the database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart</title>
  <style>
    /* CSS styles for the cart page */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      width: 100%;
    }

    h1 {
      text-align: center;
      margin: 20px 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th,
    td {
      padding: 10px;
      text-align: center;
    }

    th {
      background-color: #f2f2f2;
    }

    tbody tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .quantity-control {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .arrow {
      cursor: pointer;
      font-size: 14px;
      padding: 4px;
    }

    .arrow-up {
      border-bottom: 1px solid #999;
    }

    .arrow-down {
      border-top: 1px solid #999;
    }

    button {
      padding: 6px 12px;
      background-color: #4CAF50;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    tfoot td:last-child {
      font-weight: bold;
    }

    a {
      display: block;
      text-align: center;
      margin-top: 20px;
      text-decoration: none;
      color: #4CAF50;
      font-weight: bold;
    }

    @media only screen and (max-width: 600px) {
      h1 {
        font-size: 24px;
        margin: 10px 0;
      }

      table {
        font-size: 14px;
        overflow-x: auto;
        display: block;
      }

      th,
      td {
        padding: 8px;
        white-space: nowrap;
      }

      .quantity-control {
        flex-direction: column;
        align-items: flex-start;
      }

      .arrow {
        margin: 2px 0;
      }

      a {
        margin-top: 10px;
        font-size: 16px;
      }
    }
    input{
      width: 100%;
    }
  </style>
</head>
<body>
  <!-- Cart page HTML content -->
  <h1>Cart</h1>
  <table>
    <thead>
      <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $total = 0;
      if (!empty($products)) {
        foreach ($products as $product) {
          $cartItem = array_values(array_filter($cartItems, function ($item) use ($product) {
            return $item['id'] == $product['id'];
          }))[0];
          $subtotal = $product['price'] * $cartItem['quantity'];
          $total += $subtotal;
      ?>
          <tr>
            <td><?php echo $product['name']; ?></td>
            <td><?php  echo  $product['price']; ?></td>
            <td class="quantity-control">
              <span class="arrow arrow-up">&#9650;</span>
              <input type="number" min="1" value="<?php echo $cartItem['quantity']; ?>" disabled>
              <span class="arrow arrow-down">&#9660;</span>
            </td>
            <td><?php echo $subtotal; ?></td>
            <td>
              <form method="POST" action="">
                <input type="hidden" name="delete_item" value="<?php echo $product['id']; ?>">
                <button type="submit" name="delete_button">Delete</button>
              </form>
            </td>
          </tr>
      <?php
        }
      } else {
      ?>
        <tr>
          <td colspan="5">No items in the cart</td>
        </tr>
      <?php
      }
      ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="3">Total</td>
        <td><?php echo "GHS " . $total; ?></td>
        <td></td>
      </tr>
    </tfoot>
  </table>
  <a href="checkout.php">Proceed to Checkout</a>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    $(document).ready(function () {
      // Increase quantity
      $('.arrow-up').on('click', function () {
        var input = $(this).siblings('input[type="number"]');
        var quantity = parseInt(input.val());
        input.val(quantity + 1);
        calculateSubtotal(input);
        updateTotal();
      });

      // Decrease quantity
      $('.arrow-down').on('click', function () {
        var input = $(this).siblings('input[type="number"]');
        var quantity = parseInt(input.val());
        if (quantity > 1) {
          input.val(quantity - 1);
          calculateSubtotal(input);
          updateTotal();
        }
      });

      // Calculate and update subtotal
      function calculateSubtotal(input) {
        var price = input.closest('tr').find('td:nth-child(2)').text();
        var quantity = input.val();
        var subtotal = parseFloat(price) * parseInt(quantity);
        input.closest('tr').find('td:nth-child(4)').text(subtotal.toFixed(2));
      }

      // Update total
      function updateTotal() {
        var total = 0;
        $('tbody tr').each(function () {
          var subtotal = parseFloat($(this).find('td:nth-child(4)').text());
          total += subtotal;
        });
        $('tfoot td:last-child').text(total.toFixed(2));
      }
    });
  </script>
</body>
</html>
