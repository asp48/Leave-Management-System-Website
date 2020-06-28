<?php
$con=mysqli_connect("localhost","bms","teacher123","LMS");
 
if (mysqli_connect_errno($con))
{
   echo "400";
}
else {
$sid=$_POST['Sid'];
$role=$_POST['Role'];
if($role=="VP")
$qry="SELECT Name,a.Faculty_Id,Designation,Department,Imageurl,LeaveId,Applied_On,Type,FromD,ToD,NoDays,Reason,Alternate,OnD,PR_POL,FAssist,FAmount,Status,RjReason,ByHOD,ByVP,Approve_HOD,Approve_VP FROM profile as p,approve as a  WHERE p.Faculty_Id=a.Faculty_Id and a.ByVP!='0' and DF in('000','010','100','110') order by LeaveId DESC";
else
$qry="SELECT Name,a.Faculty_Id,Designation,Department,Imageurl,LeaveId,Applied_On,Type,FromD,ToD,NoDays,Reason,OnD,PR_POL,FAssist,FAmount,Status,RjReason,ByHOD,ByVP,Approve_HOD,Approve_VP FROM profile as p,approve as a  WHERE a.Super_Id='$sid' and p.Faculty_Id=a.Faculty_Id and a.ByHOD!='0' and a.DF in('000','001','100','101') order by LeaveId DESC";	
$res=mysqli_query($con,$qry);
$result='';
if($res){
while($row=mysqli_fetch_array($res)){
$result=$result.'<tr class="litem"><td class="text-center"><input type="checkbox" class="cbox"/></td>
         <td><div class="col-sm-12">
         <div class="row"><div class="[ panel panel-default ] panel-google-plus">
         <div class="panel-body">
		 <div class="col-sm-2">
		 <img width="100%" class="img-responsive center-block" src="'.$row["Imageurl"].'" alt="Missing" />
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
					<table class="table table-bordered table-hover table-striped" style="padding-right:-100px;">
					<tbody>
					<tr>
					   <th>Type of Leave</th>
					   <td>'.$row["Type"].'</td>
					</tr>';
			if($row["OnD"]=="0000-00-00")
	$result=$result.'<tr>
					   <td>From</td>
					   <td>'.$row["FromD"].'</td>
					</tr>
					<tr>
					   <td>To</td>
					   <td>'.$row["ToD"].'</td>
					</tr>';
			else{ 
	$result=$result.'<tr>
					   <td>On</td>
					   <td>'.$row["OnD"].'</td>
					</tr>
					<tr>
					   <td>Pre-Lunch/Post-Lunch</td>';
					if($row["PR_POL"]=="1")
    $result=$result.'<td>Pre-Lunch</td></tr>';
            else
    $result=$result.'<td>Post-Lunch</td></tr>';
			}      
    $result=$result.'<tr>
					   <td>No of Days</td>
					   <td>'.$row["NoDays"].'</td>
					</tr>';
					if($row["Type"]=="OOD"){
						if($row["FAssist"]=="1")
	$result=$result.'<tr>
					   <td>Financial Assistence</td>
					   <td>Yes</td>
					</tr>
                    <tr>
					   <td>Amount</td>
					   <td>'.$row["FAmount"].'</td>
					</tr>';					
					     else	
	$result=$result.'<tr>
					   <td>Financial Assistence</td>
					   <td>No</td>
					</tr>';
                    }
	$result=$result.'<tr>
					   <td>Reason</td>
					   <td>'.$row["Reason"].'</td>
					</tr>
					<tr>
					<td>Approved by HOD</td>
					   <td>'.$row["Approve_HOD"].'</td>
					</tr>';
					if($row["ByVP"]=="0"){
	$result=$result.'<td>Approved by VP</td>
					   <td>------</td>
					</tr>';					
					}else{
	$result=$result.'<td>Approved by VP</td>
					   <td>'.$row["Approve_VP"].'</td>
					</tr>';
					}
					if($row["Status"]=="2"){
	$result=$result.'<tr>
					   <td>Reason for Rejection</td>
					   <td>'.$row["RjReason"].'</td>
					</tr>';					
					}
	$result=$result.'<tr colspan="2">
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
	$result=$result.'
	                </tr></tbody>
					</table>
                    </div>
                </div>
            </div>
        </div>				
            </div>
        </div>
		</div>
		</td>';
    if($role=="HOD"){    
		if($row["ByHOD"]=="1")
    $result=$result.'<td class="text-center"><span class="label label-success">Accepted</span></td></tr>';
		else
    $result=$result.'<td class="text-center"><span class="label label-danger">Rejected</span></td></tr>';
    }else{
		if($row["ByVP"]=="1")
    $result=$result.'<td class="text-center"><span class="label label-success">Accepted</span></td></tr>';
		else
    $result=$result.'<td class="text-center"><span class="label label-danger">Rejected</span></td></tr>';
	}
}
echo $result;
}
else echo '<div class="text-center">NO RESULTS</div>';
}
mysqli_close($con);
?>