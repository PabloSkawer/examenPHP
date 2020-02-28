<?php
class Validacion extends Singleton
{
    private $_rules = array();
    private $_errors = array(); // ejemplo: _errors['nombre'] = array('value' => 'Pedro','rule' => 'required')
    private $_oks = array();
    private $_errorFoto;
    private $_exists;
    
    public function addRules($rules){
        $this->_rules = $rules;
    }
    public function run($toValidate)
    {
        foreach ($toValidate as $field => $value) {
            // si el nombre del campo no esta en $this->_rules es que no hay que validarlo
            if (!array_key_exists($field, $this->_rules)) continue;
            // creamos un array con la cadena $this->_rules[$field] usando como separador de elementos |
            $rules = explode('|', $this->_rules[$field]);
            // Si el campo es requerido en $rules hay un elemento cuyo contenido es 'required'
            if (in_array('required', $rules)) {
                // el método validate_required verifica si el campo tiene contenido, es decir, ha sido rellenado
                // si no es así, añade el campo al array _errors
                $this->_validate_required($field, $value);
                // si el campo no se ha rellenado no sigue relizando el control de entrada
                // por ello verifica que si existe un elemento con el 'rule'='required'
                // getArray() esta definida en common.php
                if (getArray($this->getErrorsByField($field), 'rule') == 'required')
                    continue;
            }
            foreach ($rules as $rule) {
                if ($rule == 'required') continue;
                $method = '_validate_' . $rule;
                // verifica si el método de validación existe en esta clase (constante __CLASS__)
                if (!method_exists(__CLASS__, $method)) continue;
                // ejecuta el método de validación (por ejemplo, validate_alpha_space)
                $this->$method($field, $value);
            }
            // puede que en los formularios haya algún campo que no queramos validar,
            // pero hay que registrarle en _errors para que el método mdlPaso1() recupere su valor
            if (empty($this->getErrorsByField($field)))
                $this->_setError($field, $value, 'ok');
        }
    }
    public function isValid()
    {
        if (count($this->_oks) == count($this->_errors))
            return true;
        return false;
    }
    public function getStrRule($rule)
    {
        switch ($rule) {
                // solo hay una posible coincidencia, pero ya añadiremeos más
            case 'alpha_space':
                return 'Solo puede contener letras (a-z) y espacios en blanco, hasta 20 caracteres';
            case 'alpha_spaceCom':
                return 'Solo puede contener letras (a-z) y espacios en blanco, comas y puntos, hasta 100 caracteres';
            case 'alphanum_simple':
                return 'Solo puede contener de 5 a 15 letras y números (a-z)';    
            case 'foto':
                return $this->_errorFoto;
            case 'duplicate':
                return 'Usuario duplicado';
            case 'numeric':
                return 'Debe ser un número';
            case 'email':
                return 'Debe contener una dirección valida de email';
            case 'encontrado':
                return 'No está dentro de los tipos actuales';
        }
        return '';
    }
    public function setExists($dup)
    {
        $this->_exists = $dup;
    }
    public function restoreValue($name)
    {
        if (array_key_exists($name, $this->_errors)) {
            $value = $this->_errors[$name]['value'];
            return "$value";
        }
        return "";
    }
    public function restoreCheckboxes($name, $value, $default = false)
    {
        //si _errors está vacío, es la primera vez que se visualiza el formulario
        if ($this->_errors) {
            if (array_key_exists($name, $this->_errors)) {
                // _errors[$name]['value'] es un array (Bicicleta, Tren etc.)

                if ($this->_errors[$name]['value'] == $value)
                    return 'checked';
            }
            // es la primera vez que se visualiza el formulario y podemos poner valores por defecto.
        } elseif ($default)
            return 'checked';
    }
    public function restoreSelects($name, $value, $default = false)
    {
        //si _errors está vacío, es la primera vez que se visualiza el formulario
        if ($this->_errors) {
            if (array_key_exists($name, $this->_errors)) {
                // _errors[$name]['value'] es un array (Bicicleta, Tren etc.)
                foreach ($this->_errors[$name]['value'] as $valor) {
                    if ($valor == $value)
                        return 'selected';
                }
            }
            // es la primera vez que se visualiza el formulario y podemos poner valores por defecto.
        } elseif ($default)
            return 'selected';
    }
    public function restoreRadios($name, $value, $default = false)
    {
        if (array_key_exists($name, $this->_errors)) {
            if ($this->_errors[$name]['value'] == $value)
                return 'checked';
            // si el nombre del campo no está en _errors, es que es la primera vez que se visualiza el formulario
            // y es cuando podemos poner valores por defecto.
        } elseif ($default)
            return 'checked';
        return '';
    }
    public function getOks()
    {
        return $this->_oks;
    }
    // método que devuelve el elemento del array _errors de un campo (si existe)
    public function getErrorsByField($field)
    {
        return getArray($this->_errors, $field, array());
    }
    public function getErrors()
    {
        return $this->_errors;
    }
    private function _setError($field, $value, $rule)
    {
        $this->_errors[$field] = array(
            'value' => $value,
            'rule' => $rule
        );
        if ($rule == 'ok') {
            $this->_oks[$field] = $value;
        }
    }
    // Método que valida que el dato introducido en el campo es correcto
    // Observa que la 2ª parte del nombre del método (alpha_space) coincide con el tipo de dato
    // que se utiliza en el array $_rules de la clase mdlPaso1
    private function _validate_alpha_space($field, $value)
    {
        if (!preg_match('/^([a-zÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ\s]){2,20}$/i', $value))
            $this->_setError($field, $value, 'alpha_space');
        else
            $this->_setError($field, $value, 'ok');
    }
    private function _validate_alpha_spaceCom($field, $value)
    {
        if (!preg_match('/^([a-zÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ\s,.]){1,100}$/i', $value))
            $this->_setError($field, $value, 'alpha_spaceCom');
        else
            $this->_setError($field, $value, 'ok');
    }
    private function _validate_foto($field, $value)
    {
        if ($value["error"] == UPLOAD_ERR_OK) {
            if (($value["type"] != "image/pjpeg") and ($value["type"] != "image/jpeg")) {
                $this->_setError($field, $value, 'foto');
                $this->_errorFoto = "<b>JPEG fotos solamente, gracias!</b>";
            } elseif (!move_uploaded_file($value["tmp_name"], "fotos/" . basename($value["name"]))) {
                $this->_setError($field, $value, 'foto');
                $this->_errorFoto = "<b>Lo sentimos, hubo un problema al subir esa foto</b>" . $value["error"];
            } else
                $this->_setError($field, $value, 'ok');
        } else {
            $this->_setError($field, $value, 'foto');
            switch ($value["error"]) {
                case UPLOAD_ERR_INI_SIZE:
                    $this->_errorFoto = "<b>La foto es más grande de lo que permite el servidor.<b>";
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $this->_errorFoto = "<b>La foto es más grande de lo que permite el formulario.<b>";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $this->_setError($field, $value, 'required');
                    if(isset($_SESSION['edicion']))$this->_setError($field, $value, 'ok');
                    break;
                default:
                    $this->_errorFoto = "Ponte en contacto con el administrador del servidor para obtener ayuda.";
            }
        }
    }
    // método que añade una elemento al array _errors cuando un campo obligatorio no se ha completado
    private function _validate_required($field, $value)
    {
        if (strlen($value) == 0)
            $this->_setError($field, $value, 'required');
    }
    private function _validate_numeric($field, $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_INT))
            $this->_setError($field, $value, 'numeric');
        else $this->_setError($field, $value, 'ok');
    }
    private function _validate_alphanumeric($field, $value)
    {
        if (!preg_match('/^([a-zA-Z0-9\S]){6}$/i', $value))
            $this->_setError($field, $value, 'alphanumeric');
        else
            $this->_setError($field, $value, 'ok');
    }
    private function _validate_dni($field, $value)
    {
        if (!preg_match('/^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKE]{1}$/i', $value))
            $this->_setError($field, $value, 'dni');
        else
            $this->_setError($field, $value, 'ok');
    }
    private function _validate_duplicate($field, $value)
    {
        if ($this->_exists)
            $this->_setError($field, $value, 'duplicate');
    }
    private function _validate_alphanum_simple($field, $value)
    {
        if (!preg_match('/^([a-zA-Z0-9]){5,15}+$/', $value))
            $this->_setError($field, $value, 'alphanum_simple');
        else
            $this->_setError($field, $value, 'ok');
    }
    private function _validate_email($field, $value)
    {
        if (!preg_match('/^[A-Za-z0-9_.\-]+@[A-Za-z0-9_.\-]+.[A-Za-z]{2,3}$/', $value))
            $this->_setError($field, $value, 'email');
        else
            $this->_setError($field, $value, 'ok');
    }
     private function _validate_encontrado($field, $value)
    {
        if (!preg_match('/^[1-3]{1}/', $value))
            $this->_setError($field, $value, 'encontrado');
        else
            $this->_setError($field, $value, 'ok');
    }
    
    /*private function _validate_encontrado($field, $value)
    {
        foreach(ClaseGenerica::compTipo() as $id){
            
            if($value == $id[0]) $this->_setError($field, $value, 'ok');
            
        }
         
         $this->_setError($field, $value, 'encontrado');
    }*/
    
    private function _validate_numeros($field, $value){
            
            if(!preg_match('/^[0-9]{1,5}$/', $value)) $this->_setError($field, $value, 'numeros');
            else $this->_setError($field, $value, 'ok');
        
    }
}
