<?php
include("database.php");
if(isset($_POST['submit']))
{
$restudentid=$_POST['rstudentid'];
$recourse=$_POST['rcoursename'];
$upstatus=$_POST['cstatusuu'];
//now we need to update the status of the student that was selected by the faculty
$qu="UPDATE enrolatt
SET studentstatus = '$upstatus'
WHERE studentid = '$restudentid' AND courseid = '$recourse'
";
echo "$upstatus";
$res=mysqli_query($conn,$qu);
if($res==true)
{
    echo "Updation has done succesfully";
    header('location:http://localhost/appweb/facenroll.php');
}
else
{
    echo "An erro has been occurred";
    header('location:http://localhost/appweb/facenroll.php');
}
}
?>