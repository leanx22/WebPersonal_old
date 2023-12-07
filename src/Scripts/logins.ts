$(()=>{

    $("#logInbtn").on("click", (e:any)=>{
        e.preventDefault();

        let clave = $('#pass').val();
        let usuario = $('#user').val();

        //Encapsulo la data
        let dato:any = {};
        dato.clave = clave;
        dato.usuario = usuario;

        //hago la peticion
        $.ajax({
            type:'POST',
            url:URL_API+"login",
            dataType:"json",
            data:dato,
            async:true
        }).done(function(obj_ret:any){

            if(obj_ret.exito)
            {
                localStorage.setItem("user_data",obj_ret.jwt);

                setTimeout(()=>{
                    $(location).attr('href',URL_API+'dashboard');
                },1200);
            }
        }).fail(()=>{
            alert("No se pudo iniciar sesion!");
        });

    });

});