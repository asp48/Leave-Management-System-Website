<?php
session_start();
$con=mysqli_connect("localhost","bms","teacher123","LMS");
 
if (mysqli_connect_errno($con))
{
   echo "400";
}
else {
$fid=$_SESSION["CurrentID"];
$today=date("Y-m-d");
$qry="update alternate set r_flag=1 where OnD < '".$today."'";
$res=mysqli_query($con,$qry);
$qry="delete from alternate where f_flag=1 and r_flag=1 and h_flag=1 and vp_flag=1";
$res=mysqli_query($con,$qry);
$qry="select p.Name,a.OnD,FromT,Till,Class from profile p, alternate a,approve ap where a.Faculty_Id = '".$fid."' and a.Assigner_Id = p.Faculty_Id and a.r_flag=0 and ap.LeaveId=a.LeaveId and ap.Status=1";
$res=mysqli_query($con,$qry);
$temp='';
if(mysqli_num_rows($res)>0){
	$temp=mysqli_num_rows($res).';';
	while($row=mysqli_fetch_array($res)){
		$temp .= '<tr><td>'.$row['Name'].'</td><td>'.$row['OnD'].'</td><td>'.$row['FromT'].'</td><td>'.$row['Till'].'</td><td>'.$row['Class'].'</td></tr>';
	}
	echo $temp;
}
else echo '0;<td colspan="5" class="text-center">No Results Found</td>';
}
mysqli_close($con);
?>