<?php
include("stdheader.php");
include("database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            width: 400px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-container h5,
        .form-container h6 {
            margin-bottom: 10px;
        }
        .form-container input[type="password"] {
            width: 100%;
            margin-bottom: 10px;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .form-container input[type="submit"] {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: none;
            background-color: #FF5D4C;
            color: white;
            cursor: pointer;
        }
        .form-container input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: red;
        }
        .success-message {
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h5>Change Password</h5>
            <?php
            //retrieving the cookie here - created in loginprocess.php
            $userId = $_COOKIE['varus_name'];
            
            //function to change password
            function updateUserDetails($conn, $userId, $password)
            {
                $query = "UPDATE studentdetails SET password = '$password' WHERE studentid = '$userId'";
                return $conn->query($query);
            }

            // Display update form
            echo "<form method='POST' action=''>
                    <h6>Password</h6>
                    <input type='password' name='passw' placeholder='Password'><br>
                    <h6>Confirm Password</h6>
                    <input type='password' name='conpassw' placeholder='Confirm Password'><br>
                    <br>
                    <input type='submit' name='update' value='Update'>
                  </form>";

            // Process form submission
            if (isset($_POST['update'])) {
                $password = $_POST['passw'];
                $conformpassword = $_POST['conpassw'];
                //to check whether the password and confirm new password are the same or not
                if ($conformpassword == $password) {
                    // Update user details
                    if (updateUserDetails($conn, $userId, $password)) {
                        echo "<p class='success-message'>Password details updated successfully.</p>";
                    } else {
                        echo "<p class='error-message'>Failed to update user details.</p>";
                    }
                } else {
                    echo "<p class='error-message'>New Password and Confirm Password should be the same.</p>";
                }
            }

            // Close the database connection
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
