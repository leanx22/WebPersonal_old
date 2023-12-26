"use strict";
$(() => {
    verificarLogin();
});
function verificarLogin() {
    let token = localStorage.getItem('user_data');
    if (token == null) {
        IrAlogin();
    }
    /*
    $.ajax({
        type:'GET',
        url:URL_PAGINA+"login",
        dataType:"json",
        data:{},
        headers:{'Authorization':'Bearer '+token}, //ESTE ES EL IMPORTANTE ACA, PARA ENVIAR EL TOKEN EN EL HEADER!
        async:true
    }).done(function(obj_ret:any){

        if(obj_ret.exito == false)
        {
            IrAlogin();
        }

        let data = JSON.parse(obj_ret.payload.usuario)

        $('#nombre_usuario').html(data.nombre);

    }).fail(()=>{
        IrAlogin();
    });
    */
}
function IrAlogin() {
    $(location).attr('href', URL_PAGINA + 'login');
}
//# sourceMappingURL=dashboard.js.map