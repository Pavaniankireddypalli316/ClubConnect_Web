<?php
include("stdheader.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <style>
        

        body{
            background-color: #f0f0f0;
        }
        .outside {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            text-align: center;
            position: relative;
        }

        h1 {
            color: #333;
        }

        p {
            color: #555;
            margin: 10px 0;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        a {
            color: white;
            text-decoration: none;
        }

        /* Animation for the button */
        @keyframes breathe {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }

        button:hover {
            animation: breathe 1s infinite;
        }
    </style>
</head>
<body>
    <div class="outside">
    <div class="container">
        <h1>Profile</h1>
        <?php
            // include connection to database
            include("database.php");

            //retrieving the cookie here - created in loginprocess.php
            $userId = $_COOKIE['varus_name']; 

            // Function to fetch user details by ID
            function getUserDetails($conn, $user)
            {
                $query = "SELECT * FROM studentdetails WHERE studentid = '$user'";
                $response = mysqli_query($conn, $query);
                if(mysqli_num_rows($response) > 0)
                {
                    return $response->fetch_assoc();
                }
                return false;
            }

            // Get user details
            $userDetails = getUserDetails($conn, $userId);

            if ($userDetails) {
                // Display user details
                echo "<p>Name: " . $userDetails['name'] . "</p>";
                echo "<p>StudentId: " . $userDetails['studentid'] . "</p>";
                echo "<p>DateofBirth: " . $userDetails['dob'] . "</p>";
                echo "<p>Address: " . $userDetails['address'] . "</p>";
                echo "<p>Mobile Number: " . $userDetails['contact'] . "</p>";
                echo "<p>Email: " . $userDetails['email'] . "</p>";
                
                echo '<button><a href="stdprofileedit.php"> Change Password</a></button>';

            } else {
                echo "<p class='error-message'>User not found.</p>";
            }

            // Close the database connection
            $conn->close();
        ?>
    </div>
    </div>
</body>
</html>
