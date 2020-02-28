<?php
require_once "../include.php";
$descripcion = getPost("idtipo");
// Es solo para hacer pruebas, comentar o borrar si esto funciona
//var_dump($descripcion);
echo (ClaseGenerica::ComprobarTipo($descripcion))? "si" : "no";
?>