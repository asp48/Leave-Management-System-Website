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
$dept='CSE';
$role='HOD';
/*$dept=$_POST['Dept'];
$role=$_POST['Role'];*/
if($role=="VP")
$qry="SELECT * FROM profile_approve WHERE Designation='HOD'";
else //($role=="HOD")
$qry="SELECT * FROM profile_approve WHERE Department='".$dept."'";
$res=mysqli_query($con,$qry);
$result="";
if($res && $res->num_rows>0){
while($row=mysqli_fetch_array($res)){	
$result=$result.'<div class="row litem"><div class="[ panel panel-default ] panel-google-plus">
         <div class="panel-body">
		 <div class="col-sm-2">
		 <img width="100%" src="'.$row["Imageurl"].'" alt="Missing" />
         </div>
		 <div class="col-sm-10">
		 <h3 class="fname">'.$row["Name"].'</h3>
		 <h5><span>Applied On</span> - <span>'.$row["Applied_On"].'</span> </h5>
         <div class="down"><i class="[ glyphicon glyphicon-chevron-down ] text-muted"></i>
		 </div>
               </div></div>
				<div class="row-fluid user-infos">
                  <div class="span10 offset1">
                <div class="panel panel-primary">
                    <div class="panel-body">
					<table class="table table-bordered table-hover table-striped">
					<tbody>
					<tr>
					   <th>Name</th>
					   <td>'.$row["Name"].'</td>
					</tr>
			        <tr>
					   <th>Employee ID</th>
					   <td class="Fid" >'.$row["Faculty_Id"].'</td>
					</tr>
					<tr>
					   <th>Designation</th>
					   <td>'.$row["Designation"].'</td>
					</tr>
					<tr>
					   <th>Department</th>
					   <td class="dept">'.$row["Department"].'</td>
					</tr>
					<tr>
					   <th>Mobile</th>
					   <td>'.$row['Mobile'].'</td>
					</tr>
					<tr>
					   <th>Office Number</th>
					   <td>'.$row['OfficeNumber'].'</td>
					</tr>
					<tr>
					   <th>Email</th>
					   <td>'.$row['Email'].'</td>
					</tr>
					<tr>
					   <th>Address</th>
					   <td>'.$row['Address'].'</td>
					</tr>
					<tr class="CL">
					   <th>CL</th>
					   <td><input class="form-control" type="text" value="'.$row['CL'].'" /></td>
					</tr>
					<tr class="RH">
					   <th>RH</th>
					   <td><input class="form-control" type="text" value="'.$row['RH'].'" /></td>
					</tr>
					<tr class="EL">
					   <th>EL</th>
					   <td><input class="form-control" type="text" value="'.$row['EL'].'" /></td>
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
                        <textarea rows="2" placeholder="Mention Reason" class="rjrsn"></textarea>
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
