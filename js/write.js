$(document).ready(function(){
	//checks to see if title and content box are filled
	$("#submit").click(function(event){
		var title = $("#title").val();
		var content  = $("#text_content").val();
		
		if(title.length == 0 || content.length == 0){
			alert("Write Stuff!");
			event.preventDefault();
		}else if(title == "title"){
			alert("Please change title");
			event.preventDefault();
		}				
	});

	$("#link_submit").click(function(event){
		var link_title = $("#link_title").val();
		var link_url   = $("#link_url").val();
		
		if(link_title.length == 0 || link_url.length == 0){
			alert("Please fill out form");
			event.preventDefault();
		}else if(link_title == "title" || link_url == "your url"){
			alert("Please change default values");
			event.preventDefault();
		}
	});

});	
