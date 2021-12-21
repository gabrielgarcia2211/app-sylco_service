function guardarProyecto() {

    var formulario = document.getElementById("form-proyecto");
    var nombre = $("#nombre").val();
    var descripcion = $("#descripcion").val();
    var ubicacion  = $("#ubicacion").val();

    if(nombre=="" || descripcion==""  || ubicacion=="" ){
        formulario.submit();
        return;
    }
    

    event.preventDefault();
    var url = $("#form-proyecto").attr("action");
    var parametros = new FormData($("#form-proyecto")[0]);
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: url,
        data: parametros,
        type: "POST",
        contentType: false,
        processData: false,
        beforeSend: function () {
            Swal.fire({
                title: "Cargando",
                text: "Subiendo archvio...",
                imageUrl: "https://img.webme.com/pic/a/andwas/cargando5.gif",
                imageWidth: 200,
                imageHeight: 180,
                imageAlt: "Subiendo archvio",
                showCancelButton: false,
                showConfirmButton: false,
            });
        },
        success: function (response) {
            let tasks = JSON.parse(response);

            if (tasks[0].response) {
                Swal.fire("Proceso Realizado", tasks[0].message, "success");
                setTimeout(location.reload(), 4000);
            } else {
                Swal.fire("Error", tasks[0].message, "error");
            }
        },
        error: function (response) {
            console.log(response);
            swal.close();
        },
    });
}

function eliminarProyecto(){
    event.preventDefault();                                              
    Swal.fire({
        title: 'Desea eliminar el proyecto?',
        text: "Esta operacion es irreversible, se eliminaran todos los archivos contratistas relacionados",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar!'
    }).then((result) => {
        if (result.isConfirmed) {
            var formulario = document.getElementById("formu-delete-proyecto");
            formulario.submit();
            event.currentTarget.submit();
        }
    })

}
