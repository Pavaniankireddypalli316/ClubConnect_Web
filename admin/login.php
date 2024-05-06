<?php include('../config/constants.php'); ?>

<!DOCTYPE html>
<html>
<head>
  <title>ClubEvents-Admin Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Space Grotesk', sans-serif;
            background-image: url("bunchppl.jpg");
            background-size: cover; /* Cover the entire background */
            background-position: center; /* Center the background image */
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .inside {
            text-align: center;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .logo {
            width: 100px;
            margin-bottom: 20px;
        }

        .box {
            margin-top: 20px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ff94d1; /* Light pink border color */
            border-radius: 5px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: none;
            border-radius: 5px;
            background-color: #ff4588; /* Dark pink button color */
            color: #fff;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #ff2f66; /* Change color on hover */
        }
    </style>
</head>

<body>
  <div class="login-container">
    <div class="login">
      <?php 
      if (isset($_SESSION['login'])) {
          echo $_SESSION['login'];
          unset($_SESSION['login']);
      }

      if (isset($_SESSION['no-login-message'])) {
          echo $_SESSION['no-login-message'];
          unset($_SESSION['no-login-message']);
      }
      ?>
      <br>

      <!-- Login Form Starts Here -->
      
        <div class="inside">
            <br><img class="logo" src="logo.png" alt="logo"></br>
      <form action="" method="POST" class="">
        <div class="form-group">
          <br>
          <label for="username">Admin Id</label>
          <input type="text" class="form-control" name="username" id="username" placeholder="Enter ID" required>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" required>
        </div>

        <button type="submit" name="submit">Login</button>
      </form>
      <!-- Login Form Ends Here -->

    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php 

//CHeck whether the Submit Button is Clicked or NOt
if (isset($_POST['submit'])) {
    //Process for Login
    //1. Get the Data from Login form
    // $username = $_POST['username'];
    // $password = md5($_POST['password']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);

    $raw_password = $_POST['password'];
    $password = mysqli_real_escape_string($conn, $raw_password);

    //2. SQL to check whether the user with username and password exists or not
    $sql = "SELECT * FROM admin WHERE username='$username' AND Password='$password'";

    //3. Execute the Query
    $res = mysqli_query($conn, $sql);

    //4. Count rows to check whether the user exists or not
    $count = mysqli_num_rows($res);

    if ($count == 1) {
        //User Available and Login Success
        $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
        $_SESSION['user'] = $username; //To check whether the user is logged in or not and logout will unset it

        //Redirect to Home Page/Dashboard
        header('location:' . SITEURL . 'admin/');
    } else {
        //User not Available and Login Fail
        $_SESSION['login'] = "<div class='error text-center'>Username or Password did not match.</div>";
        //Redirect to Home Page/Dashboard
        header('location:' . SITEURL . 'admin/login.php');
    }
}

?>
