<?php $val = Validacion::getInstance(); ?>
<html>

<head>
    <meta charset="UTF-8">
    <title>VIAJES CORRECAMINOS, Insercion</title>
    <style>
        form {
            padding-top: 50px;
        }

        .has-error {
            background: red;
            color: white;
            padding: 0.2em;
        }

        .has-warning {
            background: blue;
            color: white;
            padding: 0.2em;
        }
    </style>
    <link href="mvc/vista/comun.css" rel="stylesheet" type="text/css" />
    <script src="js/validacion.js" type="text/javascript"></script>
</head>

<body>
    <div>
        <form action="index.php?pagina=insercion" method="post" enctype="multipart/form-data">
            <h1>VIAJES CORRECAMINOS</h1>
            <hr>
            <center>
                <p><b>Inserción de nuevo viaje</b></p>
            </center>
            <hr>
            {{errores}}
            <div>
                <label class=" {{class-nombre}}" for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value='<?php echo $val->restoreValue('nombre'); ?>'>
                <span>{{war-nombre}}</span>
            </div>
            <div>
                <label class=" {{class-descripcion}}" for="descripcion">Descripci&oacute;n: </label>
                <input type="text" id="descripcion" name="descripcion" value='<?php echo $val->restoreValue('descripcion'); ?>'>
                <span>{{war-descripcion}}</span>
            </div>
            <div>
                <label class=" {{class-idtipo}}" for="idtipo">IdTipo:</label>
                <input type="text" id="idtipo" name="idtipo" value='<?php echo $val->restoreValue('idtipo'); ?>' onkeyup="validar()">
                <span id="spanIdTipo">{{war-idtipo}}</span>
            </div>
            <div>
                <label class=" {{class-precio}}" for="precio">Precio:</label>
                <input type="text" id="precio" name="precio" value='<?php echo $val->restoreValue('precio'); ?>'>
                <span>{{war-precio}}</span>
            </div>
            <div>
                <label class=" {{class-salida1}}" for="salida1">Salida 1º:</label>
                <input type="text" id="salida1" name="salida1" value='<?php echo $val->restoreValue('salida1'); ?>'>
                <span>{{war-salida1}}</span>
            </div>
            <div>
                <label class=" {{class-salida2}}" for="salida2">Salida 2º:</label>
                <input type="text" id="salida2" name="salida2" value='<?php echo $val->restoreValue('salida2'); ?>'>
                <span>{{war-salida2}}</span>
            </div>
            <div>
                <label class=" {{class-foto}}" for="foto">Foto</label>
                <input type="file" id="foto" name="foto" value=''>
                <span>{{war-foto}}</span>
            </div>
            <div>
                <button type="submit" id='boton' name="insercion">Insertar</button>
            </div>
        </form>
        <a href="?inicio">Volver a inicio</a>
    </div>
</body>

</html>