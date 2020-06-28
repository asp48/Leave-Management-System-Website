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
$fid = $_GET["Fid"];
$qry="select * from approve where Faculty_Id='".$fid."' and Status=1";
$result = $con->query($qry);
$res=array();
$i=0;$temp="";
 if ($result->num_rows > 0) {
    while($row = mysqli_fetch_array($result)) {
        $temp=$temp."<tr align=center><td>$row[1]</td><td>$row[4]</td><td>$row[5]</td><td>$row[6]</td>
		<td>$row[10]</td><td>$row[11]</td><td>$row[7]</td><td>$row[8]</td><td>$row[9]</td><td>$row[12]</td>
        <td>$row[13]</td><td>$row[18]</td><td>$row[19]</td></tr>";
		$i=$i+1;
		if($i%10==0){
		array_push($res,array("Row"=>$temp));
		$temp="";
		}
    }if($i%10!=0){
		array_push($res,array("Row"=>$temp));
	}
 }
	echo json_encode(array("Results"=>$res));
$con->close();
?>
