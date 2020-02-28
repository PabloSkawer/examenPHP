<?php
class ListadoParser
{
    public static function loadContent($vista)
    {
        $vista = self::_pasoSiguiente($vista);
        return $vista;
    }

    private static function _pasoSiguiente($vista)
    {
        foreach (getTagsVista($vista) as $tag) {
            
            $str = '';
            switch ($tag) {
                case 'listado':
                    $datos = $_SESSION['datos'];
                    if (count($datos) > 0) {
                        
                        $str = "<table>
                                    <tr>
                                    <th></th>
                                        <th>Nombre</th>
                                        <th>Precio</th>
                                        <th>Tipo</th>
                                        <th>Salida1</th>
                                        <th>Salida2</th>
                                    </tr>";
                        
                        foreach ($datos as $cosas) {
                            $cat = ClaseGenerica::nombreTipo($cosas['idTipo'])[0];
                            $str .= "
                                    <tr>
                                        <td> <img src='fotos/".$cosas['foto']."'></td>
                                        <td> ". $cosas['nombre'] . "</td>
                                        <td> ". $cosas['precio'] . "</td>
                                        <td> ". $cat . "</td>";
                            foreach(ClaseGenerica::searchIdDB($cosas['id']) as $salidas)            
                            $str  .= "<td>".$salidas."</td>";
                            
                                    
                                        $str.="<td style='text-align:center'> 
                                        <a href='?pagina=descripcion&opcion=". $cosas['id']."'>Descripci&oacute;n</a> 
                                        
                                        <a href='?pagina=edicion&id=" . $cosas['id'] . "'>Modificar</a>
                                        <a href='?pagina=eliminacion&opcion=" . $cosas['id'] . "'>Eliminar</a></td></tr></table>";
                        }
                        
                        Session::del('busqueda');
                    } else
                        $str = '<p> <b>No se han encontrado resultados...</b></p>';
                    break;
            }
            $vista = str_replace('{{' . $tag . '}}', $str, $vista);
        }
        return $vista;
    }
}