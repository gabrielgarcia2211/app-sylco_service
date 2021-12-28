
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>Hola HTML</title>
</head>
<body>
    <p>Hola Mundo!</p>

    <form>         
        <input type="hidden" name="nombre" id="nombre" value="8">
        <button class="btn btn-danger" style="width: 100%" onclick=" eliminarProyecto()"><i class="far fa-trash-alt"></i>0</button>
    </form>


    <form>                 
        <input type="hidden" name="nombre2" id="nombre2" value="w8">
        <button class="btn btn-danger" style="width: 100%" onclick=" eliminarProyecto()"><i class="far fa-trash-alt"></i>1</button>
    </form>

    <script>
    function eliminarProyecto(){
        event.preventDefault();
        alert(document.getElementById('nombre2').value)
    }
    </script>

  </body>
</html>
            
                
