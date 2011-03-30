$(document).ready(function(){
	//opens status update box on click
	$("#status_change").click(function(event){
			$("#statusUpdate").show('fast');
		});
	
	//closes status update window
	$("#close_status").click(function(event){
		$("#statusUpdate").hide('slow');
	});
	
	//opens change pic form
	$("#changePic").click(function(event){
		$("#changePicForm").show('fast');
	});
	
	//closes change pic form
	$("#closePicForm").click(function(event){
		$("#changePicForm").hide('slow');
	});
	
});
