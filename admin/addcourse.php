<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Course</h1>

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
                    <td>Club Code: </td>
                    <td>
                        <input type="text" name="clubid" value="">
                    </td>
                </tr>
                <tr>
                    <td>Club Name: </td>
                    <td>
                        <input type="text" name="clubname" value="">
                    </td>
                </tr>

                <tr>
                    <td>Faculty Id: </td>
                    <td>
                        <select name="faculid">
                    <?php 
                        //Query to Get all faculties details
                        $sql = "SELECT * FROM facultydetails";
                        //Execute the Query
                        $res = mysqli_query($conn, $sql);

                        //CHeck whether the Query is Executed of Not
                        if($res==TRUE)
                        {
                            // Count Rows to CHeck whether we have data in database or not
                            $count = mysqli_num_rows($res); // Function to get all the rows in database

                            $sn=1; //Create a Variable and Assign the value

                            //CHeck the num of rows
                            if($count>0)
                            {
                                //WE HAve data in database
                                while($rows=mysqli_fetch_assoc($res))
                                {
                                    //Using While loop to get all the data from database.
                                    //And while loop will run as long as we have data in database

                                    //Get individual DAta
                                    $facid=$rows['facultyid'];

                                    //Displaying all the available faculty id s
                                    ?>
                                    
                                    <option  value="<?php echo $facid; ?>"><?php echo $facid; ?></option>

                                    <?php

                                }
                            }
                            else
                            {
                                //We Do not Have Data in Database
                            }
                        }

                    ?>                            
                                        
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Strength: </td>
                    <td>
                        <input type="text" name="streng" value="">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Club" class="btn-secondary">
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
        $culname = $_POST['clubname'];
        $culid = $_POST['clubid'];
        $facultid = $_POST['faculid'];
        $strength = $_POST['streng'];

        //2. SQL Query to Save the data into database
        $sql = "INSERT INTO courses SET 
        coursename = '$culname',
        courseid = '$culid',
        facultyid = '$facultid',
        strength = '$strength',
        coursestatus = 'ACTIVE'
        ";
 
        //3. Executing Query and Saving Data into Datbase
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        //4. Check whether the (Query is Executed) data is inserted or not and display appropriate message
        if($res==TRUE)
        {
            //Data Inserted
            //echo "Data Inserted";
            //Create a Session Variable to Display Message
            $_SESSION['add'] = "<div class='success'>Club Added Successfully.</div>";
            //Redirect Page to Manage Admin
            header("location:".SITEURL.'admin/managecourse.php');
        }
        else
        {
            //FAiled to Insert DAta
            //echo "Faile to Insert Data";
            //Create a Session Variable to Display Message
            $_SESSION['add'] = "<div class='error'>Failed to Add Admin.</div>";
            //Redirect Page to Add Admin
            header("location:".SITEURL.'admin/addcourse.php');
        }

    }
    
?>