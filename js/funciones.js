    // Variables para contener los sucesivos puntos (x,y) por los que va
    // pasando el ratón, y su estado (pulsado/no pulsado)
    var pulsado;
    var canvasDriv;
    var posicionAbsoluta;
    var longitudCanvas = 400;

    /**
    * Calcula la posición absoluta de un elemento (hay que pasarle el id)
    */
    function calcAbsoluteElementPosition(element) {
		if (typeof element == "string")
		    element = document.getElementById(element)
		    
		if (!element) return { top:0,left:0 };
		  
		var y = 0;
		var x = 0;
		while (element.offsetParent) {
			x += element.offsetLeft;
		    y += element.offsetTop;
		    element = element.offsetParent;
		}
		posicionAbsoluta = {top:y,left:x};
	}

    function pulsoDentro(touchX, touchY){
        if(touchX < posicionAbsoluta.left) return false;
        if(touchX > posicionAbsoluta.left + longitudCanvas) return false;
        if(touchY < posicionAbsoluta.top) return false;
        if(touchY > posicionAbsoluta.top + longitudCanvas) return false;
        return true;
    }

    function borrarFirma(){
        canvas.width = canvas.width;
    }

    function crearLienzo() {

        canvasDiv = document.getElementById('canvas');
        canvas = document.createElement('canvas');
        canvas.setAttribute('width', longitudCanvas);
        canvas.setAttribute('height', longitudCanvas);
        canvas.setAttribute('id', 'canvas');
        canvasDiv.appendChild(canvas);
        if(typeof G_vmlCanvasManager != 'undefined') {
            canvas = G_vmlCanvasManager.initElement(canvas);
        }
        context = canvas.getContext("2d");
        //Dejamos todo preparado para escuchar los eventos 
        document.addEventListener('touchstart',pulsaRaton,false); 
        document.addEventListener('touchmove',mueveRaton,false); 
        document.addEventListener('touchend',levantaRaton,false); 
        calcAbsoluteElementPosition("canvas");
    }
        
    function pulsaRaton(e){
        if(pulsoDentro(e.targetTouches[0].pageX, e.targetTouches[0].pageY))
            pulsado = true; 
        //Indico que vamos a dibujar 
        context.lineWidth = 6;
        context.beginPath(); 
        //Averiguo las coordenadas X e Y por dónde va pasando el ratón 
        context.moveTo(e.targetTouches[0].pageX - posicionAbsoluta.left,  e.targetTouches[0].pageY - posicionAbsoluta.top);
    }
     
    function mueveRaton(ev){
        
        if(pulsado){ 
            // Evitamos que se mueva la mantalla cuando movemos el dedo
            ev.preventDefault();

            //indicamos el color de la línea 
            context.strokeStyle='#000'; 
            //Por dónde vamos dibujando 
            context.lineTo(ev.targetTouches[0].pageX - posicionAbsoluta.left,  ev.targetTouches[0].pageY - posicionAbsoluta.top); 
            context.stroke(); 
          } 

    }
     
    function levantaRaton(e){

          //Indico que termino el dibujo 
          context.closePath(); 
          pulsado = false; 
    }
     
    function mouseleave(e){
        context.closePath(); 
        pulsado = false;
    }





    function upload() {
            
        $.post('upload-imagen.php',
        {
        img : canvas.toDataURL()
        });
        
    }

    
    function limpia(elemento){
        elemento.value = "";
    }

    function verifica(elemento){
        if(elemento.value = "")
            elemento.value = "Default Value";
    }

//Funciones para el autocompletado de campos de texto. Por ahora no los vamos a usar.
/*
    function agregarProducto(){
        $("#listaProductos")$("#descrip")

    }

    $(function() 
        {
            // configuramos el control para realizar la busqueda de los productos
            $("#descrip").autocomplete({
                source: "buscar.php",           // este es el formulario que realiza la busqueda 
                minLength: 2,                   // le decimos que espere hasta que haya 2 caracteres escritos 
                select: productoSeleccionado,   // esta es la rutina que extrae la informacion del registro seleccionado 
                focus: productoMarcado
            });
        });
        
        // tras seleccionar un producto, calculamos el importe correspondiente
        function productoMarcado(event, ui)
        {
            var producto = ui.item.value;
            
            // no quiero que jquery maneje el texto del control porque no puede manejar objetos, 
            // asi que escribimos los datos nosotros y cancelamos el evento
            // (intenta comentando este codigo para ver a que me refiero)
            $("#descrip").val(producto.descripcion);

            event.preventDefault();
        }
        
        function productoSeleccionado(event, ui)
        {
            var producto = ui.item.value;
            
            // no quiero que jquery maneje el texto del control porque no puede manejar objetos, 
            // asi que escribimos los datos nosotros y cancelamos el evento

            $("#descrip").val(producto.descripcion);
            event.preventDefault();
        }
*/