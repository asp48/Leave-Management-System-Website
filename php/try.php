<?php
session_start();
$servername = "localhost";
$username = "bms";
$password = "teacher123";
$dbname = "LMS";
$message="Incorrect Password";
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//echo "Connected successfully <br />";
$username=$_POST['username']; 
$password=$_POST['pass'];
$sql="SELECT * FROM teacher_login WHERE username='".$username."' and password='".$password."'";
$result=$conn->query($sql);
if($result->num_rows > 0){
	$res=mysqli_fetch_object($result);
	$_SESSION["Log"]='1';
	$_SESSION["CurrentID"]=$res->Faculty_Id;
	$_SESSION["Role"]=$res->Role;
    echo "500";   
}  	
else{
           echo "404";
}
?>