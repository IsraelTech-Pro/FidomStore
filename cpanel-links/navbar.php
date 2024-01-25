
  <style>
    /* Global Styles */
    
    .containers {
      max-width: 100%;
      margin: 0 auto;
   
    }
    
    /* Navbar Styles */
    .navbar {
      background-color: #333;
      color: #fff;
      padding: 10px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    .navbar ul {
      list-style-type: none;
      display: flex;
    }
    
    .navbar ul li {
      margin-right: 10px;
    }
    
    .navbar ul li a {
      color: #fff;
      text-decoration: none;
      padding: 10px;
      border-radius: 5px;
    }
    
    .navbar ul li a:hover {
      background-color: #555;
    }
    
 
    
    
    /* Responsive Styles */
    @media (max-width: 767px) {
      .navbar {
        flex-direction: column;
      }
    
      .navbar ul {
        margin-top: 10px;
      }
    
      .navbar ul li {
        margin-right: 0;
        margin-bottom: 5px;
      }
    }
  </style>
  <div class="containers">
    <div class="navbar">
      <h1>Admin Panel</h1>
      <ul>
        <li><a href="insert.php">Insert</a></li>
        <li><a href="products.php">Product</a></li>
        <li><a href="#">Orders</a></li>
        <li><a href="#">Customers</a></li>
      </ul>
    </div>
  </div>


