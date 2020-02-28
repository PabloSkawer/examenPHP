<?php
class mdlDescripcion extends Singleton
{
    const PAGE = 'descripcion';

    public function onGestionPagina()
    {
        if (getGet('pagina') != self::PAGE) return;
        $datos = true;
        if ($datos)
            $_SESSION['descripcion'] = true;
            $_SESSION['datos'] = ClaseGenerica::descripcionDB(getGet('opcion'))[0];
        redirectTo('index.php?pagina=mensaje&id='.getGet('opcion'));
    }
}