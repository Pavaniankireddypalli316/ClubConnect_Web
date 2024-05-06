<?php
include("facheader.php");
include("database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
    <h5>Update Password</h5>
    <?php
    //retrieving the cookie here - created in loginprocess.php
        $userId = $_COOKIE['varus_name'];
    //function to change password
    function updateUserDetails($conn, $userId, $password)
            {
                $query = "UPDATE facultydetails SET password = '$password' WHERE facultyid = '$userId'";
                return $conn->query($query);
            }
    // Display update form
                echo "<form method='POST' action=''>
                       <h6>Password<h6><br>
                        <input type='password' name='passw' placeholder='Name'><br>
                        <h6>confirm Password</h6>
                        <input type='password' name='conpassw'  placeholder='Address'><br>
                       <br><input type='submit' name='update' value='Update'></br>
                      </form>";

                // Process form submission
                if (isset($_POST['update'])) {
                    $password = $_POST['passw'];
                    $conformpassword = $_POST['conpassw'];
                    //to check wether the password and conform new password both are same or not
                    if($conformpassword==$password)
                    {
                        // Update user details
                    if (updateUserDetails($conn, $userId, $password)) {
                        echo "<p class='success-message'>Password details updated successfully.</p>";
                       } else {
                        echo "<p class='error-message'>Failed to update user details.</p>";
                       }
                    }
                    else
                    {
                        echo "New-Password and Conform-New-Password should be same";
                    }
                }
             else {
                echo "<p class='error-message'>.</p>";
            }

            // Close the database connection
            $conn->close();
    ?>
</body>
</html>