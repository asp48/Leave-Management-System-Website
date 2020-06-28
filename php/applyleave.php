<?php
$servername = "localhost";
$username = "bms";
$password = "teacher123";
$dbname = "LMS";

//Create connection
$con = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
$flag=0;
$fid=$_POST['Fid'];
$sid=$_POST['Sid'];
$dt=date("Y-m-d");
$tl = $_POST["typl"];
$fd = (empty($_POST["fromD"]))?'0000-00-00':$_POST["fromD"];
$td = (empty($_POST["toD"]))?'0000-00-00':$_POST["toD"];
$od = (empty($_POST["onD"]))?'0000-00-00':$_POST["onD"];
$nd =  $_POST["ndays"];
$rsn = $_POST["reason"];
$alt = json_decode($_POST["alt"],true);
$fa = (isset($_POST["fasst"])?$_POST["fasst"]:0);
$amt = (empty($_POST["amt"]))?0:$_POST["amt"];
$pp = (empty($_POST["pp"])?0:$_POST["pp"]);
$qry='insert into approve(Applied_On,Super_Id,Faculty_Id,Type,FromD,ToD,NoDays,Reason,OnD,PR_POL,FAssist,FAmount) values("'.$dt.'","'.$sid.'","'.$fid.'","'.$tl.'","'.$fd.'","'.$td.'","'.$nd.'","'.$rsn.'","'.$od.'","'.$pp.'","'.$fa.'","'.$amt.'")';
$lid='';
$result=mysqli_query($con,$qry);
if($result){
if(mysqli_affected_rows($con)!=1)
$flag=1;	
else{
$qry="select max(LeaveId) as LeaveId from approve";
$res=mysqli_query($con,$qry);
$lid=mysqli_fetch_object($res);
}
}
else
$flag=1;
if($flag==0){
$temp='';
while($temp=current($alt)){
	$fields=explode('/',$temp);
	$qry="insert into alternate(LeaveId,Faculty_Id,Assigner_Id,OnD,FromT,Till,Class) values(".$lid->LeaveId.",'".key($alt)."','".$fid."','".$fields[0]."','".$fields[1]."','".$fields[2]."','".$fields[3]."')";
    $res=mysqli_query($con,$qry);
	if(mysqli_affected_rows($con)!=1){
		$flag=1;
		break;
	}
	next($alt);
	}
}
if($flag==1)
	echo "402";
else {
	echo "500";
	if($tl=='CL'){
		$qry="update alternate set vp_flag=1 where LeaveId=".$lid->LeaveId."";
		$res=mysqli_query($con,$qry);
	}
}
$con->close();
?>
