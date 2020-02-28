<?php 
class ClaseGenerica {

    public static function insertDB($data) {
        $database = medoo::getInstance();
        $database->openConnection(unserialize(MYSQL_CONFIG));
        // Comienza la transaccion
        $database->pdo->beginTransaction();
        $viaje = array();
        $salidas = array();
        foreach ($data as $field=>$value) {
            if (!$value) continue;// no trata el botón de envío de formulario
            if ($field == 'salida1' || $field == 'salida2')
                $salidas[] = $value;
            else
                $trabajador[$field] = $value;
        }
        $datos = Viajes::insertDB($trabajador);
        if ($datos) {
            // almacenamos el último id insertado
            $id = $database->pdo->lastInsertId();
            foreach ($salidas as $salida) {
                $sali['idViaje']= $id;
                $sali['ciudad']=$salida;
                $datos = Salidas::insertDB($sali);
            }
        }
        if ($datos)
            $database->pdo->commit();
        else
            $database->pdo->rollBack();
        $database->closeConnection();
        return $datos;
    }
    
    public static function searchTipoDB($id){
        $database = medoo::getInstance();
        $database->openConnection(unserialize(MYSQL_CONFIG));
        $datos = $database->select('viajes', "*", ['idTipo[=]' => $id]);
        $database->closeConnection();
        return $datos;
    }
    
    public static function searchAllDB(){
        $database = medoo::getInstance();
        $database->openConnection(unserialize(MYSQL_CONFIG));
        $datos = $database->select('viajes', "*");
        $database->closeConnection();
        return $datos;
    }
    
    public static function nombreTipo($id) {
        $database = medoo::getInstance();
        $database->openConnection(unserialize(MYSQL_CONFIG));
        $datos = $database->select('tipos', 'tipo', ["id[=]" => $id]);
        $database->closeConnection();
        return $datos;
    }

    public static function compTipo() {
        $database = medoo::getInstance();
        $database->openConnection(unserialize(MYSQL_CONFIG));
        $datos = $database->select('tipos', 'id');
        $database->closeConnection();
        return $datos;
    }
    
    public static function searchNombreDB($id){
        $database = medoo::getInstance();
        $database->openConnection(unserialize(MYSQL_CONFIG));
        $datos = $database->select('viajes', "*", ['nombre[=]' => $id]);
        $database->closeConnection();
        return $datos;
    }
    
    public static function removeDB($id){

        $database = medoo::getInstance();
        $database->openConnection(unserialize(MYSQL_CONFIG));
        $datos = Viajes::removeDB($id);
        $datos = Salidas::removeDB($id);
        $database->closeConnection();
        return $datos;
    }
    
    public static function comprobarTipo($id){
        $servicio = new SoapClient('http://localhost/PabloDeSchouwer/servicios/servicio.php?wsdl',array('cache_wsdl' => WSDL_CACHE_NONE));
        $datos = $servicio->comprobarTipo($id);
        return $datos;
}
    
    
    
    public static function searchIdViajesDB($id){

        $database = medoo::getInstance();
        $database->openConnection(unserialize(MYSQL_CONFIG));
        $datos = $database->select('viajes', '*',['id[=]' => $id]);
        $database->closeConnection();
        return $datos;

    }
    
    public static function descripcionDB($id){

        $database = medoo::getInstance();
        $database->openConnection(unserialize(MYSQL_CONFIG));
        $datos = $database->select('viajes', 'descripcion',['id[=]' => $id]);
        $database->closeConnection();
        return $datos;

    }
    
    public static function searchIdDB($id){

        $database = medoo::getInstance();
        $database->openConnection(unserialize(MYSQL_CONFIG));
        $datos = $database->select('salidas', 'ciudad',['idViaje[=]' => $id]);
        $database->closeConnection();
        return $datos;

    }
    
    public static function modifyDB($data, $id) {
        $database = medoo::getInstance();
        $database->openConnection(unserialize(MYSQL_CONFIG));
        $datos = $database->update('viajes', $data, ['id' => $id]);
        $database->closeConnection();
        return $datos;
    }    

}