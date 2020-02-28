<?php $val = Validacion::getInstance(); ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>VIAJES CORRECAMINOS</title>
        <style>
            form {
                padding-top: 50px;
            }
            .has-error { background: red; color: white; padding: 0.2em; }
            .has-warning { background: blue; color: white; padding: 0.2em; }
        </style>
        <link href="mvc/vista/comun.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="container">
            <form action="index.php?pagina=busqueda" method="post">
                <h1>VIAJES CORRECAMINOS</h1>
                <hr>
                <center><p><b>Buscar un viaje para visualizar su descripción, eliminar o modificar</b></p></center>
                <hr>
                <br><br>
                {{errores}}
                <div>
                    <label class=" {{class-opcion}}" for="opcion">Introduzca el nombre del viaje o el tipo y pulse Buscar. <br>No escriba nada para mostrar todos los viajes:</label><br><br>
                    <input type="text" id="opcion" name="opcion"
                           value='<?php echo $val->restoreValue('opcion'); ?>' >
                    <span>{{war-opcion}}</span>
                </div>
                <br>
                <div>
                    <button type="submit" name="busqueda">Buscar</button>
                </div>
            </form>
            <a href="?inicio">Volver a inicio</a>
        </div>
    </body>
</html>