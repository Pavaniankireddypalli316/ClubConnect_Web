<?php 
include("stdheader.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <style>
        /* Add responsive styling */
        body {
            background-color: #fff; /* Set the background color to match the theme */
            font-family: 'Arial', sans-serif;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        h2, h4 {
            color: #c50792; /* Set text color for headers */
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            margin-bottom: 20px;
            border: 2px solid white;
            color: #fff; /* Set text color for table */
            border: 2px solid white; /* Add white color border */
            border-radius: 10px; /* Add border-radius for curves */
            overflow: hidden; /* Hide overflow for curved corners */
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        /* Style table header */
        th {
            background-color: #f4f4f4; /* Set header background color to white */
            color: #ff65a3;
            font-weight: bold;
        }

        /* Style alternate rows */
        tr:nth-child(even) {
            background-color: #e86fb1; /* Set alternate row color */
        }
        tr:nth-child(odd) {
            color: #ef5454; /* Set alternate row color */
        }

        /* Make the table responsive */
        @media (max-width: 768px) {
            table {
                display: block;
            }

            th, td {
                width: 100%;
                display: block;
                text-align: center;
            }

            th {
                background-color: #fff;
                color: #ff65a3;
            }

            tr:nth-child(even) {
                background-color: #e86fb1;
            }
        }

        /* Additional Styles for Buttons */
        form {
            display: inline-block; /* Align buttons horizontally */
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        label {
            font-weight: bold;
            font-size: 14px;
            color: #fff; /* Set label text color */
        }
        .box{
            padding: 0 5px;
        }
    </style>
</head>
<body>
    <h2>Enrollment</h2>
    <h4>Club Events</h4>
    <?php 
        if(isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
    ?>
    <div class="box">
    <table>
        <tr>
            <th>Club Name</th>
            <th>Club ID</th>
            <th>Strength</th>
            <th>Status</th>
        </tr>

        <?php
            include("database.php");

            $sql = "SELECT * FROM courses WHERE coursestatus='ACTIVE'";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);

            if($count > 0) {
                while($row = mysqli_fetch_assoc($res)) {
                    $course_name = $row['coursename'];
                    $course_id = $row['courseid'];
                    $strength = $row['strength'];
                    ?>

                    <tr>
                        <td><?php echo $course_name; ?></td>
                        <td><?php echo $course_id; ?></td>
                        <td><?php echo $strength; ?></td>
                        <td>
                            <?php
                            $studentId = $_COOKIE['varus_name'];
                            $check_query = "SELECT * FROM enrolatt WHERE studentid='$studentId' AND courseid='$course_id'";
                            $check_result = mysqli_query($conn, $check_query);
                            if(mysqli_num_rows($check_result) == 0) {
                                echo '<form action="stdapplication.php" method="POST">
                                    <input type="hidden" name="studentid" value="' . $studentId . '">
                                    <input type="hidden" name="courseid" value="' . $course_id . '">
                                    <input type="hidden" name="coursename" value="' . $course_name . '">
                                    <input type="submit" name="submit" value="Register">
                                </form>';
                            } else {
                                $status_row = mysqli_fetch_assoc($check_result);
                                $status = $status_row['studentstatus'];
                                if($status == "pending") {
                                    echo "<label style='color: orange;'>$status</label>";
                                } elseif($status == "Approved") {
                                    echo "<label style='color: green;'>$status</label>";
                                } elseif($status == "Rejected") {
                                    echo "<label style='color: red;'>$status</label>";
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                } 
            } else {
                echo "<tr><td colspan='12' class='error'>Courses not available right now</td></tr>";
            }
        ?>
    </table>
    </div>
    <?php
        $conn->close();
    ?>
</body>
</html>
