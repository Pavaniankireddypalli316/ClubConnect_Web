<?php
include("facheader.php");
include("database.php");

function sanitizeInput($conn, $data) {
    return mysqli_real_escape_string($conn, $data);
}

// Validate and sanitize the faculty ID from the cookie
$userId = isset($_COOKIE['varus_name']) ? sanitizeInput($conn, $_COOKIE['varus_name']) : '';

// Fetch active courses assigned to the faculty
$coursesQuery = "SELECT * FROM courses WHERE facultyid='$userId' AND coursestatus='ACTIVE'";
$coursesResult = mysqli_query($conn, $coursesQuery);
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
        <h2>Registration</h2>
        

        <!-- Dropdown to select courses -->
        <form method="get" class="select-dropdown">
            <label for="courseSelect">Select Club:</label>
            <select name="courseSelect" id="courseSelect" onchange="this.form.submit()">
                <option value="">Select a Club</option>
                <?php
                while ($courseRow = mysqli_fetch_assoc($coursesResult)) {
                    $courseId = $courseRow['courseid'];
                    $courseName = $courseRow['coursename'];
                    echo "<option value='" . sanitizeInput($conn, $courseId) . "'>$courseName</option>";
                }
                ?>
            </select>
        </form>
        <br>
        <br>
        <!-- Display students enrolled in the selected course -->
        <ul class="responsive-table" id="studentList" style="display: none;">
            <li class="table-header">
                <div class="col col-1">Student Id</div>
                <div class="col col-2">Name</div>
                <div class="col col-3">Status</div>
                <div class="col col-4">Action</div>
            </li>
            <?php
            if (isset($_GET['courseSelect'])) {
                $selectedCourseId = sanitizeInput($conn, $_GET['courseSelect']);

                $enrolledStudentsQuery = "SELECT * FROM enrolatt WHERE courseid='$selectedCourseId' AND coursestatus='ACTIVE'";
                $enrolledStudentsResult = mysqli_query($conn, $enrolledStudentsQuery);
                $count = mysqli_num_rows($enrolledStudentsResult);

                if ($count > 0) {
                    while ($row = mysqli_fetch_assoc($enrolledStudentsResult)) {
                        $studentId = $row['studentid'];
                        $studentDetailsQuery = "SELECT * FROM studentdetails WHERE studentid='$studentId'";
                        $studentDetailsResult = mysqli_query($conn, $studentDetailsQuery);
                        $studentDetails = mysqli_fetch_assoc($studentDetailsResult);

                        $studentName = $studentDetails['name'];
                        $courseStatusNow = $row['studentstatus'];
                        ?>
                        <li class="table-row">
                            <div class="col col-1" data-label="Student Id"><?php echo $studentId; ?></div>
                            <div class="col col-2" data-label="Student Name"><?php echo $studentName; ?></div>
                            <div class="col col-3" data-label="Status">
                                <?php
                                if ($courseStatusNow == "pending") {
                                    echo "<label style='color: orange;'>$courseStatusNow</label>";
                                } elseif ($courseStatusNow == "Approved") {
                                    echo "<label style='color: green;'>$courseStatusNow</label>";
                                } elseif ($courseStatusNow == "Rejected") {
                                    echo "<label style='color: red;'>$courseStatusNow</label>";
                                }
                                ?>
                            </div>
                            <form action="facupdatestd.php" method="POST">
                                <div class="col col-4" data-label="Change">
                                    <select name="cstatusuu">
                                        <option <?php if ($courseStatusNow == "pending") {
                                            echo "selected";
                                        } ?> value="pending">Pending
                                        </option>
                                        <option <?php if ($courseStatusNow == "Approved") {
                                            echo "selected";
                                        } ?> value="Approved">Approved
                                        </option>
                                        <option <?php if ($courseStatusNow == "Rejected") {
                                            echo "selected";
                                        } ?> value="Rejected">Rejected
                                        </option>
                                    </select>
                                </div>
                                <input type="hidden" name="rstudentid" value="<?php echo $studentId; ?>">
                                <input type="hidden" name="rcoursename" value="<?php echo $selectedCourseId; ?>">
                                <input type="submit" name="submit" value="UPDATE" class="btn-primary">
                            </form>
                        </li>
                        <?php
                    }
                    // Display the student list
                    echo "<script>document.getElementById('studentList').style.display = 'block';</script>";
                } else {
                    echo "<p>No One has been Registered for this course</p>";
                }
            }
            ?>
        </ul>
    </div>
</body>
</html>
