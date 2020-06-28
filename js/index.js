$(document).ready(function(){
    $('#result').empty();
	var facid=$('#fid');
    var heading="<tr><th>Applied On</th><th>Type</th><th>From</th><th>To</th><th>On</th>"+
		"<th>Halfday</th><th>No Days</th><th>Reason</th><th>Alternate</th><th>Financial Assistance</th>"+
		"<th>Amount</th><th>Approved by HOD</th><th>Approved by VP</th></tr>";
    $('#fid').keypress(function(e){
		var x = e.keyCode||e.which;
        if (x == 13){
			$('#result').empty();
            document.getElementById('submit').click();
			return false;
		}			
	});
    $('#submit').click(function() {
     $.get("post.php?Fid="+facid.val(), function(data, status) {
	  if(data){
        d=JSON.parse(data);
	    i=0;
		$('#np').hide();
		$('#pp').hide();
		$('#print').show();
		if(d.Results.length<=0){
			$('#print').hide();
			document.getElementById('result').innerHTML='<tr><td>No Results Found</td></tr>';
		}else{
			response=heading;
			response+=d.Results[0].Row;
		    document.getElementById('result').innerHTML=response;
			if(d.Results.length>1){
			$('#np').show();
			$('#pp').show();
			document.getElementById('pp').disabled=true;
			document.getElementById('np').disabled=false;
			}
		}
	  }
      else
        document.getElementById('result').innerHTML='Error';
    });
  });
    $('#np').click(function(){
	 i=i+1;
	 if(i==d.Results.length-1)
		 this.disabled=true;
      document.getElementById('pp').disabled=false;
	  $('#result').empty();response=heading;
	  response+=d.Results[i].Row;
	  console.log(response);
	  document.getElementById('result').innerHTML=response;  
  });
  $('#pp').click(function(){
	 i=i-1;
	 if(i==0)
		 this.disabled=true;
	 document.getElementById('np').disabled=false;
	  $('#result').empty();response=heading;
	  response+=d.Results[i].Row;
	  console.log(response);
	  document.getElementById('result').innerHTML=response;  
  });
  });
