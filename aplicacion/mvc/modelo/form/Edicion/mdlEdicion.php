<?php
class mdlEdicion extends Singleton
{
    const PAGE = 'edicion';

    public function onGestionPagina()
    {

        if (getGet('pagina') != self::PAGE) return;
        
        if (is_null(getPost(self::PAGE))) {
            
            if (!getGet('id')) redirectTo('index.php');
            
            $_SESSION[self::PAGE]['id'] = getGet('id');
            
            $datos = ClaseGenerica::searchIdViajesDB(getGet('id'));
            
        }
        
        $search = $_SESSION['edicion']['id'];
        
        if (is_null(getPost('edicion'))) {
            
            $datos = ClaseGenerica::searchIdViajesDB($search);
            
            if (count($datos) > 0) {
// Utilizamos la validación para rellenar los campos del formulario.
                $val = Validacion::getInstance();
                $toValidate = $datos[0];
                $rules = array(
                    'nombre' => 'required|alpha_space',
                    'descripcion' => 'required|alpha_spaceCom',
                    'idTipo' => 'required|numeros|encontrado',
                    'precio' => 'required|numeros',
                    'foto' => 'required'
                );

                $val->addRules($rules);
                if(isset($_POST['edicion'])){
                    $toValidate=array();
                    foreach($rules as $key => $valor){
                        $toValidate[$key]=getPost($key);
                    }
                    $toValidate =array_merge($toValidate, $_FILES);
                }
            $val->run($toValidate);
            } else
                redirectTo('index.php?pagina=mensaje');
        } else {

            if (is_null(getPost(self::PAGE))) {
                if (!getGet('id')) redirectTo('index.php');
                $_SESSION[self::PAGE]['id'] = getGet('id');
                $datos = ClaseGenerica::searchIdViajesDB(getGet('id'));
            }
// Validamos
            $val = Validacion::getInstance();
            $toValidate = $_POST;
            $rules = array(
                    'nombre' => 'required|alpha_space',
                    'descripcion' => 'required|alpha_spaceCom',
                    'idTipo' => 'required|numeros|encontrado',
                    'precio' => 'required|numeros',
                    'foto' => 'required'
                );

            $val->addRules($rules);
            if(isset($_POST['edicion'])){
                    $toValidate=array();
                    foreach($rules as $key => $valor){
                        $toValidate[$key]=getPost($key);
                    }
                    $toValidate =array_merge($toValidate, $_FILES);
                }
            $val->run($toValidate);
            if ($val->isValid()) {
                $_SESSION[self::PAGE]= array_merge($_SESSION[self::PAGE],$val->getOks());
                $id = $_SESSION['edicion']['id'];



            $data = $_SESSION['edicion'];
                $datos = ClaseGenerica::modifyDB($data,  $id);
                if ($datos)
                    $_SESSION['mod'] = true;
                else
                    $_SESSION['mod'] = false;
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
        echo EdicionParser::loadContent($vista);
    }
}