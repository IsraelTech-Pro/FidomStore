<?php
include 'config.php';

// Fetch the product data from the database
$category = isset($_POST['category']) ? $_POST['category'] : 'all';

// Add the filtering condition if a specific category is selected
$query = "SELECT * FROM products";
if ($category !== 'all') {
    $query .= " WHERE categories = '$category'";
}

$result = mysqli_query($conn, $query);

// Check for errors in the query execution
if (!$result) {
    die('Error executing the query: ' . mysqli_error($conn));
}

// Fetch the data and store it in an array
$products = array();
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}

// If "All" is selected, select all IDs from the product table
if ($category === 'all') {
    $query = "SELECT id FROM products";
    $idResult = mysqli_query($conn, $query);

    // Check for errors in the query execution
    if (!$idResult) {
        die('Error executing the query: ' . mysqli_error($conn));
    }

    // Fetch the IDs and store them in an array
    $allIDs = array();
    while ($row = mysqli_fetch_assoc($idResult)) {
        $allIDs[] = $row['id'];
    }

    // Shuffle the IDs randomly
    shuffle($allIDs);

    // Get the first 10 IDs from the shuffled array
    $randomIDs = array_slice($allIDs, 0, 10);

    // Fetch the products based on the random IDs
    $randomQuery = "SELECT * FROM products WHERE id IN (" . implode(",", $randomIDs) . ")";
    $randomResult = mysqli_query($conn, $randomQuery);

    // Check for errors in the query execution
    if (!$randomResult) {
        die('Error executing the query: ' . mysqli_error($conn));
    }

    // Fetch the random products and store them in the products array
    $products = array();
    while ($row = mysqli_fetch_assoc($randomResult)) {
        $products[] = $row;
    }
}

// Fetch the unique categories from the products table
$query = "SELECT DISTINCT categories FROM products";
$categoryResult = mysqli_query($conn, $query);

// Check for errors in the query execution
if (!$categoryResult) {
    die('Error executing the query: ' . mysqli_error($conn));
}

// Fetch the categories and store them in an array
$categories = array();
while ($row = mysqli_fetch_assoc($categoryResult)) {
    $categories[] = $row['categories'];
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="images/fidomStore.png" type="image/x-icon">
  <title>E-commerce Homepage</title>
<link rel="stylesheet" href="style.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
   <!-- Navbar -->
   <nav class="navbar">
  <div class="navbar-brand">
    <img src="images/fidomStore.png" alt="fidom-store">
    <a href="index.php" style="text-decoration: none;display:inline-block"> 
    <p style="color:red;display: inline;">Fidom</p>
    <p style="color:blue;display: inline;"> Store</p>
  </a>
    <div class="navbar-menu">
    <a class="cart" href="cart.php"><img src="images/shopping-cart.png" alt=""></a>
    <span class="cart-count" id="cart-count"><!--?php echo $cartCount; ?--></span>
  </div>
  </div>
  <script>
     // Update the cart count on page load
fetchCartCount();

// Function to update the cart count
function updateCartCount(count) {
  $('#cart-count').text(count);
}

// Function to fetch the cart count from the server
function fetchCartCount() {
  $.ajax({
    url: 'fetch_cart_count.php', // Replace with the actual endpoint to fetch the cart count
    method: 'GET',
    dataType: 'json',
    success: function(response) {
      updateCartCount(response.cartCount);
    }
  });
}
  </script>

<!-- Filter Products -->
<div class="container">
  <div class="category-filter">
    <select name="category" id="category" onchange="filterProducts(this.value)">
      <option value="all" <?php if ($category === 'all') { echo 'selected'; } ?>>Categories</option>
      <?php foreach ($categories as $cat) { ?>
        <option value="<?php echo $cat; ?>" <?php if ($cat === $category) { echo 'selected'; } ?>><?php echo $cat; ?></option>
      <?php } ?>
    </select>
  </div>
</div>
</nav>

 <!-- Hero Section -->
  <header class="hero-section">
    <div class="container">
      <h1>Welcome to FidomHub Store</h1>
      <p>Discover amazing products at low prices.</p>
      <a href="tel:+233248145979" class="btn">Contact Us</a>
    </div>
  </header>



<script>
function filterProducts(category) {
  // Check if "All" is selected
  if (category === 'all') {
    console.log("Select All option selected");

    // Update the UI to indicate all products are selected
    var selectAllOption = document.querySelector('#category option[value="all"]');
    selectAllOption.textContent = 'All (Selected)';
  }

  // Create a form element
  var form = document.createElement('form');
  form.method = 'post';
  form.action = 'index.php';

  // Create an input element to hold the selected category
  var input = document.createElement('input');
  input.type = 'hidden';
  input.name = 'category';
  input.value = category;

  // Append the input element to the form
  form.appendChild(input);

  // Append the form to the body and submit it
  document.body.appendChild(form);
  form.submit();
}
</script>



<!--end add category-->

<!--<div class="product-card" data-category="Electronics">-->
  
   <!-- Product Cards -->
    <div class="row" id="filteredProducts">
      <?php foreach ($products as $product) { ?>
      <div class="col">
        <div class="card">
          <img height="150px" width="150px" src="data:image/jpeg;base64,<?php echo base64_encode($product['image']); ?>" alt="Product Image">
          <div class="card-body">
            <div class="body-position">
              <h5 class="card-title"><?php echo $product['name']; ?></h5>
              <p class="card-text"><?php echo $product['description']; ?></p>
              <p class="card-price">GH<img style="height:15px; width: 15px;" src="images/ghana-cedis.png">    <?php echo $product['price']; ?></p>
              <button style=" border:none" class="btn add-to-cart" data-product-id="<?php echo $product['id']; ?>">Add</button>
             <a style="font-size: 13px;" href="view_productdetails.php?id=<?php echo $product['id']; ?>" class="btn">View</a>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>

  <!-- Footer Section code -->
  <!--category  script-->

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var images = [
        'images/img1.jpg',
        'images/img2.jpg',
        'images/img3.jpg'
      ];

      var index = 0;
      var heroSection = document.querySelector('.hero-section');

      function changeImage() {
        heroSection.style.backgroundPosition = '0 -100%';
        setTimeout(function() {
          heroSection.style.backgroundImage = 'url(' + images[index] + ')';
          heroSection.style.backgroundPosition = '0 0';
          index = (index + 1) % images.length;
        }, 500);
      }

      setInterval(changeImage, 2000);
    });
  </script>
  <script>
    $(document).ready(function() {
      // Ajax request to fetch the product data
      $.ajax({
        url: 'fetc_products.php',
        method: 'GET',
        success: function(response) {
          // Append the fetched data to the product cards
          $('.row').html(response);
        }
      });
    });
  </script>
  
 
  <script>
    // Update the cart count on page load
    updateCartCount();

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

          // Update the cart count
          updateCartCount();
        }
      });
    });

    // Function to update the cart count
    function updateCartCount() {
      $.ajax({
        url: 'fetch_cart_count.php',
        method: 'POST',
        dataType: 'json',
        success: function(response) {
          // Update the cart count
          $('#cart-count').text(response.cartCount);
        }
      });
    }
  </script>
<script>
    // Add the following JavaScript
    var prevScrollPos = window.pageYOffset;
    window.onscroll = function() {
      var currentScrollPos = window.pageYOffset;
      var navbar = document.querySelector('.navbar');
      if (prevScrollPos > currentScrollPos) {
        navbar.classList.remove('hide');
      } else {
        navbar.classList.add('hide');
      }
      prevScrollPos = currentScrollPos;
    };
  </script>
</body>
</html>
