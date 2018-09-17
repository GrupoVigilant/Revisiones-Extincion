$(function(){
	$("#access-btn").live("click",function() {
		$("#login-dlg").show();
		
		var position=$("#login-dlg").position();
		
		$("#login-dlg").css("top",1000);
		$("#login-dlg").animate({"top" :position.top+"px"},1000);
		
		
		return false;
	})
})
