<?php
class mdlListado extends Singleton
{
    const PAGE = 'listado';

    public function onGestionPagina()
    {
        if (getGet('pagina') != self::PAGE) return;
// Si no ha pasado por el paso Menu (si se modifica el valor de la variable en la url), se vuelve a visualizar la página inicial
        if (!isset($_SESSION['busqueda'])) {

            redirectTo('index.php');
            
        } else {

            $_SESSION['datos'] = $_SESSION['busqueda'];
            session::del('busqueda');
        }

    }

    public function onCargarVista($path)
    {
        if (getGet('pagina') != self::PAGE) return;
        ob_start();
        include $path;
        $vista = ob_get_contents();
        ob_end_clean();
        echo ListadoParser::loadContent($vista);
    }
}

?>