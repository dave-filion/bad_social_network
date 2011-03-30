$(document).ready(function(){
	
	$(".upvote").click(function(event){
		event.preventDefault();
		var id = $(this).attr("id");
		//necessary cause of the id string
		id = id.substring(2);
		id = "#" + id + "post";
		
		if($(id).hasClass("down"))
		{
			$(id).removeClass("down");
		}
		
		$(id).addClass("up");
		});

	$(".downvote").click(function(event){
		event.preventDefault();
		var id = $(this).attr("id");
		id = id.substring(4);
		id = "#" + id + "post";
		
		if($(id).hasClass("up"))
		{
			$(id).removeClass("up");
		}
				
		$(id).addClass("down");
		});
	
	
});
