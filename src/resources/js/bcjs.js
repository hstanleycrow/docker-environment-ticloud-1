    function get(id){
        return document.getElementById(id);
    }

function addEvent(obj, evType, fn, useCapture){
  if (obj.addEventListener){
    obj.addEventListener(evType, fn, useCapture);
    return true;
  } else if (obj.attachEvent){
    var r = obj.attachEvent("on"+evType, fn);
    return r;
  } else {
    alert("Handler could not be attached");
  }
} 

    function removeEvent(elm,evType,fn)
    {
        if(elm.removeEventListener)
        {
            elm.removeEventListener(evType, fn, false);
        }
        else if(elm.detachEvent)
        {
            elm.detachEvent("on"+evType, fn);
        }
        else
        {
            elm['on'+evType]=null;
        }
    
    }
    
    function vacio(valor)
    {
        if (valor == null || valor.length == 0 || /^\s+$/.test(valor)) 
            return true;
        else
            return false; 
    }
	
	function chg_img(tar,n)
	{
		n = get(n);
		var t=get(tar);
		var i=n.selectedIndex;
		var v = n.options[i].value;
		var oldHTML = t.innerHTML;
		var a = 'images/flags/' + v + '.png';
		var newHTML = "<span id='flag'><img src='" + a + "'/></span";
		t.innerHTML = newHTML;
	}

	function c_class(tar,nclass)
	{
		tar.className =nclass;
	}
	function add_class(tar,nclass)
	{
		tar.className += ' '+nclass;
	}

	
		function remover(el)
		{
			r=get(el);
			r.style.display='none';
//			r.style.display = '';
		}
		
	function stopEvent(e) {
		if(!e) var e = window.event;
		
		//e.cancelBubble is supported by IE - this will kill the bubbling process.
		e.cancelBubble = true;
		e.returnValue = false;
	
		//e.stopPropagation works only in Firefox.
		if (e.stopPropagation) {
			e.stopPropagation();
			e.preventDefault();
		}
		return false;
	}
	
	  function POST_AJAX(url, variables, funcion, async = true) {
        objeto = false;
        if (funcion == null)
            funcion = avisos;
		//creamos el onjeto XMLHttpRequest para poder enviar datos mediante ajax
        if (window.XMLHttpRequest) { // Mozilla, Safari,...
           objeto = new XMLHttpRequest();
           if (objeto.overrideMimeType) {
           	objeto.overrideMimeType('text/xml');
           }
        } else if (window.ActiveXObject) { // IE
           try {
              objeto = new ActiveXObject("Msxml2.XMLHTTP");
           } catch (e) {
              try {
                 objeto = new ActiveXObject("Microsoft.XMLHTTP");
              } catch (e) {}
           }
        }
        if (!objeto) {
           alert("No se puede crear la instancia XMLHTTP");
           return false;
        } 
		     
        objeto.onreadystatechange = funcion;    /*Cuando el archivo que se mando llamar mediante ajax (checar.php) regrese un resultado, entonces lo primero que se hace es mandar llamar la funcion avios(), que es donde se imprimirá mensaje de bienvenida*/
        objeto.open("POST", url, async);  /* enviaremos los datos por el metodo POST hacia checar.php */
        objeto.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); /*asignamos header. Esto no tiene relacion con el sistema de logeo. Solo es necesario para poder enviar los datos mediante ajax*/
        objeto.setRequestHeader("Content-length", variables.length);
        objeto.setRequestHeader("Connection", "close");
        objeto.send(variables); /* enviamos las variables con un formato como este: "user=minombre&pass=123456&n=0" */
	  }

		function add_hidden(form,n,v)
		{
			var input = document.createElement("input");
			input.setAttribute("type", "hidden");
			input.setAttribute("name", n);
			input.setAttribute("value", v);
			form.appendChild(input);
		}

