<?php
$con=mysqli_connect("localhost","bms","teacher123","LMS");
 
if (mysqli_connect_errno($con))
{
   echo "400";
}
else {
$lid=json_decode($_POST['LeaveIds'],true);
$role=$_POST['Role'];
for($i=0;$i<count($lid);$i++){
	$qry="select DF from approve where LeaveId='".$lid[$i]."'";
    $res=mysqli_query($con,$qry);
    $df=mysqli_fetch_object($res);
    if($role=="VP"){
    $df->DF[2]="1";
	$query="update alternate set vp_flag=1 where LeaveId=".$lid[$i]."";
	}
    else if($role=="HOD"){
    $df->DF[1]="1";
	$query="update alternate set h_flag=1 where LeaveId=".$lid[$i]."";
	}
    else{
	$df->DF[0]="1";
	$query="update alternate set f_flag=1 where LeaveId=".$lid[$i]."";
	}
    if($df=="111"){
		$qry="delete from approve where LeaveId='".$lid[$i]."'";
        $res=mysqli_query($con,$qry);
		if(!$res);
		{
		 mysqli_close($con);
		 exit("401");
		}
	}else{
		$qry="update approve set DF='"."$df->DF"."' where LeaveId='".$lid[$i]."'";
        $res=mysqli_query($con,$qry);
		if(!$res){
		    mysqli_close($con);
		    exit("401");
		}	
	}
	$res=mysqli_query($con,$query);
	if($res){
		$query="delete from alternate where f_flag=1 and r_flag=1 and h_flag=1 and vp_flag=1";
		$res=mysqli_query($con,$query);
	}else{
		exit("403");
	}
}
echo "500";
}
mysqli_close($con);
?>