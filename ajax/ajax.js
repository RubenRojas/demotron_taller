var BaseDir = "/taller/ajax/";

function setDatosMaquina(id){
    var url= BaseDir+"php/datos_maquina.php?id="+id;
    console.log(url);
    var datos=crearXMLHttpRequest();
    datos.onreadystatechange = function(){
        if(datos.readyState==1){
        }
        else if(datos.readyState==4){
            if(datos.status==200){
                $("#datos").html(datos.responseText); 
            }
        }  
    };
    datos.open("GET", url, true);
    datos.send(null);
}



/****************************
FUNCION COMUN PARA TODOS LOS DEMAS
****************************/


function crearXMLHttpRequest(){
  var xmlHttp=null;
  if (window.ActiveXObject){
    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  else{ 
    if (window.XMLHttpRequest){
      xmlHttp = new XMLHttpRequest();
    }
  }
  return xmlHttp;
}