<?php
$con=mysqli_connect("localhost","bms","teacher123","LMS"); 
if (mysqli_connect_errno($con))
{
   echo "400";
}
else {
$lid=$_POST['Lid'];
$rjrsn=$_POST['Rjrsn'];
$st=$_POST['St'];
$role=$_POST['Role'];
$qry="select * from approve where LeaveId=".$lid;
$res=mysqli_query($con,$qry);
while($row=mysqli_fetch_array($res)){
$type=$row['Type'];
$fid=$row['Faculty_Id'];
$nd=$row['NoDays'];	
}
if($role=="HOD"){
if($type=="CL" || $st=="2")
$qry='UPDATE approve SET Status="'.$st.'",RjReason="'.$rjrsn.'",ByHOD="'.$st.'",Approve_HOD="'.date("Y-m-d").'" WHERE LeaveId ="'.$lid.'"';
else{
$qry='UPDATE approve SET ByHOD="'.$st.'",Approve_HOD="'.date("Y-m-d").'" WHERE LeaveId ="'.$lid.'"';
$st=0;}
}
else if($role=="VP"||$role=="P"){
$qry='UPDATE approve SET Status="'.$st.'",RjReason="'.$rjrsn.'",ByVP="'.$st.'",Approve_VP="'.date("Y-m-d").'" WHERE LeaveId ="'.$lid.'"';
}
$result=mysqli_query($con,$qry);
if($result){
if($st==1){
$qry2="select CL,RL,EL from Profile where Faculty_Id='".$fid."'";
$res=mysqli_query($con,$qry2);
if($res){ 
while($row=mysqli_fetch_array($res)){
$cl=$row[0];
$rh=$row[1];
$el=$row[2];}
if($type=="CL")$cl=$cl-$nd;
else if($type=="RH") $rh=$rh-$nd;
else if($type=="EL") $el=$el-$nd;
$qry3="update Profile SET CL='".$cl."',RL='".$rh."',EL='".$el."' where Faculty_Id='$fid'";
$res1=mysqli_query($con,$qry3);
if($res1){ echo "500";}
else echo "402";
}
else echo "401";
}
else
echo "500";
}
else
echo "Encountered an Error";
}
mysqli_close($con);
?>