<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In - E-commerce Store</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .container {
      max-width: 400px;
      margin: 50px auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .form-group input {
      width: 95%;
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
  <div class="container">
    <h1>Sign In</h1>
    <form id="signinForm" action="" method="POST">
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="form-group">
        <button type="submit">Sign In</button>
      </div>
    </form>
    <div id="message" class="message"></div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#signinForm').submit(function(e) {
        e.preventDefault();
        var email = $('#email').val();
        var password = $('#password').val();

        $.ajax({
          url: 'signin.php',
          method: 'POST',
          data: {
            email: email,
            password: password
          },
          success: function(response) {
            if (response === 'success') {
              window.location.href = 'cpanel.php'; // Replace with the desired redirect URL
            } else {
              $('#message').text(response);
            }
          }
        });
      });
    });
  </script>
</body>
</html>
