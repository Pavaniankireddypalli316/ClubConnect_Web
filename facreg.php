<?php
include("facheader.php");
include("database.php");
//extracting the faculty id from the login page from an cookie
$userId = $_COOKIE['varus_name'];
$a="SELECT * FROM courses WHERE facultyid='$userId' AND coursestatus='ACTIVE'";
$res=mysqli_query($conn,$a);
$details=mysqli_fetch_assoc($res);
$courseidact=$details['courseid'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="table.css">
</head>
<body>
<div class="container">
<h2>Students Enrolled</h2>
<!-- Dropdown to select courses -->
<form method="get" class="select-dropdown">
            <label for="courseSelect">Select Course:</label>
            <select name="courseSelect" id="courseSelect" onchange="this.form.submit()">
                <option value="">Select a Course</option>
                <?php
                // include connection to database
                include("database.php");

                // Retrieving the cookie here - created in loginprocess.php
                $userId = $_COOKIE['varus_name'];
                
                // Fetching courses assigned to the faculty
                $courseQuery = "SELECT * FROM courses WHERE facultyid='$userId' AND coursestatus='ACTIVE'";
                $courseResult = mysqli_query($conn, $courseQuery);
                
                while ($courseRow = mysqli_fetch_assoc($courseResult)) {
                    $courseId = $courseRow['courseid'];
                    $courseName = $courseRow['coursename'];
                    echo "<option value='$courseId'>$courseName</option>";
                }
                ?>
            </select>
        </form>
<!-- dropdown section code end's here selecting course    -->
<ul class="responsive-table">
    <li class="table-header">
      <div class="col col-1">Student Id</div>
      <div class="col col-2"> Name</div>
      <div class="col col-3">Status</div>
      <div class="col col-4">Action</div>
    </li>
        <?php
//now fetching all the students registered for the course that was right now taken by facutly 
$b="SELECT * FROM enrolatt  WHERE courseid='$courseidact' AND coursestatus='ACTIVE'";
$ans=mysqli_query($conn,$b);
                $count = mysqli_num_rows($ans);

                if($count>0)
                {
                    // Courses available
                    while($row=mysqli_fetch_assoc($ans))
                    {
                        //Get all the courses details
                        $studentid = $row['studentid'];
                        $ab=mysqli_query($conn,"SELECT * FROM studentdetails WHERE studentid='$studentid'");
                        $dee=mysqli_fetch_assoc($ab);
                        $studentname = $dee['name'];
                        $coursestatusnow=$row['studentstatus'];
                        ?>
                        <li class="table-row">
                            <div class="col col-1" data-label="Student Id"><?php echo $studentid; ?></div>
                            <div class="col col-2" data-label="Student Name"><?php echo $studentname; ?></div>
                            <div class="col col-3" data-label="Status">
                                <?php
                                if($coursestatusnow=="pending")
                                    {
                                        echo "<label style='color: orange;'>$coursestatusnow</label>";
                                    }
                                    elseif($coursestatusnow=="Approved")
                                    {
                                        echo "<label style='color: green;'>$coursestatusnow</label>";
                                    }
                                    elseif($coursestatusnow=="Rejected")
                                    {
                                        echo "<label style='color: red;'>$coursestatusnow</label>";
                                    }
                                    ?>
                            </div>
                            <!-- providing opitions to the faculty to change the status of the student -->
                            <form action="facupdatestd.php" method="POST">
                                <div class="col col-4" data-label="Change">
                                    <select name="cstatusuu">
                                        <option <?php if($coursestatusnow=="pending"){echo "selected";} ?> value="pending">Pending</option>
                                        <option <?php if($coursestatusnow=="Approved"){echo "selected";} ?> value="Approved">Approved</option>
                                        <option <?php if($coursestatusnow=="Rejected"){echo "selected";} ?> value="Rejected">Rejected</option>
                                    </select>
                                </div>
                                <input type="hidden" name="rstudentid" value="<?php echo $studentid; ?>">
                                <input type="hidden" name="rcoursename" value="<?php echo $courseidact; ?>">
                                <input type="submit" name="submit" value="UPDATE" class="btn-primary">
                            </form>
                        </li>                         
                        <?php
                    } // closing while loop block (The block used to collect the data of all students who have been registered for the course)
                }
                else
                {
                    // Order not Available
                    echo "<p>No One has been Registered till date</p>";
                }
        ?>
</ul>
</div>
</body>
</html>