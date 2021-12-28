

function eliminarProyecto(nombre) {
    event.preventDefault();
    Swal.fire({
        title: "Desea eliminar el proyecto?",
        text: "Esta operacion es irreversible",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Eliminar!",
    }).then((result) => {
        if (result.isConfirmed) {
            //alert(nombre);
            var url   = $("#formu-proyecto-delete").attr('action');
            var dataSalida = { search:nombre };
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: url,
                data: dataSalida,
                success: function (response) {
                    console.log(response);
                },
            });
        }
    });
}
