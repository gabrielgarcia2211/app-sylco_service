//-------PROYECTOS

function guardarProyecto() {
    event.preventDefault();

    var formu = document.getElementById("form-proyecto");
    let nombre = $("#nombre").val();
    let descripcion = $("#descripcion").val();
    let ubicacion = $("#ubicacion").val();

    if (nombre == "" || descripcion == "" || ubicacion == "") {
        formu.submit();
        return;
    }

    var url = $("#form-proyecto").attr("action");
    var parametros = new FormData($("#form-proyecto")[0]);

    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        method: "POST",
        url: url,
        data: parametros,
        contentType: false,
        processData: false,
        beforeSend: function () {
            Swal.fire({
                title: "Cargando",
                text: "Creando proyecto...",
                imageUrl: "https://img.webme.com/pic/a/andwas/cargando5.gif",
                imageWidth: 200,
                imageHeight: 180,
                imageAlt: "Creando proyecto",
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
            var url = $("#formu-proyecto-delete").attr("action");
            var dataSalida = { search: nombre };
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
                        text: "Eliminando proyecto...",
                        imageUrl:
                            "https://img.webme.com/pic/a/andwas/cargando5.gif",
                        imageWidth: 200,
                        imageHeight: 180,
                        imageAlt: "Eliminando proyecto",
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

async function editProyecto(proyecto) {
    event.preventDefault();
    const data = JSON.parse(proyecto);
    const { value: formValues } = await Swal.fire({
        title: "Ingrese los Valores",
        showCancelButton: true,
        html:
            `<input id="swal-input1" class="swal2-input" placeholder="Nombre" value="${data["name"]}">` +
            `<input id="swal-input2" class="swal2-input" placeholder="Descripcion" value="${data["descripcion"]}">` +
            `<input id="swal-input3" class="swal2-input" placeholder="Ubicacion" value="${data["ubicacion"]}">`,
        focusConfirm: false,

        preConfirm: () => {
            return [
                document.getElementById("swal-input1").value,
                document.getElementById("swal-input2").value,
                document.getElementById("swal-input3").value,
            ];
        },
    });

    if (formValues) {
        const dataOp = formValues;

        if (dataOp[0] == "" || dataOp[1] == "" || dataOp[2] == "") {
            Swal.fire("Por favor ingresa todos los valores");
            return;
        } else {
            var url = $("#formu-proyecto-edit").attr("action");
            dataOp.push(data["id"]);
            console.log(dataOp);
            var dataSalida = {
                name: dataOp[0],
                descripcion: dataOp[1],
                ubicacion: dataOp[2],
                id: dataOp[3],
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
                        text: "Editando proyecto...",
                        imageUrl:
                            "https://img.webme.com/pic/a/andwas/cargando5.gif",
                        imageWidth: 200,
                        imageHeight: 180,
                        imageAlt: "Editando proyecto",
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

//-------USUARIOS

function guardarUsuario() {
    event.preventDefault();

    //var formu = document.getElementById("form-user");
    //formu.submit();

    var url = $("#form-user").attr("action");
    var parametros = new FormData($("#form-user")[0]);

    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        method: "POST",
        url: url,
        data: parametros,
        contentType: false,
        processData: false,
        beforeSend: function () {
            Swal.fire({
                title: "Cargando",
                text: "Creando proyecto...",
                imageUrl: "https://img.webme.com/pic/a/andwas/cargando5.gif",
                imageWidth: 200,
                imageHeight: 180,
                imageAlt: "Creando proyecto",
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
        error: function (jqXhr, json, errorThrown) {
            // this are default for ajax errors
            var errors = jqXhr.responseJSON;
            var errorsHtml = "";
            $.each(errors["errors"], function (index, value) {
                errorsHtml +=
                    '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                    value +
                    "</li></ul>";
            });
            //I use SweetAlert2 for this
            Swal.fire({
                title: "Error " + jqXhr.status + ": " + errorThrown, // this will output "Error 422: Unprocessable Entity"
                html: errorsHtml,
                width: "auto",
                icon: "error",
                confirmButtonText: "Intentar",
                cancelButtonText: "Cancelar",
            });
        },
    });
}

async function editUsuario(proyecto, listProyecto) {
    event.preventDefault();
    var listaP = "";
    const data = JSON.parse(proyecto);
    const dataProyecto = JSON.parse(listProyecto);
    dataProyecto.forEach((ta) => {
        listaP += `<option value="${ta.id}" >${ta.name}</option>`;
    });
    const { value: formValues } = await Swal.fire({
        title: "Ingrese los Valores",
        showCancelButton: true,
        html:
            `<input id="swal-input1" class="swal2-input" placeholder="Nit" value="${data["nit"]}">` +
            `<input id="swal-input2" class="swal2-input" placeholder="Nombre" value="${data["name"]}">` +
            `<input id="swal-input3" class="swal2-input" placeholder="Apellido" value="${data["last_name"]}">` +
            `<input id="swal-input4" class="swal2-input" placeholder="Correo" value="${data["email"]}">` +
            `<select id="swal-input5" class="swal2-input"> ` +
            listaP +
            `</select>`,

        focusConfirm: false,

        preConfirm: () => {
            return [
                document.getElementById("swal-input1").value,
                document.getElementById("swal-input2").value,
                document.getElementById("swal-input3").value,
                document.getElementById("swal-input4").value,
                document.getElementById("swal-input5").value,
            ];
        },
    });

    if (formValues) {
        const dataOp = formValues;

        if (
            dataOp[0] == "" ||
            dataOp[1] == "" ||
            dataOp[2] == "" ||
            dataOp[3] == ""
        ) {
            Swal.fire("Por favor ingresa todos los valores");
            return;
        } else {
            var url = $("#formu-user-edit").attr("action");
            dataOp.push(data["proyectoId"]);
            dataOp.push(data["nit"]);
            var dataSalida = {
                nuevoId: dataOp[0],
                nombre: dataOp[1],
                apellido: dataOp[2],
                correo: dataOp[3],
                nuevoProyecto: dataOp[4],
                antProyecto: dataOp[5],
                nit: dataOp[6],
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
                        text: "Editando Usuario...",
                        imageUrl:
                            "https://img.webme.com/pic/a/andwas/cargando5.gif",
                        imageWidth: 200,
                        imageHeight: 180,
                        imageAlt: "Editando usuario",
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

function eliminarUsuario(nit) {
    event.preventDefault();
    Swal.fire({
        title: "Desea eliminar el usuario?",
        text: "Esta operacion es irreversible",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Eliminar!",
    }).then((result) => {
        if (result.isConfirmed) {
            var url = $("#formu-user-delete").attr("action");
            var dataSalida = { nit: nit };
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
                        text: "Eliminando usuario...",
                        imageUrl:
                            "https://img.webme.com/pic/a/andwas/cargando5.gif",
                        imageWidth: 200,
                        imageHeight: 180,
                        imageAlt: "Eliminando usuario",
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

function findFilesUser(nit, proyecto) {
    event.preventDefault();
    var url = $("#formu-user-show").attr("action");
    var parametros = { nit: nit, proyecto: proyecto };
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        method: "POST",
        url: url,
        data: parametros,

        success: function (response) {
            console.log(response);
        },
    });
    //event.preventDefault();
    //alert(nit  + "" + proyecto);
}
