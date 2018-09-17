$(function() {
	var currentPage=new Number($('#pager h4 .current-page').text());
	var totalPages=new Number($('#pager h4 .total-pages').text());
	
	var wheel={};
	
	for(i=1;i<=totalPages;i++) {
		wheel[i]=i;		
	}
	
	
	
	$('#pager h4').scroller({
		theme : 'sense_ui',		
		width: 160,
		wheels : [ { 
			'PÃ¡gina': 
				wheel//{ x: 'x', y: 'y', z: 'z' } 
			}],
		onClose: function(valueText) {
			alert("PÃ¡gina seleccionada: "+valueText+"\nModificar este evento en js/pager.js")
		},
		setText : "Saltar",
		cancelText : "Cancelar"		
	});			
	
	$('#pager h4').scroller('setValue', [currentPage]);
	
});

