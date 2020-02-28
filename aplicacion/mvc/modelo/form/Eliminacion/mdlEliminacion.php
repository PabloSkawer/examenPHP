<?php
class mdlEliminacion extends Singleton
{
    const PAGE = 'eliminacion';

    public function onGestionPagina()
    {
        if (getGet('pagina') != self::PAGE) return;
        $datos = ClaseGenerica::removeDB(getGet('opcion'));
//Guardamos los datos de la función remove, y si esta es exitosa
//Creamos la sesión 'elim', para así en mensaje visualizar que la operación fue exitosa
        if ($datos)
            $_SESSION['elim'] = true;
        else
            $_SESSION['elim'] = false;

        $_SESSION[self::PAGE] = true;
        redirectTo('index.php?pagina=mensaje');
    }
}