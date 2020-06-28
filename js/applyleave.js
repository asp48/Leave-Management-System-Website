var ncl,nrh,nel,list,reason,altrnrow;
$(document).ready(function(){        
	var i=0,response="",d="",endates1="0",endates2="0";
	facid="CS015";//prompt("Enter FID");
	suid="CS013";//prompt("Enter SID");
	cl=2;//prompt("Enter CL");
	rh=2;//prompt("Enter RH");
	el=2;//prompt("Enter EL");
	$('.jumbotron').hide();
	dept=prompt("Enter Dept");
	role=prompt("Enter Role");
	$.post("getfaclist.php",{Dept:dept,Role:role},function(data,status){
	list=JSON.parse(data);
	setfaclist($('.add').closest('.alternative').find('.flist').last());
	settime($('.add').closest('.alternative').find('.tfrom').last());
	settime($('.add').closest('.alternative').find('.ttill').last());
	setsections($('.add').closest('.alternative').find('.sec').last());
	$( ".alton" ).datepicker({dateFormat:'yy-mm-dd',minDate:$('#from').val(),maxDate:$('#to').val(),beforeShowDay:disablesunday});
	});
	changend();
	var dt=new Date();
	numdays(5);
	dt.setDate(dt.getDate()+15);
	$('#to').attr('disabled','disabled');
	$( "#to" ).datepicker({onSelect:vdays,dateFormat:'yy-mm-dd',minDate:0,maxDate:dt,beforeShowDay:disablesunday});
    $( "#on" ).datepicker({dateFormat:'yy-mm-dd',minDate:0,maxDate:dt,beforeShowDay:disablesunday});
	$( "#from" ).datepicker({onSelect:function(){$('#to').attr('disabled',false);setalton();}
	,dateFormat:'yy-mm-dd',minDate:0,maxDate:dt,beforeShowDay:disablesunday});
      document.getElementById('typel').onchange=function(){
	  var index=this.selectedIndex;
	  alert("sda");
	  console.log(this.options[index].value);
	  var opt=document.createElement('option');
	  $('#rsn').empty();
	  $('#orsn textarea').val('');
	  $('#orsn').hide();
	  switch(index){ 
		  case 3:opt.appendChild(document.createTextNode('Valuation'));
		         document.getElementById('rsn').appendChild(opt);
				 opt=document.createElement('option');
				 opt.appendChild(document.createTextNode('Squad'));
		         document.getElementById('rsn').appendChild(opt);
				 opt=document.createElement('option');
				 opt.appendChild(document.createTextNode('University Duties'));
		         document.getElementById('rsn').appendChild(opt);
				 opt=document.createElement('option');
				 opt.appendChild(document.createTextNode('Other'));
		         document.getElementById('rsn').appendChild(opt);
				 break;
		  case 4:opt.appendChild(document.createTextNode('Seminar'));
		         document.getElementById('rsn').appendChild(opt);
				 opt=document.createElement('option');
				 opt.appendChild(document.createTextNode('Workshop'));
		         document.getElementById('rsn').appendChild(opt);
				 opt=document.createElement('option');
				 opt.appendChild(document.createTextNode('FDP'));
		         document.getElementById('rsn').appendChild(opt);
				 opt=document.createElement('option');
				 opt.appendChild(document.createTextNode('SDP'));
		         document.getElementById('rsn').appendChild(opt);
				 opt=document.createElement('option');
				 opt.appendChild(document.createTextNode('Paper Presentation'));
		         document.getElementById('rsn').appendChild(opt);
				 opt=document.createElement('option');
				 opt.appendChild(document.createTextNode('Other'));
		         document.getElementById('rsn').appendChild(opt);
				 break;
		default:opt.appendChild(document.createTextNode('Function'));
		         document.getElementById('rsn').appendChild(opt);
				 opt=document.createElement('option');
				 opt.appendChild(document.createTextNode('Not Feeling Well'));
		         document.getElementById('rsn').appendChild(opt);
				 opt=document.createElement('option');
				 opt.appendChild(document.createTextNode('Other'));
		         document.getElementById('rsn').appendChild(opt);
				 break;
	  }
	  numdays(5);
	  if(this.options[index].value!="CL"){
		  $('#on').val('');
		  $('#ppl input[name="pp"]').each(function(){
			  $(this).attr('checked',false);
		  });
		  $('#onl').hide();
		  $('#ppl').hide();
		  $('#hfd').hide();
		  $('#froml').show();
		  $('#tol').show();
		  $('#to').attr('disabled','disabled');
      }else{
		  numdays(ncl);
		  $('#hfd').show();
		  document.getElementById('ff').checked=true;
	  }
	  if(this.options[index].value=="OOD"){
		  $('#fal').show();
	  }else{
		  $('#fa').each(function(){
			 $(this).attr('checked',false);
		  });
		  $('#amt').val('');
		  $('#fal').hide();
		  $('#amtl').hide();
	  }if(this.options[index].value=="RH"){
		  numdays(nrh);
		  $.get("getRHDates.php",function(dates,status){
			  dates=JSON.parse(dates);
			  endates1=dates.Results[0].Dates.split("-");
			  endates2=dates.Results[1].Dates.split("-");
			  $('#from').datepicker('destroy');
		      $('#to').datepicker('destroy');
			  console.log(dt);
			  $( "#to" ).datepicker({onSelect:vdays,dateFormat:'yy-mm-dd',beforeShowDay:enablespecificdates,minDate:0,maxDate:dt});
	          $( "#from" ).datepicker({onSelect:function(){$('#to').attr('disabled',false);setalton();},dateFormat:'yy-mm-dd',beforeShowDay:enablespecificdates,minDate:0,maxDate:dt});
		  });
	  }else{
		  $('#from').datepicker('destroy');
		  $('#to').datepicker('destroy');
		  $( "#to" ).datepicker({onSelect:vdays,dateFormat:'yy-mm-dd',minDate:0,maxDate:dt,beforeShowDay:disablesunday});
	      $( "#from" ).datepicker({onSelect:function(){$('#to').attr('disabled',false);setalton();},dateFormat:'yy-mm-dd',minDate:0,maxDate:dt,beforeShowDay:disablesunday});
	  }if(this.options[index].value=="EL"){
		  numdays(nel);
	  }
  }
  document.getElementById('rsn').onchange=function(){
	  var index=this.selectedIndex;
	  var reason=this.children[index].innerHTML.trim();
	  if(reason=="Other")
		  $('#orsn').show();
	  else {$('#orsn textarea').val('');$('#orsn').hide();}
  }
  $('#fa').change(function(){
	  $('#amtl').toggle($(this).checked);
  });
  $('#hfd input:radio').click(function(){
	  if($('input[name=period]:checked').val()==0){
		  $('#onl').show();
		  $('#ppl').show();
		  $('#from').val('');
		  $('#to').val('');
		  $('#froml').hide();
		  $('#tol').hide();
		  numdays(0.5);
	  }else{
		  $('#on').val('');
		  $('#ppl input[name="pp"]').each(function(){
			  $(this).attr('checked',false);
		  });
		  $('#onl').hide();
		  $('#ppl').hide();
		  $('#froml').show();
		  $('#tol').show();
		  $('#to').attr('disabled','disabled');
		  numdays(ncl);
	  }    
  });
  $('.add').click(function(){
     $('.alternative').append(GetDynamicRow());	
     var p=$(this).closest('.alternative');
     var flist=p.find('.flist').last();
     setfaclist(flist);
     settime(p.find('.tfrom').last());
     settime(p.find('.ttill').last());
     setsections(p.find('.sec').last());
     p.find('.alton').last().datepicker({dateFormat:'yy-mm-dd',minDate:$('#from').val(),maxDate:$('#to').val(),beforeShowDay:disablesunday});	 
  });
  $(document).on('click','.remove',function(){
	  $(this).closest('.altrow').remove();	 
  });
  function enablespecificdates(date){
	  var d=jQuery.datepicker.formatDate('dd',date);
	  var m=jQuery.datepicker.formatDate('mm',date);
	  var cm=(new Date()).getMonth()+1;
	  if(disablesunday(date)){
	  if(cm==m){
		  if(endates1.indexOf(d)!=-1)
			  return [true];
		  else return [false];
	  }else if((1+(cm%12))==m){
		  if(endates2.indexOf(d)!=-1)
			  return [true];
		  else return [false];
	  }else return [false];
	  }else return [false];
  }
  function disablesunday(date){
	  var day=date.getDay();
	  if(day!=0)return[true];
	  else return [false];
  }
  function setalton(){
	$(".alton").each(function(){
		$(this).datepicker('destroy');
		$(this).datepicker({dateFormat:'yy-mm-dd',minDate:$('#from').val(),maxDate:$('#to').val(),beforeShowDay:disablesunday});
	});
 }
 function vdays(){
	      setalton();
		  var toD = new Date($('#to').val().replace(/-/g,'\/'));
		  var fromD = new Date($('#from').val().replace(/-/g,'\/'));
		  var diff=Math.abs(toD.getTime()-fromD.getTime());
		  diff=Math.ceil(diff/(1000*60*60*24));
		  diff++;
		  var max=$('#nd option:last-child').val();
		  $('.ivnd').hide();
		  if(diff>max){
			  $(this).after("<div class='ivnd'><font color='red'>Number of days more than available leaves</font></div>");
		      $('#to').val('');
			  document.getElementById('nd').value=$('#nd option:first-child').val();
		  }else if(diff<=0){
			  $(this).after("<div class='ivnd'><font color='red'>Invalid Dates</font></div>");
		      $('#to').val('');
			  document.getElementById('nd').value=$('#nd option:first-child').val();
		  }
		  else{
			  document.getElementById('nd').value=diff;
		  }
  }
  $('#apply').click(function(){
	  if(validate())
	  {
		    console.log(JSON.stringify(altrnrow)+"");
	 $.post("applyleave.php",{
		 Fid:document.forms[0].Fid.value,
         Sid:document.forms[0].Sid.value,
         typl:document.forms[0].typel.value,
         fromD:document.forms[0].fromD.value,
         toD:document.forms[0].toD.value,
         onD:document.forms[0].onD.value,
         ndays:document.forms[0].ndays.value,
         reason:reason,
         alt:JSON.stringify(altrnrow),
         fasst:Number(document.forms[0].fasst.checked),
         amt:document.forms[0].amt.value,
         pp:document.forms[0].pp.value
	 },function(data,status){
		 if(data=='500'){
		 alert("Your application has been submitted successfully");
		 $('#application').hide();
		 $('.jumbotron').show();
		 }else{
			if(confirm("Your application has not been submitted successfully. Press Ok to Retry"))
                   $('#apply').click();				
		 }
	 });
   }	 
  });
  function validate(){
	  var flag=true,c=0;
	 $('.error').hide();
	 $('#fid').val(facid);
	 console.log("facid "+$('#fid').val());
	 $('#sid').val(suid);
	 console.log("sid "+$('#sid').val());
	 /*$('.dates').each(function(){
		if($(this).val().match()){
			flag=false;
			$(this).after("<div class='error'><font color='red'>Invalid Date</font></div>");
		}
	 });*/
     if($('#orsn').is(':hidden')){
		reason=$('#rsn').val();
	 }else{
	    reason=$('#orsn').find('textarea').val();
	 }
	 $('input[type="text"]').each(function(){
		if($(this).is(':visible')){
			if($(this).val().length==0)
			{$(this).after("<div class='error'><font color='red'>This field cannot be left empty</font></div>");
		     flag=false;
		    }
		}else{
			$(this).disabled=true;
		}
	 });	 
	 setaltrow();
	  return flag;
  }
});
 function numdays(max){
	 $('#nd').empty();
	 if(max==0.5){
		 var opt=document.createElement('option');
	 opt.setAttribute('value','0.5');
	 opt.appendChild(document.createTextNode('0.5'));
	 document.getElementById('nd').appendChild(opt);
	 return true;
	 }
	 for(var j=1;j<=max;j++){
     var opt=document.createElement('option');
	 opt.setAttribute('value',j);
	 opt.appendChild(document.createTextNode(j));
	 document.getElementById('nd').appendChild(opt);
	 }
 }
 function changend(){
	 if(cl==0)
		 $('#typel option[value="CL"]').remove();
	 else {ncl=(cl>5)?5:cl;}
	 if(rh==0)
		 $('#typel option[value="RH"]').remove();
	 else {nrh=rh;}
	 if(el==0)
		 $('#typel option[value="EL"]').remove();
	 else {nel=(el>5)?5:el;}
 }
 function setfaclist(context){
     for(var i=0;i<list.Results.length;i++){
		console.log(list.Results[i].Name+' '+list.Results[i].Faculty_Id);
     context.append($('<option></option>').val(list.Results[i].Name).html(list.Results[i].Name));
	 }		
 }
 function setsections(context){
     for(var i=1;i<=10;i++)
		 for(var j=0;j<4;j++)
           context.append($('<option></option>').val(i+' '+String.fromCharCode(65+j)).html(i+' '+String.fromCharCode(65+j)));
 }
 function settime(context){
	 context.append($('<option></option>').val('8:00am').html('8:00am'));
	 context.append($('<option></option>').val('8:55am').html('8:55am'));
	 context.append($('<option></option>').val('9:50am').html('9:50am'));
	 context.append($('<option></option>').val('10:45am').html('10:45am'));
	 context.append($('<option></option>').val('11:15am').html('11:15am'));
	 context.append($('<option></option>').val('12:10pm').html('12:10pm'));
	 context.append($('<option></option>').val('01:05pm').html('01:05pm'));
	 context.append($('<option></option>').val('02:00pm').html('02:00pm'));
	 context.append($('<option></option>').val('02:55pm').html('02:55pm'));
	 context.append($('<option></option>').val('03:50pm').html('03:50pm'));
	 context.append($('<option></option>').val('04:45pm').html('04:45pm'));
 }
 function GetDynamicRow(){
	 return '<div class="altrow"><div class="col-lg-3"><select class="form-control flist" name="alt"><option>Select Faculty</option>'+
			'</select></div><div class="col-lg-2"><input type="text" class="form-control alton" placeholder="On"/></div>'+
			'<div class="col-lg-2"><select class="form-control tfrom"><option>From</option></select></div>'+
            '<div class="col-lg-2"><select class="form-control ttill"><option>Till</option></select></div>'+
			'<div class="col-lg-1"><select class="form-control sec"><option>Class</option></select></div>'+
			'<div class="col-lg-1"><button type="button" class="btn btn-danger remove">-</button></div></div>';		 
 }
 function setaltrow(){
	 altrnrow={};
	 $('.altrow').each(function(){
		altrnrow[list.Results[$(this).find('.flist option:selected').index()-1].Faculty_Id]=
            $(this).find('.alton').val()+'/'+$(this).find('.tfrom').val()+'/'+$(this).find('.ttill').val()+
            '/'+$(this).find('.sec').val();
		console.log(altrnrow[list.Results[$(this).find('.flist option:selected').index()-1].Faculty_Id]);
	 });
 }