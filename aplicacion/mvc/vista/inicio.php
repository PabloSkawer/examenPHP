<?php $val = Validacion::getInstance(); ?>
<html>

<head>
    <meta charset="UTF-8">
    <title>GESTION DE VIAJES</title>
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
</head>

<body>
    <h1>VIAJES CORRECAMINOS</h1>
    <hr>
    <center>
        <p><b>Menú de Inicio</b></p>
    </center>
    <hr>
    <p>Elija una opción:</p>
    <div id="menu">
        <ul>
            <li><a href="?pagina=insercion">Para Insertar nuevos viajes</a></li><br>
            <li><a href="?pagina=busqueda">Para buscar alg&uacute;n viaje, ya sea para eliminarlo o para consultar sus datos</a></li>
        </ul>
    </div>
    <br>

</body>

</html>