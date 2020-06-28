$(document).ready(function(){
	var dates=new Array(),i=0;
	var today=new Date();
	var cm=today.getMonth()+1;
	var year=today.getFullYear();
	var md=new Date(year,cm-1,+1);
	var mxd=new Date(year,cm,0);
	$('#M').val(cm);
	$( "#CD" ).datepicker({dateFormat:'dd',minDate:md,maxDate:mxd,beforeShowDay:disablesunday});
    $('#M').on('blur',function(){
	   var m=$(this).val();
	   if(m<cm){
		   md=new Date(year+1,m-1,+1);
	       mxd=new Date(year+1,m,0);
	   }
	   else{
		   md=new Date(year,m-1,+1);
	       mxd=new Date(year,m,0);
	   }
	   $('#CD').datepicker('destroy');
	   $( "#CD" ).datepicker({dateFormat:'dd',minDate:md,maxDate:mxd,beforeShowDay:disablesunday});
	});
	$('#plus').click(function(){
	dates[i++]=$("#CD").val();
	dates.sort();
	$("#SD").val(dates.join("-"));
    });
	function disablesunday(date){
	  var day=date.getDay();
	  if(day!=0)return[true];
	  else return [false];
  }
  $('#submit').click(function(){
	$.post('setrhd.php',{
		M:$('#M').val(),
		Dates:$('#SD').val()
		},
		function(data,status){
			if(data=='500')
			{
				alert("RH Dates updated successfully");
				document.getElementById('rhform').reset();
			}
			else alert("Encountered an Error");
		});  
		return false;
  });
});