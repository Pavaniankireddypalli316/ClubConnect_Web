<?php
include("facheader.php");
?>
<!DOCTYPE html>
<html>
<head>
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="table.css">
    <style>
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

            //retrieving the cookie here - created in loginprocess.php
            $userId = $_COOKIE['varus_name']; 
            //First need to find out the course which was right now allocated to the faculty
            $a="SELECT * FROM courses WHERE facultyid='$userId' AND coursestatus='ACTIVE'";
            $res=mysqli_query($conn,$a);
            $details=mysqli_fetch_assoc($res);
            $courseidact=$details['courseid'];
            //collecting the details who all are right now in the course
            $b="SELECT * FROM enrolatt WHERE courseid='$courseidact' AND studentstatus='Approved' AND coursestatus='ACTIVE'";
//block to mark attendance
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Loop through the attendance form data
    foreach ($_POST["attendance"] as $studentId => $status) {
        // alloting grade to each student
            $sql = "UPDATE enrolatt SET grade = '$status', coursestatus='Completed' WHERE studentid = $studentId AND courseid='$courseidact'";
            $conn->query($sql);
    }
    $ss="UPDATE courses SET coursestatus='Completed' WHERE courseid='$courseidact'";
    $conn->query($ss);
    echo "Course Has been launched";
    header('location:http://localhost/appweb/fachome.php');
}
        ?>
<!-- display page start from here onwards -->
<form method="post">
    <ul class="responsive-table">
    <li class="table-header">
      <div class="col col-1">Student Id</div>
      <div class="col col-2"> Name</div>
      <div class="col col-3">Feedback</div>
    </li>
        <?php
//now fetching all the students registered for the course that was right now taken by facutly 
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
                        ?>
                        <li class="table-row">
                            <div class="col col-1" data-label="Student Id"><?php echo $studentid; ?></div>
                            <div class="col col-2" data-label="Student Name"><?php echo $studentname; ?></div>
                            <!-- need to mark attendance -->
                            <?php
                            echo "<input type='radio' name='attendance[" . $row["studentid"] . "]' value='Excellent'> Excellent";
                            echo "<input type='radio' name='attendance[" . $row["studentid"] . "]' value='Good'> Good";
                            echo "<input type='radio' name='attendance[" . $row["studentid"] . "]' value='Average'> Average";
                            ?>
                        </li>                       
                        <?php
                    } // closing while loop block (The block used to collect the data of all students who have been registered for the course)
                ?>
                <input type="submit" value="Submit">
                <?php
                }
                else
                {
                    // Order not Available
                    echo "<p>No One has been Registered till date</p>";
                }
        ?>
</ul>
</form>
    </div>
</body>
</html>