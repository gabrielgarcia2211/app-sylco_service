

function addFile() {
    event.preventDefault();
    var url   = $("#form-file-contratista").attr('action');
    var parametros = new FormData($("#form-file-contratista")[0]);
    $.ajax({
        type: "POST",
        url: url,
        data: parametros,
        contentType: false,
        processData: false,
        beforeSend : function(){
            Swal.fire({
                title: 'Cargando',
                text: 'Subiendo archvio...',
                imageUrl: 'https://img.webme.com/pic/a/andwas/cargando5.gif',
                imageWidth: 200,
                imageHeight: 180,
                imageAlt: 'Subiendo archvio',
                showCancelButton: false,
                showConfirmButton: false
            })
        },
        success: function (data) {
            swal.close()
            console.log(data);
        },
        error: function (r) {
            alert(r);
            swal.close()
        },
        complete: function(){
            swal.close()
        }
    });
}