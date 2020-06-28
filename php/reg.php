<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "teacher";
$tbl_name="teacher_login";
$message="Incorrect Password";


// Create connection
$con = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$row=array();
$nme=$_POST['name'];
$fid=$_POST['fid'];
$desg=$_POST['desg'];
$dept=$_POST['dept'];
$cl=$_POST['cl'];
$rh=$_POST['rh'];
$el=$_POST['el'];
$uname=$_POST['uname'];
$mail=$_POST['email'];
$pswd=$_POST['pass'];
$office=$_POST['offno'];
$mob=$_POST['mobno'];
$adr=$_POST['add'];
if($desg=="Assistant Professor")
	$role="P";
else if($desg=="Associate Professor")
	$role="P";
else if($desg=="HOD")
    $role="HOD";
else  
	 $role="VP";

/*$qry="select * from Profile where Name='".$nme."'";
if(mysqli_num_rows(mysqli_query($con,$qry))>0) 
	$row[0]=1;
else 
	$row[0]=0;*/


$qry="select * from Profile where Faculty_Id='$fid'";
if(mysqli_num_rows(mysqli_query($con,$qry))>0) 
	$row[0]=1;
else 
	$row[0]=0;


$qry="select * from teacher_login where Username='$uname'";
if(mysqli_num_rows(mysqli_query($con,$qry))>0) 
	$row[1]=1;
else 
	$row[1]=0;


if($desg=="HOD"){
$qry="select * from Profile where Designation='$desg' and Department='$dept'";
if(mysqli_num_rows(mysqli_query($con,$qry))>0)
	$row[2]=1;
}
else 
	$row[2]=0;

if($row[0]==0 && $row[1]==0 && $row[2]==0){
    $qry="insert into Profile_Approve 
    values('$nme','$fid','$desg','$dept','$mob','$office','$mail','$adr','$cl','$rh','$el','$role','$uname','$pswd')"; 
    mysqli_query($con,$qry);
	echo "400";
}
else if($row[0]==1)	{
	echo "401";
}
else if($row[1]==1)	{
	echo "402";
}
else{
	echo "403";
}
mysqli_close($con);
?>