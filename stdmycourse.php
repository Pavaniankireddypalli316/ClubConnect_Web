<?php 
include("stdheader.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<style>
    .heading{
        margin: 20px 0;
        justify-content: center;
        display: flex;
        align-items: center;
    }
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
            background-color: #aa1dbc;
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
    <div class="heading">
   <h2>My Clubs</h2><br>
   </div>
   <table>
            <tr>
                <th>ClubName</th>
                <th>ClubCode</th>
                <th>Status</th>
                <th>Feedback</th>
            </tr>

<?php
include("database.php");
//retrieving the cookie here - created in student loginprocess.php
$userId = $_COOKIE['varus_name']; 
//using the userId retraving all the courses he studied
$sql="SELECT * FROM enrolatt WHERE studentid='$userId'";
//excute query
$res=mysqli_query($conn,$sql);
//count
$count=mysqli_num_rows($res);
                if($count>0)
                {
                    // Courses available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        // Get all the courses details
                        $course_namee = $row['coursename'];
                        $course_idd = $row['courseid'];
                        $courstatus = $row['coursestatus'];
                        $coursegrade = $row['grade'];
                        ?>
                        <tr>
                            <td><?php echo $course_namee; ?></td>
                            <td><?php echo $course_idd; ?></td>
                            <td><?php echo $courstatus; ?></td>
                            <td><?php echo $coursegrade; ?></td>
                        </tr>                        
                        <?php
                    } 
                }
                else
                {
                    // no courses completed till now 
                    echo "<tr><td colspan='12' class='error'>Courses not available right now</td></tr>";
                }
                $conn->close();
?>

    </table>
</body>
</html>