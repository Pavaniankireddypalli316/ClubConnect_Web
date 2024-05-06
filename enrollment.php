<?php 
include("stdheader.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
     <style>
        /* Add responsive styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        /* Style table header */
        th {
            background-color: #FF5D4C;
            color: #fff;
        }

        /* Style alternate rows */
        tr:nth-child(even) {
            background-color: #f2f2f2;
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
                background-color: #007BFF;
                color: #fff;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2;
            }
        }
    </style>
</head>
<body>
   <h2>Enrollment</h2><br>
   <p>Club Events</p>
   <?php 
            if(isset($_SESSION['add'])) //Checking whether the SEssion is Set of Not
            {
                echo $_SESSION['add']; //Display the SEssion Message if SEt
                unset($_SESSION['add']); //Remove Session Message
            }
    ?>
   <table>
            <tr>
                <th>CourseName</th>
                <th>CourseId</th>
                <th>Strength</th>
                <th>Status</th>
            </tr>

                <?php
                include("database.php");
                // Get all the courses from the database
                $sql = "SELECT * FROM courses WHERE coursestatus='ACTIVE'";
                // Execute Query
                $res = mysqli_query($conn, $sql);
                // Count the Rows
                $count = mysqli_num_rows($res);

                if($count>0)
                {
                    // Courses available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        // Get all the courses details
                        $course_namee = $row['coursename'];
                        $course_idd = $row['courseid'];
                        $strengthh = $row['strength'];
                        ?>
                        <tr>
                            <td><?php echo $course_namee; ?></td>
                            <td><?php echo $course_idd; ?></td>
                            <td><?php echo $strengthh; ?></td>
                        <!-- Click on register button -->
                        <!-- to find wether the user already registered or not and providing responses -->
                                <td>
                                <?php
                                //take the student id from the cookie
                               //retrieving the cookie here - created in student loginprocess.php
                                $studentId = $_COOKIE['varus_name'];
                                $aa="SELECT * FROM enrolatt
                                    WHERE studentid='$studentId' AND courseid='$course_idd'";

                                $bb=mysqli_query($conn,$aa);
                                if(mysqli_num_rows($bb)==0)
                                {
                                    echo '<form action="stdapplication.php"  method="POST">
                                    <input type="hidden" name="studentid" value="' . $studentId . '">
                                    <input type="hidden" name="courseid" value="' . $course_idd . '">
                                    <input type="hidden" name="coursename" value="' . $course_namee . '">
                                    <input type="submit" name="submit" id="" value="Register">
                                </form>';
                                }
                                else
                                {
                                    $cc=mysqli_fetch_assoc($bb);
                                    $status=$cc['studentstatus'];
                                    // Pending , Rejected and Approved
                                    if($status=="pending")
                                    {
                                        echo "<label style='color: orange;'>$status</label>";
                                    }
                                    elseif($status=="Approved")
                                    {
                                        echo "<label style='color: green;'>$status</label>";
                                    }
                                    elseif($status=="Rejected")
                                    {
                                        echo "<label style='color: red;'>$status</label>";
                                    }
                                }
                                ?>
                                </td>
                        </tr>
                                               
                        <?php
                    } 
                }
                else
                {
                    echo "<tr><td colspan='12' class='error'>Courses not available right now</td></tr>";
                }
            ?>
<?php
$conn->close();
?>

        </table>
</body>
</html>
