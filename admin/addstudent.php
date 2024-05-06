<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Student</h1>

        <br><br>

        <?php 
            if(isset($_SESSION['add'])) //Checking whether the SEssion is Set of Not
            {
                echo $_SESSION['add']; //Display the SEssion Message if SEt
                unset($_SESSION['add']); //Remove Session Message
            }
        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="name" value="">
                    </td>
                </tr>
                <tr>
                    <td>StudentId: </td>
                    <td>
                        <input type="text" name="stdid" placeholder="">
                    </td>
                </tr>

                <tr>
                    <td>Contact: </td>
                    <td>
                        <input type="text" name="contact" >
                    </td>
                </tr>
                <tr>
                    <td>Address: </td>
                    <td>
                        <input type="text" name="address" >
                    </td>
                </tr>

                <tr>
                    <td>Date Of Birth: </td>
                    <td>
                        <input type="date" name="dob" >
                    </td>
                </tr>
                <tr>
                    <td>E-Mail: </td>
                    <td>
                        <input type="text" name="email" >
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Student" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>


    </div>
</div>

<?php include('partials/footer.php'); ?>


<?php 
    //Process the Value from Form and Save it in Database

    //Check whether the submit button is clicked or not

    if(isset($_POST['submit']))
    {
        // Button Clicked
        //echo "Button Clicked";

        //1. Get the Data from form
        $username = $_POST['name'];
        $studentid = $_POST['stdid'];
        $contact = $_POST['contact'];
        $address = $_POST['address'];
        $date = $_POST['dob'];
        $mail = $_POST['email']; 

        //2. SQL Query to Save the data into database
        $sql = "INSERT INTO studentdetails SET 
        name = '$username',
        studentid = '$studentid',
        password = 'welcome',
        contact = '$contact',
        address = '$address',
        dob = '$date',
        email = '$email'
        ";
 
        //3. Executing Query and Saving Data into Datbase
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        //4. Check whether the (Query is Executed) data is inserted or not and display appropriate message
        if($res==TRUE)
        {
            //Data Inserted
            //echo "Data Inserted";
            //Create a Session Variable to Display Message
            $_SESSION['add'] = "<div class='success'>Student Added Successfully.</div>";
            //Redirect Page to Manage Admin
            header("location:".SITEURL.'admin/managestudent.php');
        }
        else
        {
            //FAiled to Insert DAta
            //echo "Faile to Insert Data";
            //Create a Session Variable to Display Message
            $_SESSION['add'] = "<div class='error'>Failed to Add Admin.</div>";
            //Redirect Page to Add Admin
            header("location:".SITEURL.'admin/addstudent.php');
        }

    }
    
?>