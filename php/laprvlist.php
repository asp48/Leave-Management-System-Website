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
$sid='CS013';
$role='HOD';
/*$sid=$_POST['Sid'];
$role=$_POST['Role'];*/
if($role=="VP"||$role=="P")
$qry="SELECT Name,a.Faculty_Id,Designation,Department,Imageurl,a.LeaveId,Applied_On,Type,FromD,ToD,NoDays,Reason,OnD,PR_POL,FAssist,FAmount,Approve_HOD FROM Profile as p,approve as a  WHERE  p.Faculty_Id=a.Faculty_Id and a.Status='0' and (ByHOD='1' or Designation='HOD')";
else //($role=="HOD")
$qry="SELECT Name,a.Faculty_Id,Designation,Department,Imageurl,a.LeaveId,Applied_On,Type,FromD,ToD,NoDays,Reason,Alternate,OnD,PR_POL,FAssist,FAmount,Approve_HOD FROM Profile as p,approve as a  WHERE  a.Super_Id='".$sid."' and p.Faculty_Id=a.Faculty_Id and a.Status='0' and ByHOD='0'";
$res=mysqli_query($con,$qry);
$result="";
if($res && $res->num_rows>0){
while($row=mysqli_fetch_array($res)){	
$result=$result.'<div class="row litem"><div class="[ panel panel-default ] panel-google-plus">
         <div class="panel-body">
		 <div class="col-sm-2">
		 <img width="100%"  src="'.$row["Imageurl"].'" alt="Missing" />
         </div>
		 <div class="col-sm-10">
		 <h3 class="fname">'.$row["Name"].'</h3><h5><span>Applied On</span> - <span>'.$row["Applied_On"].'</span> </h5>
	     <div class="down"><i class="[ glyphicon glyphicon-chevron-down ] text-muted"></i>
		 </div>
               </div></div>
				<div class="row-fluid user-infos">
                  <div class="span10 offset1">
                <div class="panel panel-primary">
                    <div class="panel-body">
					<input type="hidden" value="'.$row["LeaveId"].'" class="lid"/>
					<input type="hidden" value="'.$row["Department"].'" class="dept"/>
					<table class="table table-bordered table-hover table-striped">
					<tbody>
					<tr>
					   <th>Type of Leave</th>
					   <td>'.$row["Type"].'</td>
					</tr>';
			if($row["OnD"]=="0000-00-00")
	$result=$result.'<tr>
					   <th>From</th>
					   <td>'.$row["FromD"].'</td>
					</tr>
					<tr>
					   <th>To</th>
					   <td>'.$row["ToD"].'</td>
					</tr>';
			else{ 
	$result=$result.'<tr>
					   <th>On</th>
					   <td>'.$row["OnD"].'</td>
					</tr>
					<tr>
					   <th>Pre-Lunch/Post-Lunch</th>';
					if($row["PR_POL"]=="1")
    $result=$result.'<td>Pre-Lunch</td></tr>';
            else
    $result=$result.'<td>Post-Lunch</td></tr>';
			}      
    $result=$result.'<tr>
					   <th>No of Days</th>
					   <td>'.$row["NoDays"].'</td>
					</tr>';
					if($row["Type"]=="OOD"){
						if($row["FAssist"]=="1")
	$result=$result.'<tr>
					   <th>Financial Assistence</th>
					   <td>Yes</td>
					</tr>
                    <tr>
					   <th>Amount</th>
					   <td>'.$row["FAmount"].'</td>
					</tr>';					
					     else	
	$result=$result.'<tr>
					   <th>Financial Assistence</th>
					   <td>No</td>
					</tr>';
                    }
	$result=$result.'<tr>
					   <th>Reason</th>
					   <td>'.$row["Reason"].'</td>
					</tr>
					<tr colspan="2">
					<table class="table table-bordered table-hover table-striped">
					<thead>
					<tr>
					<th class="text-center" colspan="5">Alternate</th>
					</tr><tr>
								     <th>Faculty</th>
									 <th>On</th>
									 <th>From</th>
									 <th>Till</th>
									 <th>Class</th></tr>
								</thead><tbody>';
	$query="select p.Name,a.OnD,FromT,Till,Class from profile p, alternate a where a.Faculty_Id = p.Faculty_Id and a.LeaveId=".$row["LeaveId"]."";
	$altres=mysqli_query($con,$query);
	while($altrow=mysqli_fetch_array($altres)){
	$result=$result.'<tr><td>'.$altrow["Name"].'</td><td>'.$altrow["OnD"].'</td><td>'.$altrow["FromT"].'</td><td>'.$altrow["Till"].'</td><td>'.$altrow["Class"].'</td></tr>';	
	}
	$result=$result.'</tbody>
					</table>
					</tr>
					</tbody>
					</table>
                    </div>
                    <div class="panel-footer text-right">
                       <button class="btn btn-success sbtn" type="button" data-loading-text="<i class=\'fa fa-refresh\'> Updating... </i>">Accept</button>
                       <button class="btn btn-danger reject" type="button">Reject</button>
                    </div>
                </div>
            </div>
        </div>
				<div class="panel-google-plus-comment">
                    <div class="panel-google-plus-textarea">
                        <textarea rows="2" placeholder="Mention Reason" id="rjrsn"></textarea>
                        <button type="submit" class="[ btn btn-success disabled ] rjsbtn" data-loading-text="<i class=\'fa fa-refresh\'> Updating... </i>" >Submit</button>
                        <button type="reset" class="[ btn btn-default ] cancel">Cancel</button>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>';
}
echo $result;
}
else echo '<div class="text-center">NO RESULTS</div>';
$con->close();
?>
