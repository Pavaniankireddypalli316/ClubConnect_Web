<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Student</h1>

        <br><br>

        <?php 
            //1. Get the ID of Selected Admin
            $id=$_GET['id'];

            //2. Create SQL Query to Get the Details
            $sql="SELECT * FROM studentdetails WHERE studentid=$id";

            //Execute the Query
            $res=mysqli_query($conn, $sql);

            //Check whether the query is executed or not
            if($res==true)
            {
                // Check whether the data is available or not
                $count = mysqli_num_rows($res);
                //Check whether we have admin data or not
                if($count==1)
                {
                    // Get the Details
                    //echo "Admin Available";
                    $row=mysqli_fetch_assoc($res);

                    $username = $row['name'];
                    $contact = $row['contact'];
                    $address = $row['address'];
                    $date = $row['dob'];
                    $mail = $row['email']; 
                }
                else
                {
                    //Redirect to Manage Admin PAge
                    header('location:'.SITEURL.'admin/managestudent.php');
                }
            }
        
        ?>


        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="name" value="<?php echo $username; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Contact: </td>
                    <td>
                        <input type="text" name="contact" value="<?php echo $contact; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Address: </td>
                    <td>
                        <input type="text" name="address" value="<?php echo $address; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Date Of Birth: </td>
                    <td>
                        <input type="text" name="dob" value="<?php echo $date; ?>">
                    </td>
                </tr>
                <tr>
                    <td>E-Mail: </td>
                    <td>
                        <input type="text" name="email" value="<?php echo $mail; ?>">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update student" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
    </div>
</div>

<?php 

    //Check whether the Submit Button is Clicked or not
    if(isset($_POST['submit']))
    {
        //echo "Button CLicked";
        //Get all the values from form to update
        $id = $_POST['id'];
        $username = $_POST['name'];
        $contact = $_POST['contact'];
        $address = $_POST['address'];
        $date = $_POST['dob'];
        $mail = $_POST['email']; 

        //Create a SQL Query to Update Admin
        $sql = "UPDATE studentdetails SET
        name = '$username',
        contact = '$contact',
        address = '$address',
        dob = '$date',
        email = '$mail'
        WHERE studentid='$id'
        ";

        //Execute the Query
        $res = mysqli_query($conn, $sql);

        //Check whether the query executed successfully or not
        if($res==true)
        {
            //Query Executed and Admin Updated
            $_SESSION['update'] = "<div class='success'>Student Details Updated Successfully.</div>";
            //Redirect to Manage Admin Page
            header('location:'.SITEURL.'admin/managestudent.php');
        }
        else
        {
            //Failed to Update Admin
            $_SESSION['update'] = "<div class='error'>Failed to Delete Admin.</div>";
            //Redirect to Manage Admin Page
            header('location:'.SITEURL.'admin/managestudent.php');
        }
    }

?>


<?php include('partials/footer.php'); ?>