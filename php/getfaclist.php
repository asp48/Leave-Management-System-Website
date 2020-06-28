<?php
$con=mysqli_connect("localhost","bms","teacher123","LMS");
 
if (mysqli_connect_errno($con))
{
   echo "400";
}
else {
$dept=$_POST['Dept'];
$role=$_POST['Role'];
if($role=="NT")
$qry="select Name,p.Faculty_Id from profile as p,teacher_login as t where Department='".$dept."' and t.Faculty_Id=p.Faculty_Id and t.Role NOT IN ('P','HOD','VP')";
else
$qry="select Name,p.Faculty_Id from profile as p,teacher_login as t where Department='".$dept."' and t.Faculty_Id=p.Faculty_Id and t.Role NOT IN ('NT')";
$res=mysqli_query($con,$qry);
$result=array();	
if($res){
while($row=mysqli_fetch_assoc($res)){
array_push($result,$row);
}
}
echo json_encode(array("Results"=>$result));
}
mysqli_close($con);
?>