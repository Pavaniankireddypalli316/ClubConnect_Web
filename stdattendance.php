<?php 
include("stdheader.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
    .content{
        color: #c50792;
        margin: 10px 0;
        align-items: center;
        display: flex;
        justify-content: center;
    }
    /* Add responsive styling */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add box shadow for a lifted effect */
        border-radius: 8px; /* Add border-radius for rounded corners */
        overflow: hidden; /* Hide overflowing content */
    }

    th, td {
        padding: 15px; /* Increase padding for better spacing */
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    /* Style table header */
    th {
        background-color: #3498db; /* Change header color */
        color: #fff;
    }

    /* Style alternate rows */
    tr:nth-child(even) {
        background-color: #ecf0f1; /* Change alternate row color */
    }

    /* Make the table responsive */
    @media (max-width: 768px) {
        table {
            display: block;
            overflow-x: auto; /* Enable horizontal scroll for small screens */
        }

        th, td {
            width: auto;
            display: block;
            text-align: center;
            box-sizing: border-box; /* Include padding and border in the width */
        }

        tr:nth-child(even) {
            background-color: #f5f5f5; /* Adjust alternate row color for small screens */
        }
    }
</style>

</head>
<body>
    <div class="content">
   <h2>Attendence</h2><br>
</div>
   <div class="content">
   <h4>Clubdetails</h4><br>
</div>
   <table>
            <tr>
                <th>ClubName</th>
                <th>ClubCode</th>
                <th>ClassesAttended</th>
                <th>TotalClasses</th>
                <th>Percentage</th>
            </tr>

<?php
include("database.php");
//retrieving the cookie here - created in student loginprocess.php
$userId = $_COOKIE['varus_name']; 
//using the userId retraving all the courses he studied
$sql="SELECT * FROM enrolatt WHERE studentid='$userId' AND coursestatus='ACTIVE' AND studentstatus = 'Approved'";
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
                        $attendedclas = $row['attendedclasses'];
                        $totalclas = $row['totalclasses'];
                        if($totalclas!=0){
                        $percentagge= ($attendedclas / $totalclas) *100;
                        }
                        else
                        {
                            $percentagge=100;
                        }
                        ?>
                        <tr>
                            <td><?php echo $course_namee; ?></td>
                            <td><?php echo $course_idd; ?></td>
                            <td><?php echo $attendedclas; ?></td>
                            <td><?php echo $totalclas; ?></td>
                            <td><?php echo $percentagge; ?></td>
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