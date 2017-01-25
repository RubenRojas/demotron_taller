

    /*
    CONVERSION DE NUMEROS:

    - SEPARADOR DE MILES NO SE INGRESA EN EL INPUT
    - SEPARADOR DE DECIMALES: PUNTO

    */
function format_input(input){
    
}
function number_format(number){
    number = number.toString();
    var arr = number.split(".");
    //var num = number.split(".").join("");

    var num = arr[0].split(",").join(""); // quito las comas de la parte no decimal del numero

    var count = num.length; var res=""; var tmp=0; var res_tmp="";
    for(i=(count-1); i>=0;i--){
        res_tmp = num[i];
        res = res_tmp + res;
        tmp ++;
        if(tmp==3){res = "," + res; tmp = 0; }
    }
    if(count%3==0){
        res=res.substr(1);
    }
    if (typeof arr[1] != 'undefined'){
        return res+"."+arr[1];
    }
    else{
        return res   
    }

}

function calcula_valor(){
    var neto = 0;
   for (var i = 0; i < 15; i++) {
        var monto = redondea(calcula_monto_item(i));
        if(!isNaN(monto)){ neto = neto + monto; }
   }
   if($("#valores_iva").prop("checked")){
        $("#neto_oc").val(number_format(redondea(neto/1.19)))
        $("#iva_oc").val(number_format(redondea(neto * 0.159663866)));
        $("#total_oc").val(number_format(redondea(neto)));
   }
   else{
        $("#neto_oc").val(number_format(redondea(neto)))
        $("#iva_oc").val(number_format(redondea(neto * 0.19)));
        $("#total_oc").val(number_format(redondea(neto * 1.19)));
   }
  
}

function calcula_monto_item(i){

    var num = $("#valor_"+i).val();   
    var cant = $("#cant_"+i).val(); 
  
    
    num     = num.split(",").join("");  //QUITO LAS COMAS 
    //cant    = cant.split(",").join("");
    //cant    = cant.split(".").join(",");
    //if(!isNaN(parseFloat(cant))){     console.log('cantidad operada: '+ parseFloat(cant)); }

    var total = parseFloat(num) * parseFloat(cant);
    if(!isNaN(total)){ 
        $("#total_"+i).val(number_format(redondea(total)));
    }
    
    return total;
}
function redondea(numero){
   
    var result = Math.round (numero )  //11.76 -> 12 // 11.1 -> 11
    return result;
}
$("#form").keypress(function(e){
    if (e.which == 13){
        return false;
    }
}); 


function borra_linea(n_linea){

    $("#cant_"+n_linea).val("");
    $("#unidad_"+n_linea).val("");
    $("#cc_"+n_linea).val("");
    $("#parte_"+n_linea).val("");
    $("#detalle_"+n_linea).val("");
    $("#valor_"+n_linea).val("");
    $("#total_"+n_linea).val("");
    $("#id_prod_"+n_linea).val("");

}

function update_contador(n_linea){
    var letras = $("#detalle_"+n_linea).val().length;
    var restante = parseInt(45 - letras);
    $("#contador_"+n_linea).html(restante);
}
function check_contador(){
    for(var i =0;i<15;i++){
        var letras = $("#detalle_"+i).val().length;
        var restante = parseInt(45 - letras);
        $("#contador_"+i).html(restante);
    }
}
