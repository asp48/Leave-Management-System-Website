$(document).ready(function(){
	$('#rsetbtn').on('click',function(){
		if(confirm("Are you sure to perform this action?"))
			$.post('resetleave.php',{Fid:'ES123'},function(data,status){
				alert(data);
			if(data=='500')
			{
				alert("Reset Successfully");
				$('.jumbotron').hide();
			}
            else
                 alert("Encountered an Error");				
			});
	});
});