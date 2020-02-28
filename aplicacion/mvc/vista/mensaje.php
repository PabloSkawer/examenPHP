<?php $val = Validacion::getInstance(); ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>GESTION DE EMPLEADOS</title>
        <style>
            dl {
                padding-top: 50px;
            }
        </style>
        <link href="mvc/vista/comun.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <form action="index.php?pagina=mensaje" method="post">
            <h1>Viajes</h1>
            <hr>
            <hr>
            {{mensaje}}
            <br>
            <a href="index.php">Volver a Inicio</a>
            <a href="index.php?pagina=busqueda">Volver a Buscar</a>
        </form>

        
    </body>
</html>