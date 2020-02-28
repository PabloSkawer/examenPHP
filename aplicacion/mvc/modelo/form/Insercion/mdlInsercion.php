<?php
class mdlInsercion extends Singleton
{
    const PAGE = 'insercion';

    public function onGestionPagina()
    {
        if (getGet('pagina') != self::PAGE) return;
// Validamos
        $val = Validacion::getInstance();
// Validamos los elementos que hay en $_POST
        $toValidate = ($_POST);
        
         /******************************************************************/
        /**************MODIFICAR SEGUN CAMPOS DE LA TABLA *****************/
       /******************************************************************/
        $rules = array(
            'nombre' => 'required|alpha_space',
            'descripcion' => 'required|alpha_spaceCom',
            'idtipo' => 'required|numeros|encontrado',
            'precio' => 'required|numeros',
            'salida1' => 'required|alpha_space',
            'salida2' => 'required|alpha_space',
            'foto' => 'foto',
        );

        
        $val->addRules($rules);

        // Comprobación de los campos y evitar que salten errores la primera vez que entras
        if(isset($_POST['insercion'])){
            $toValidate=array();
            foreach($rules as $key => $valor){
                $toValidate[$key]=getPost($key);
            }
             $toValidate =array_merge($toValidate, $_FILES);
            }

        $val->run($toValidate);
        if (!is_null(getPost(self::PAGE))) {
            if ($val->isValid()) {
// Guardamos los datos en session
                $_SESSION[self::PAGE] = $val->getOks();
                // Cambia la inserción de la foto para guardar solo el nombre
                $_SESSION['insercion']['foto'] = $_SESSION['insercion']['foto']['name'];
                
                $data = $_SESSION['insercion'];
                $datos = ClaseGenerica::insertDB($data);
                if ($datos)
                    $_SESSION['ins'] = true;
                else
                    $_SESSION['ins'] = false;
// Cambiamos el paso
                redirectTo('index.php?pagina=mensaje');
            }
        }
    }

    public function onCargarVista($path)
    {
        if (getGet('pagina') != self::PAGE) return;
        ob_start();
        include $path;
        $vista = ob_get_contents();
        ob_end_clean();
        echo InsercionParser::loadContent($vista);
    }
}

?>