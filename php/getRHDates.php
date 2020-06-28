<?php
$con=mysqli_connect("localhost","bms","teacher123","LMS"); 
if (mysqli_connect_errno($con))
{
   echo "400";
}
else {
$m=date("m");
$m2=1+($m)%12;
$qry="select Dates from rhdates where Month='".$m."' or Month='".$m2."'";
$res=mysqli_query($con,$qry);
$result=array();
if($res){
while($row=mysqli_fetch_array($res))
array_push($result,array('Dates'=>$row[0]));
}
echo json_encode(array('Results'=>$result));
}
mysqli_close($con);
?>
