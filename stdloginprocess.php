<?php
include("database.php");
$usid=$_POST['userid'];
$uspas=$_POST['password'];

//setting up the cookie to retrive it in vamsi.php
setcookie("varus_name", $usid, time() + 3600); 

//checking with the database data table
$sql="SELECT * from studentdetails WHERE studentid='$usid'and password='$uspas'";
$response = mysqli_query($conn, $sql);
if(mysqli_num_rows($response)>0)
{
    header("Location: stdhome.php");
}
else
{
    echo "<script> alert('username and password are incorrect or signup');
    location.href = 'loginstd.html';
    </script>";
}
$conn->close();
?>