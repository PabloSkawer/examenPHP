<?php
class MensajeParser
{
    public static function loadContent($vista)
    {
        $vista = self::_pasoSiguiente($vista);
        return $vista;
    }

    private static function _pasoSiguiente($vista)
    {
        foreach (getTagsVista($vista) as $tag) {
// sustituimos en el formulario los tags por el contenido de los elementos del formulario
            $str = '';
            switch ($tag) {
                case 'mensaje':
// Si existe $_SESSION['edicion'] es que el ID introducido a través del formulario existe
                    if (isset($_SESSION['edicion'])) {
                        if ($_SESSION['mod']) {
                            $str = '<p> <b>Articulo modificado</b></p>';
                        } else {
                            $str = '<p> <b>No se han podido modificar los datos...</b></p>';
                        }
                        Session::del('edicion');
                    } elseif (isset($_SESSION['eliminacion'])) {
                        if ($_SESSION['elim']) {
                            $str = '<p> <b>Articulo eliminado</b></p>';
                        } else {
                            $str = '<p> <b>No se ha podido eliminar este Articulo</b></p>';
                        }
                        Session::del('eliminacion');
                    } elseif (isset($_SESSION['insercion'])) {
                        if ($_SESSION['ins']) {
                            $str = '<p> <b>El articulo se ha añadido correctamente</b></p>';
                        } else {
                            $str = '<p> <b>No se ha podido almacenar este Articulo</b></p>';
                        }
                        Session::del('insercion');
                        }
                    elseif (isset($_SESSION['descripcion'])) {
                            $str = ClaseGenerica::descripcionDB(getGet('id'))[0];
                        Session::del('descripcion');
                        }
                     else
                        $str = '<p> <b>El Articulo no existe</b></p>';
                    break;
            }
            $vista = str_replace('{{' . $tag . '}}', $str, $vista);
        }
        return $vista;
    }
}