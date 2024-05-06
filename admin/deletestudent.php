<?php 

    //Include constants.php file here
    include('../config/constants.php');

    // 1. get the ID of student to be deleted
    $id = $_GET['id'];

    //2.create some random integer value to set as password
    $randomNumber = rand(1, 100000000); // Generates a random number between 1 and 100,000,000


    //3. Create SQL Query to Delete student
    $sql = "UPDATE studentdetails SET password='$randomNumber',name='DEACTIVATED' WHERE studentid='$id'";

   

    //Execute the Query
    $res = mysqli_query($conn, $sql);

    // Check whether the query executed successfully or not
    if($res==true)
    {
        //Query Executed Successully and Admin Deleted
        //echo "Student Deleted";
        //Create SEssion Variable to Display Message
        $_SESSION['delete'] = "<div class='success'>Student Deleted Successfully.</div>";
        //Redirect to Manage Admin Page
        header('location:'.SITEURL.'admin/managestudent.php');
    }
    else
    {
        //Failed to Delete Admin
        //echo "Failed to Delete Admin";

        $_SESSION['delete'] = "<div class='error'>Failed to Delete Student. Try Again Later.</div>";
        header('location:'.SITEURL.'admin/managestudent.php');
    }

    //3. Redirect to Manage Admin page with message (success/error)

?>