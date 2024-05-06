<?php
include("facheader.php");
?>
<!DOCTYPE html>
<html>
<head>
    <!-- Bootstrap -->
   <link rel="stylesheet" href="table.css">
    <style>
        /* Your CSS styles remain unchanged */
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 80%;
            max-width: 100%;
            min-height: 70%;
            max-height: 80%;
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            margin: 0 auto;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            text-align: center;
            font-size: 28px;
        }

        form {
            margin-top: 20px;
        }

        input[type="text"],
        input[type="email"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .success-message {
            color: #4CAF50;
            margin-top: 10px;
        }

        .error-message {
            color: #f44336;
            margin-top: 10px;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            h1 {
                font-size: 24px;
            }

            input[type="text"],
            input[type="email"],
            input[type="submit"] {
                width: 100%;
                font-size: 20px;
            }
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 26px;
            }
            p {
                font-size: 26px;
            }
            input{
                font-size: 26px;
            }
            
        }

        @media (max-width: 992px) {
            h1 {
                font-size: 28px;
            }
            p {
                font-size: 26px;
            }
            input{
                font-size: 26px;
            }
        }

      
    </style>
</head>
<body>
    <div class="container">
        <h1>Grade Marking</h1>
        <?php
        // include connection to database
        include("database.php");

        // retrieving the cookie here - created in loginprocess.php
        $userId = $_COOKIE['varus_name'];

        // Fetch all courses assigned to the faculty
        $facultyCoursesQuery = "SELECT * FROM courses WHERE facultyid='$userId' AND coursestatus='ACTIVE'";
        $facultyCoursesResult = mysqli_query($conn, $facultyCoursesQuery);

        if (mysqli_num_rows($facultyCoursesResult) > 0) {
            echo "<label for='course'>Select a Club:</label>";
            echo "<select name='course' id='course'>";

            echo "<option value=''>Select</option>";
            while ($courseDetails = mysqli_fetch_assoc($facultyCoursesResult)) {
                $courseId = $courseDetails['courseid'];
                $courseName = $courseDetails['coursename'];
                echo "<option value='$courseId'>$courseName</option>";
            }

            echo "</select>";

            echo "<script>
                    document.getElementById('course').addEventListener('change', function() {
                        var selectedCourseId = this.value;
                        if (selectedCourseId !== '') {
                            window.location.href = '?course=' + selectedCourseId;
                        }
                    });
                  </script>";

            // Check if a specific course is selected
            if (isset($_GET['course'])) {
                $selectedCourseId = $_GET['course'];

                // Query to fetch enrolled students for the selected course
                $enrolledStudentsQuery = "SELECT enrolatt.*, studentdetails.name AS student_name FROM enrolatt INNER JOIN studentdetails ON enrolatt.studentid = studentdetails.studentid WHERE enrolatt.courseid='$selectedCourseId' AND enrolatt.studentstatus='Approved' AND enrolatt.coursestatus='ACTIVE'";

                $enrolledStudentsResult = mysqli_query($conn, $enrolledStudentsQuery);

                if (mysqli_num_rows($enrolledStudentsResult) > 0) {
                    // Display the form to mark grades
                    echo "<form method='post'>";
                    echo "<ul class='responsive-table'>";
                    echo "<li class='table-header'>";
                    echo "<div class='col col-1'>Student Id</div>";
                    echo "<div class='col col-2'>Name</div>";
                    echo "<div class='col col-3'>Feedback</div>";
                    echo "</li>";

                    while ($row = mysqli_fetch_assoc($enrolledStudentsResult)) {
                        $studentId = $row['studentid'];
                        $studentName = $row['student_name'];

                        echo "<li class='table-row'>";
                        echo "<div class='col col-1' data-label='Student Id'>$studentId</div>";
                        echo "<div class='col col-2' data-label='Student Name'>$studentName</div>";
                        // Provide feedback options
                        echo "<input type='radio' name='attendance[$studentId]' value='Excellent'> Excellent";
                        echo "<input type='radio' name='attendance[$studentId]' value='Good'> Good";
                        echo "<input type='radio' name='attendance[$studentId]' value='Average'> Average";
                        echo "</li>";
                    }

                    echo "</ul>";
                    echo "<input type='submit' value='Submit'>";
                    echo "</form>";
                } else {
                    echo "<p>No students registered for this course.</p>";
                }
            }
        } else {
            echo "<p>No courses assigned to this faculty.</p>";
        }

        // Processing form submission to update grades
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            foreach ($_POST["attendance"] as $studentId => $status) {
                $updateGradeQuery = "UPDATE enrolatt SET grade = '$status', coursestatus='Completed' WHERE studentid = $studentId AND courseid='$selectedCourseId'";
                $conn->query($updateGradeQuery);
            }

            $updateCourseStatusQuery = "UPDATE courses SET coursestatus='Completed' WHERE courseid='$selectedCourseId'";
            $conn->query($updateCourseStatusQuery);
            echo "Grades marked successfully";
            
        }
        ?>
    </div>
</body>
</html>
































