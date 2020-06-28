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
$fid=$_POST['Fid'];
$qry="select RF from reset where Faculty_Id='".$fid."'";
$r=mysqli_query($con,$qry);
$r=mysqli_fetch_object($r);
if($r->RF==0)
	exit("408");
$qry="select * from profile";
$res=mysqli_query($con,$qry);
if($res){
while($row=mysqli_fetch_array($res)){
$el=$row["EL"];
$el=$el+10;
$qry="update Profile set CL='12',RL='2',EL='".$el."' where Faculty_Id='".$row["Faculty_Id"]."'";
$res1=mysqli_query($con,$qry);
if(!$res1)
exit("402");
}
$qry="update reset set RF=0 where Faculty_Id='".$fid."'";
mysqli_query($con,$qry);
exit("500");
}
else
echo "401";
mysqli_close($con);
?>