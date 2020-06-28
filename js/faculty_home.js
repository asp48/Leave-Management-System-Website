$(document).ready(function(){
$.get("getDetails.php",function(response,status){
if(response=='420')
	window.location="modify.html";
initialize(response);
});
function initialize(response){
	var data=JSON.parse(response);
	var role=data[0].Role;
	document.getElementById('name').innerHTML='<i class="fa fa-fw fa-user"></i> '+data[0].Name+' <b class="caret"></b>';
switch(role){
	case 'VP' : $('#apply_leave').hide();
	            $('#history').hide();
				$('#notification_panel').hide();
				break;
	case 'NT' :
	case 'P'  : $('#profile_aprv').hide();
	            $('#leave_aprv').hide();
				$('#onleave').hide();
				break;
	case 'HOD' :break;
	default   : $('.container-fluid').hide();
}	
if(role=='HOD' || role=='NT' || role=='P'){	
$.get("getnotifications.php",function(data,status){
	var temp=data.split(';');
	document.getElementById('n_count').innerHTML=temp[0];
	document.getElementById('notifications').innerHTML=temp[1];
});
}	
}
$.get("getSchedules.php",function(data,status){
	var temp=data.split(';');
	document.getElementById('s_count').innerHTML=temp[0];
	document.getElementById('schedules').innerHTML=temp[1];
}); 	 
});