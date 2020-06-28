var sid=prompt("Enter Sid");
var role=prompt("Enter Role");
var lids=new Array();
$.post("laprvlist.php",{Sid:sid,Role:role},function(data,status){
	  document.getElementById('list').innerHTML=data;
   });
$.post("aprvhistory.php",{Sid:sid,Role:role},function(data,status){
	  document.getElementById('history').innerHTML=data;
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
		var lid=p.find('.lid').val();
        $.post("updatestatus.php",{Lid:lid,Rjrsn:'',St:1,Role:role},function(data,status){
			console.log(data);
			if(data=="500")
             p.remove();		 
		});		
		
	});
	$('.rjsbtn').click(function(){
		$(this).button('loading');
		var p=$(this).closest('.panel-google-plus');
        p.find('.sbtn').attr('disabled','disabled');
		var lid=p.find('.lid').val();
        $.post("updatestatus.php",{Lid:lid,Rjrsn:p.find(".rjrsn").val(),St:2,Role:role},function(data,status){
			console.log(data);
			if(data=="500")
             p.remove();		 
		});		
		
	});
	$('.search').on('input',function(){
        var input=$(this).val();
		$('.litem').each(function(){
			var cval = $(this).find('.fname').text();
			var dpt = $(this).find('.dept').val();
			if((cval.toUpperCase().indexOf(input.toUpperCase()))==0||(dpt.toUpperCase().indexOf(input.toUpperCase()))==0)
			$(this).fadeIn('slow');
			else
			$(this).fadeOut('slow');
		});
    });
	$('#acpt').click(function(){
		$('.litem').each(function(){
			if($(this).is(':visible')){
			var cls = $(this).find('.label').attr('class');
            if(cls.indexOf("label-success")!=-1)
			$(this).fadeIn('slow');
            else
			$(this).fadeOut('slow');		
			}			
		});
    });
	$('#rjct').click(function(){
        $('.litem').each(function(){
			if($(this).is(':visible')){
			var cls = $(this).find('.label').attr('class');
            console.log(cls);
			if(cls.indexOf("label-danger")!=-1)
			$(this).fadeIn('slow');			
			else
			$(this).fadeOut('slow');
			}	
		});
    });
	$('#selectall').click(function(){
        var cbox=document.getElementsByClassName('cbox');
		for(var i=0;i<cbox.length;i++){
			cbox[i].checked= ! cbox[i].checked;
		}$('.history').toggle(false);
    });
	$('#delete').click(function(){
		$(this).data('loading-text','Deleting...');
		$(this).button('loading');
		var context=this;
		$('.cbox').each(function(){
			if($(this).is(":checked")){
			var p=$(this).closest('.litem');
			var lid=p.find('.lid').val();
			lids.length+=1;
			lids[lids.length-1]=lid;
			}
		});
		$.post("deletelaprv.php",{LeaveIds:JSON.stringify(lids),Role:role},function(data,status){
			if(data=="500")
			{   $(context).button('reset');
		        alert("Deleted Successfully");
				location.reload();
			}else{
				alert("Encountered an error");
			}
		});
    });
	
}