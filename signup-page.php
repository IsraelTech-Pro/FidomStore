

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup - E-commerce Store</title>
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
    <h1>Sign Up</h1>
    <form id="signupForm" action="signup.php" method="POST">
      <div class="form-group">
        <label for="fname">Firstname</label>
        <input type="text" id="fname" name="fname" required>
      </div>

      <div class="form-group">
        <label for="sname">Secondname</label>
        <input type="text" id="sname" name="sname" required>
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="form-group">
        <button type="submit">Sign Up</button>
      </div>
    </form>
    <div id="message" class="message"></div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#signupForm').submit(function(e) {
        e.preventDefault();
        var name = $('#fname').val();
        var sname = $('#sname').val();
        var email = $('#email').val();
        var password = $('#password').val();

        $.ajax({
          url: 'signup.php',
          method: 'POST',
          data: {
            fname: name,
            sname: sname,
            email: email,
            password: password
          },
          success: function(response) {
            $('#message').text(response);
            $('#signupForm')[0].reset();
            window.location.href = 'login.php'; // Redirect to the login page
          }
        });
      });
    });
  </script>
</body>
</html>
