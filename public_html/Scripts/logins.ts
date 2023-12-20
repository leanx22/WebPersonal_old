$(()=>{

    $("#logInbtn").on("click", (e:any)=>{
        e.preventDefault();

        mostrarCarga(true);
        
        let clave = $('#pass').val();
        let usuario = $('#user').val();

        let dato:any = {};
        dato.clave = clave;
        dato.usuario = usuario;

        $.ajax({
            type:'POST',
            url:URL_PAGINA+"login",
            dataType:"json",
            data:dato,
            async:true
        }).done(function(obj_ret:any){

            if(obj_ret.exito == true)
            {
                mostrarAlert("success",'<div class="spinner-border spinner-border-sm" aria-hidden="true"></div>'+obj_ret.mensaje);
                localStorage.setItem("user_data",obj_ret.token);
                /*
                setTimeout(()=>{
                    $(location).attr('href',URL_PAGINA+'dashboard');
                },1200);*/
            }
        }).fail(()=>{
            mostrarAlert("danger","No se pudo iniciar sesion.");
        });
        
    });

});

function mostrarCarga(activo:boolean)
{
    
    let bootstrapCode:string = '<div class="d-flex align-items-center">\
    <strong role="status">Loading...</strong>\
    <div class="spinner-border ms-auto" aria-hidden="true"></div>\
    </div>'

    if(activo)
    {
        $("#infoDiv").html(bootstrapCode);
    }
    else
    {
        $("#infoDiv").empty();
    }

}

function mostrarAlert(tipo:string = "warning",mensaje:string)
{
    let alertCode:string = '<div class="alert alert-'+tipo+' alert-dismissible fade show mt-2" role="alert">'+
    mensaje+'\
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>\
    </div>'

    $("#infoDiv").html(alertCode);
}