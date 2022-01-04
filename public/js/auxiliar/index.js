function findFilesUser(nit, proyecto) {
    event.preventDefault();
    localStorage.removeItem("infoC");
    var url = $("#formu-contratista-show").attr("action");
    var parametros = { nit: nit, proyecto: proyecto };
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        method: "POST",
        url: url,
        data: parametros,

        beforeSend: function () {
            Swal.fire({
                title: "Cargando",
                text: "Buscando Archivos...",
                imageUrl: "https://img.webme.com/pic/a/andwas/cargando5.gif",
                imageWidth: 200,
                imageHeight: 180,
                imageAlt: "Buscando Archivos",
                showCancelButton: false,
                showConfirmButton: false,
            });
        },
        success: function (response) {
            let tasks = JSON.parse(response);
            let template = "";
            if (tasks != "") {
                console.log(tasks.length);
                for (let g = 0; g < tasks.length; g++) {
                    template +=
                        `<tr>
                        <td >${tasks[g].propietario}</td>
                        <td >${tasks[g].name}</td>
                        <td >${tasks[g].descripcion}</td>
                        <td >${tasks[g].fecha}</td>
                        <td style="text-align:center" ><a href="${tasks[g].file}" target="_blank" class="btn btn-primary" ><i class="far fa-eye"></i></a></td>` +
                        `</tr>`;
                }

                localStorage.setItem("infoC", template);
                window.location.replace("../../contratista/proyecto/list");
            } else {
                template +=
                    `<tr >
                        <td COLSPAN="5" style="text-align:center">NO HAY DATOS RELACIONADOS</td>` +
                    `</tr>`;
                localStorage.setItem("infoC", template);
                window.location.replace("../../contratista/proyecto/list");
            }
        },
        complete: function (res) {
            Swal.close();
        },
        error: function (res) {
            Swal.close();
        },
    });
    return false;
}