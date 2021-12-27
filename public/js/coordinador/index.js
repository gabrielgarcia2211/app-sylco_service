function eliminarProyecto(){
    event.preventDefault();
    Swal.fire({
        title: 'Desea eliminar el proyecto?',
        text: "Esta operacion es irreversible",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar!'
    }).then((result) => {
        if (result.isConfirmed) {
            var formulario = document.getElementById("formu-proyecto-delete");
            return formulario.submit();
        }
    })

    //document.getElementById('formu-proyecto-delete').submit();

}