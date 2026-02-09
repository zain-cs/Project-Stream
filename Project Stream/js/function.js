$(document).ready(function(){
	$(document).on("click","#icon",function(){
		$(".topMemSec .dropDown").slideToggle("fast");
	});	
	
	//for dashboard sections
	$(document).on("click",".leftNav ul li",function(){
		$(".leftNav ul li").removeClass("active");
		var myId = $(this).attr("id").split("-");
		$(this).addClass("active");
		$(".expandPnl").slideUp("fast");
		$("#expand-"+myId[1]).slideDown("fast");
	});
});