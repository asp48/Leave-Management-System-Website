<?php
session_start();
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
$fid=$_SESSION["CurrentID"];
$qry='select * from approve a where Faculty_Id="'.$fid.'" and a.Read=0 and NOT(Status=0)';
$res=mysqli_query($con,$qry);
$result='';
$i=0;
if($res && mysqli_num_rows($res)>0){
$result=mysqli_num_rows($res).';';	
while($row=mysqli_fetch_array($res)){
$lid=$row["LeaveId"];
$i++;
$class=($row["Status"]==1)?'alert-success':'alert-danger';
$result .= '<div class="alert '.$class.'">
	<strong>'.$i.'</strong> Your leave ';
	if($row["OnD"]=="0000-00-00")
		$result .= "  From ".$row["FromD"]." To ".$row["ToD"];
	else {
		$result .= "  On ".$row["OnD"];
		if($row["PR_POL"]=="1")
			$result .= "(Pre-Lunch)";
		else
			$result .= "(Post-Lunch)";
	}
	if($row["Status"]==1)
		$result .= " got accepted. ";
	else
		$result .= " got rejected. ";
	$result .= " <a href=''> View Details  </a></div>";
$qry2="update approve a set a.Read=1 where LeaveId=".$lid;
mysqli_query($con,$qry2);
}
echo $result;
}
else
	echo '0;<div class="text-center">No Results</div>';
mysqli_close($con);
?>