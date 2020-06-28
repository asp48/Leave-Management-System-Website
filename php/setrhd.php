<?php
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
$m=$_POST['M'];
$dates=$_POST['Dates'];
$qry='select * from rhdates where Month='.$m;
if(mysqli_num_rows(mysqli_query($con,$qry))>0){
	$qry='update rhdates set Dates="'.$dates.'" where Month='.$m;
    if(mysqli_query($con,$qry))
		exit("500");
	else
		exit("403");
	}
else{
	$qry='insert into rhdates values('.$m.',"'.$dates.'")';
    if(mysqli_query($con,$qry))
		exit("500");
	else
		exit("404");
}
mysqli_close($con);
?>