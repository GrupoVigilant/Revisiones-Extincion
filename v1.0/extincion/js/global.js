$(document).ready(function() {
  	// disable ajax nav
  	//$.mobile.ajaxEnabled = false;
  	//$.mobile.ajaxLinksEnabled = false;  	
  	$.mobile.loadingMessage = "Actualizando";

  	
  	$("#save-btn").click(function(e) {
  		e.preventDefault()
  		
  		$("#myform").submit();
  		
  	});
  	
});





window.addEventListener("load",function() {
	setTimeout(function(){
		window.scrollTo(0, 1);
	}, 0);
});