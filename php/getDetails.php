<?php
session_start();
$servername = "localhost";
$username = "bms";
$password = "teacher123";
$dbname = "LMS";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
} 
if(isset($_SESSION["Log"])){
$fid=$_SESSION['CurrentID'];
$qry="select * from teacher_login t,profile p where p.Faculty_Id=t.Faculty_Id and t.Faculty_Id='".$fid."'";
$res=mysqli_query($con,$qry);
$results=array();
while($row=mysqli_fetch_assoc($res))
	$results[]=$row;
echo json_encode($results);
}else
	echo "420";
mysqli_close($con);
?>