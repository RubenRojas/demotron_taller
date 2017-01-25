function menu(){
  $(document).find("li.has-drop > a").each(function(index,element){   
    var icono = "<i class=\"fa fa-angle-down\"></i>";
    $(element).append(icono);
    $(element).click(function(){
        if($(element).parent().hasClass('activo')){
            $(element).parent().removeClass('activo');
        }
        else{
            $(element).parent().addClass('activo');
        }
        
    });
  });
}
$(document).ready(function(){
    menu();
});