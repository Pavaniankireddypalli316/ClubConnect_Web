<?php 

    include('../config/constants.php'); 
    include('login-check.php');

?>



<html>
<head>
    <title>Club Events</title>
    <link rel="stylesheet" href="../css/admin.css">

    <style>
        /* Add your custom CSS styles here */

        /* Styles for larger screens */
        @media screen and (min-width: 768px) {
            /* Adjust the menu layout for larger screens */
            .menu ul {
                display: flex;
                justify-content: space-between;
            }
            .menu li {
                display: inline-block;
            }
        }

        /* Styles for smaller screens */
        @media screen and (max-width: 767px) {
            /* Adjust the menu layout for smaller screens */
            .menu ul {
                flex-direction: column;
            }
            .menu li {
                display: block;
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>
    <!-- Menu Section Starts -->
    <div class="menu text-center">
        <div class="wrapper">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="managestudent.php">Manage Students</a></li>
                <li><a href="managefaculty.php">Manage Faculty</a></li>
                <li><a href="mmanagecourse.php">Manage Clubs</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>

