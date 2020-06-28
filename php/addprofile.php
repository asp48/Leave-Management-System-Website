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
$sid=$_POST['Sid'];
$fid=$_POST['Fid'];
$cl=$_POST['CL'];
$rh=$_POST['RH'];
$el=$_POST['EL'];
$st=$_POST['Status'];
$content1=$_POST['Content'];
if($st=="1"){
$qry="select * from profile_approve where Faculty_Id='".$fid."'";
$res=mysqli_query($con,$qry);
if($res){
while($row=mysqli_fetch_array($res)){
$qry1="insert into teacher_login values('".$row['Username']."','".$row['Password']."','".$row['Role']."','".$row['Faculty_Id']."')";
$res1=mysqli_query($con,$qry1);
if($res1){
$qry2="insert into profile(Faculty_Id,Name,Designation,Department,Mobile,OfficeNumber,Email,Address,Super_Id,CL,RL,EL) values('".$row['Faculty_Id']."','".$row['Name']."','".$row['Designation']."','".$row['Department']."','".$row['Mobile']."','".$row['OfficeNumber']."','".$row['Email']."','".$row['Address']."','".$sid."','".$cl."','".$rh."','".$el."')";
$res2=mysqli_query($con,$qry2);
if($res2)
echo "500";
else
exit("402");
}
else
exit("403");
}
}
else exit("404");
}
$mailid=mysqli_fetch_object(mysqli_query($con,"select Email from profile_approve where Faculty_Id='".$fid."'"));
$email=$mailid->Email;
$qry="delete from profile_approve where Faculty_Id='$fid'";
$res=mysqli_query($con,$qry);
if($res)
echo "501";
else echo "407";
$headers = "From: lms.bmsce@gmail.com \r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
if($st=='1')
$content2='<html><body>Your Profile for LMS has been accepted. Now you can kindly apply for leaves by signing into '.'<a href="http://www.lmsinbms.comlu.com/Suhas/modify.html">LMS @ bmsce </a></body></html>';	
else
$content2='<html><body>Your Profile for LMS has been rejected.Reason being <br/>'.$content1.'<br/> Please contact the administrator for necessary changes</body></html>';
$r=mail($email,'Profile Status',$content2,$headers);
if(!$r)
	echo "408";
$con->close();
?>