<?php
include("facheader.php");
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="table.css">
    <style>
        /* Your existing CSS styles */
        /* ... */

        .select-dropdown {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 30px; 
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #FF5D4C;
        }

        td input[type="radio"] {
            margin-right: 10px;
        }

        /* Custom style for the button */
        .custom-btn {
            background-color: #FF5D4C;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .custom-btn:hover {
            background-color: #ff2d45;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Attendance</h1>

        <!-- Dropdown to select courses -->
        <form method="get" class="select-dropdown">
            <label for="courseSelect">Select a Club: </label>
            <select name="courseSelect" id="courseSelect" onchange="this.form.submit()">
                <option value="">Select</option>
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
        <br>
        

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //getting the course id 
            $courseselected = $_POST['selectedCourseId'];
            foreach ($_POST["attendance"] as $studentId => $status) {
                // Increment total_classes for all students
                $sql = "UPDATE enrolatt SET totalclasses = totalclasses + 1 WHERE studentid = $studentId AND courseid='$courseselected'";
                $conn->query($sql);
                
                // Increment classes_attended if student is present
                if ($status == 'present') {
                    $sql = "UPDATE enrolatt SET attendedclasses = attendedclasses + 1 WHERE studentid = $studentId AND courseid='$courseselected'";
                    $conn->query($sql);
                }
            }
            ?>
            <p style="color:#5b6178; font-size:30dp;">Attendance marked successfully!</p>
            <?php
        }

        if (isset($_GET['courseSelect']) && !empty($_GET['courseSelect'])) {
            echo "<form method='post'>";
            $selectedCourseId = $_GET['courseSelect'];
            echo "<input type='hidden' name='selectedCourseId' value='$selectedCourseId'>";
            // Fetching details of students enrolled in the selected course
            $enrollmentQuery = "SELECT * FROM enrolatt WHERE courseid='$selectedCourseId' AND studentstatus='Approved' AND coursestatus='ACTIVE'";
            $enrollmentResult = mysqli_query($conn, $enrollmentQuery);
            $enrollmentCount = mysqli_num_rows($enrollmentResult);

            if ($enrollmentCount > 0) {
                // Display student list for the selected course in a table
               
                echo "<table>";
                echo "<tr><th>Student ID</th><th>Student Name</th><th>Attendance</th></tr>";
                while ($enrollmentRow = mysqli_fetch_assoc($enrollmentResult)) {
                    $studentId = $enrollmentRow['studentid'];
                    $studentDetailsQuery = "SELECT * FROM studentdetails WHERE studentid='$studentId'";
                    $studentDetailsResult = mysqli_query($conn, $studentDetailsQuery);
                    $studentDetails = mysqli_fetch_assoc($studentDetailsResult);
                    $studentName = $studentDetails['name'];
                    echo "<tr>";
                    echo "<td>$studentId</td>";
                    echo "<td>$studentName</td>";
                    echo "<td><input type='radio' name='attendance[$studentId]' value='present'> Present ";
                    echo "<input type='radio' name='attendance[$studentId]' value='absent'> Absent</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "<div class='text-center'><input type='submit' value='Submit Attendance' class='custom-btn'></div>";
                echo "</form>";
            } else {
                // No students enrolled for the selected course
                echo "<p>No students enrolled in this course.</p>";
            }
        } else {
            // Prompt to select a course from the dropdown
            echo "<p>Please select a Club to display the student list.</p>";
        }
        ?>
    </div>
</body>
</html>
