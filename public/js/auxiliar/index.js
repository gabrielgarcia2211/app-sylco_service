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
                        <td style="text-align:center" ><a href="../../files/download/admin/${tasks[g].file}/${tasks[g].propietario}" target="" class="btn btn-primary" ><i class="far fa-eye"></i></a></td>` +
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

async function sendEmail(email) {
    event.preventDefault();
    const { value: formValues } = await Swal.fire({
        title: "Ingrese los Valores",
        showCancelButton: true,
        html:
            `<input id="swal-input1" class="swal2-input" placeholder="Asunto" value="">` +
            `<textarea id="swal-input2" class="swal2-input" rows="10" maxlength="245" placeholder="Descripcion"></textarea>`,
        focusConfirm: false,
        confirmButtonText: 'Enviar Correo',
        cancelButtonText: 'Cancelar',

        preConfirm: () => {
            return [
                document.getElementById("swal-input1").value,
                document.getElementById("swal-input2").value,
            ];
        },
    });

    if (formValues) {
        const dataOp = formValues;
        if (dataOp[0] == "" || dataOp[1] == "") {
            Swal.fire("Por favor ingresa todos los valores");
            return;
        } else {
            var url = $("#formu-contratista-send").attr("action");
            dataOp.push(email);
            console.log(dataOp);
            var dataSalida = {
                name: dataOp[0],
                descripcion: dataOp[1],
                email: dataOp[2],
            };
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                method: "POST",
                url: url,
                data: dataSalida,
                beforeSend: function () {
                    Swal.fire({
                        title: "Cargando",
                        text: "Enviando Correo...",
                        imageUrl:
                            "https://img.webme.com/pic/a/andwas/cargando5.gif",
                        imageWidth: 160,
                        imageHeight: 140,
                        imageAlt: "Enviando Correo",
                        showCancelButton: false,
                        showConfirmButton: false,
                    });
                },
                success: function (response) {
                    if (response["response"]) {
                        Swal.fire({
                            icon: "success",
                            title: "Hecho!",
                            text: response["message"],
                        });
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: response["message"],
                        });
                    }
                },
                error: function (response) {
                    Swal.close();
                },
            });
        }
    }
}

function addFile(){
    event.preventDefault();
    var file = $("#archivo").val();
    var nombre = $("#nombre").val();
    var descripcion = $("#descripcion").val();
    var carpeta = $("#carpeta").val()


    if (file == "" || nombre == "" || descripcion == "" || carpeta == "") {
        Swal.fire({
            icon: "warning",
            title: "Oops...",
            text: "Por favor llene todos los campos!",
        });
        return;
    }


    var url = $("#form-upload-contratista").attr("action");
    var parametros = new FormData($("#form-upload-contratista")[0]);
    $.ajax({
        type: "POST",
        url: url,
        data: parametros,
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
            if (response["response"]) {
                Swal.fire({
                    icon: "success",
                    title: "Hecho!",
                    text: response["message"],
                });
                location.reload();
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: response["message"],
                });
            }
        },
        error: function (r) {
            alert(r.responseText);
            swal.close();
        },
    });
}


function deleteFile(id) {
    event.preventDefault();
    Swal.fire({
        title: "Desea eliminar el archivo?",
        text: "Esta operacion es irreversible",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Eliminar!",
    }).then((result) => {
        if (result.isConfirmed) {
            var url = $("#form-file-delete").attr("action");
            var dataSalida = { id: id };
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                method: "POST",
                url: url,
                data: dataSalida,
                beforeSend: function () {
                    Swal.fire({
                        title: "Cargando",
                        text: "Eliminando Archivo...",
                        imageUrl:
                            "https://img.webme.com/pic/a/andwas/cargando5.gif",
                        imageWidth: 200,
                        imageHeight: 180,
                        imageAlt: "Eliminando Archivo",
                        showCancelButton: false,
                        showConfirmButton: false,
                    });
                },
                success: function (response) {
                    if (response["response"]) {
                        Swal.fire({
                            icon: "success",
                            title: "Hecho!",
                            text: response["message"],
                        });
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: response["message"],
                        });
                    }
                },
            });
        }
    });
}
