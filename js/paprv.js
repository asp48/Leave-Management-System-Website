var sid=prompt("Enter Sid");
var role=prompt("Enter Role");
var lids=new Array();
$.post("paprvlist.php",{Dept:'CSE',Role:role},function(data,status){
	  document.getElementById('list').innerHTML=data;
	  runscript();
   });
function runscript(){
	 var $panel="",$comment="";
	 var panels = $('.user-infos');
     panels.hide();
   $('.reject').on('click', function(event) {
        $panel = $(this).closest('.panel-google-plus');
        $comment = $panel.find('.panel-google-plus-comment');
     
        $comment.find('.btn:first-child').addClass('disabled');
        
        $comment.show();
        
        if ($panel.hasClass('panel-google-plus-show-comment')) {
            $comment.find('textarea').focus();
        }
   });
   $('.cancel').on('click', function(event) {
	  $comment.hide();
    });
   $('.panel-google-plus-comment > .panel-google-plus-textarea > textarea').on('keyup', function(event) {
        $comment.find('button[type="submit"]').addClass('disabled');
        if ($(this).val().length >= 1) {
            $comment.find('button[type="submit"]').removeClass('disabled');
        }
   });
    //Click dropdown
    $('.down').click(function(event) {
        var idFor=$(this).closest('.panel-google-plus').find('.user-infos');
        //current button
        var currentButton = $(this);
        idFor.slideToggle(400, function() {
            if(idFor.is(':visible'))
            {
                currentButton.html('<i class="[ glyphicon glyphicon-chevron-up ] text-muted"></i>');
				idFor.show();
            }
            else
            {    
		        currentButton.closest('.panel-google-plus').find('.panel-google-plus-comment').hide();
                currentButton.html('<i class="[ glyphicon glyphicon-chevron-down ] text-muted"></i>');
            }
        })
    });
	$('.sbtn').click(function(){
		$(this).button('loading');
		var p=$(this).closest('.panel-google-plus');
        p.find('.reject').attr('disabled','disabled');
		var fid=p.find('.Fid').text();
		var cl=p.find('.CL  input').val();
		var rh=p.find('.RH  input').val();
		var el=p.find('.EL  input').val();
        $.post("addprofile.php",{
			Fid:fid,
			Sid:sid,
			CL:cl,
			RH:rh,
			EL:el,
			Content:'',
			Status:1},
			function(data,status){
			console.log(data);
			if(data=="500501"){
             p.remove();
             alert("Updated Successfully");			 
            }else{
		     alert("Encountered an Error");
			}
		});		
	});
	$('.rjsbtn').click(function(){
		$(this).button('loading');
		var p=$(this).closest('.panel-google-plus');
        p.find('.sbtn').attr('disabled','disabled');
		var fid=p.find('.Fid').text();
		var cl=p.find('.CL  input').val();
		var rh=p.find('.RH  input').val();
		var el=p.find('.EL  input').val();
        $.post("addprofile.php",{
			Fid:fid,
			Sid:sid,
			CL:cl,
			RH:rh,
			EL:el,
			Content:p.find(".rjrsn").val(),
			Status:2},
			function(data,status){
			console.log(data);
			if(data=="501"){
             p.remove();
             alert("Updated Successfully");			 
            }else{
		     alert("Encountered an Error");
			}
		});		
	});
	$('.search').on('input',function(){
        var input=$(this).val();
		$('.litem').each(function(){
			var cval = $(this).find('.fname').text();
			var dpt = $(this).find('.dept').text();
			if((cval.toUpperCase().indexOf(input.toUpperCase()))==0||(dpt.toUpperCase().indexOf(input.toUpperCase()))==0)
			$(this).fadeIn('slow');
			else
			$(this).fadeOut('slow');
		});
    });
}