<?php 
//studnet application page to involves in student enrollement process
include("database.php");
$studentId=$_POST['studentid'];
$course_idd=$_POST['courseid'];
$course_namee=$_POST['coursename'];
function getUserDetails($conn, $user)
            {
                $query = "SELECT * FROM studentdetails WHERE studentid = '$user'";
                $response = mysqli_query($conn, $query);
                if(mysqli_num_rows($response) > 0)
                {
                    return $response->fetch_assoc();
                }
                return false;
            }

    // Get user details
    $userDetails = getUserDetails($conn, $studentId);
    $studentname=$userDetails['name'];

    //saving the data into the data base
    $ans="INSERT INTO `enrolatt` (`name`, `studentid`, `courseid`, `coursename`, `studentstatus`,
    `attendedclasses`, `totalclasses`, `coursestatus`, `grade`) 
    VALUES ('$studentname', '$studentId', '$course_idd', '$course_namee',
    'pending', '0', '0', 'ACTIVE', 'NA')";

    $resp=mysqli_query($conn,$ans);
    //displaying wether the course registered  or not
    //4. Check whether the (Query is Executed) data is inserted or not and display appropriate message
        if($resp==TRUE)
        {
            //Data Inserted
            //echo "Data Inserted";
            //Create a Session Variable to Display Message
            $_SESSION['add'] = "<div class='success'>Course Registered Successfully.</div>";
            //Redirect Page to Manage Admin
            echo "You been Registered Successfully";
            echo '<a href="http://localhost/appweb/stdenroll.php">Click on Refresh the Page</a>';
            // echo "Please Refresh the page";
            // echo "";
        }
        else
        {
            //FAiled to Insert DAta
            //echo "Faile to Insert Data";
            //Create a Session Variable to Display Message
            $_SESSION['add'] = "<div class='error'>Failed to Register</div>";
            //Redirect Page to Add Admin
            // header("location:".'http://localhost/indra/'.'stdenroll.php');
            echo "Registration Failed";
        }
$conn->close();
?>