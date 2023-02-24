<?php 
namespace Model;

class Usuario extends ActiveRecord {
    //Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB =['id', 'nombre', 'apellido', 'password', 'email', 'telefono', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $password;
    public $email;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? "0";
        $this->confirmado = $args['confirmado'] ?? "0";
        $this->token = $args['token'] ?? "";
    }

    //Mensaje de validacion para la creacion de una cuenta
    public function validarNuevaCuenta()
    {
        if(!$this->nombre){ //Si el campo nombre esta vacío
            self::$alertas['error'][] = 'El nombre es Obligatorio'; //hacemos referencia a $alerta de ActiveRecord
        }
        if(!$this->apellido){ //Si el campo nombre esta vacío
            self::$alertas['error'][] = 'El apellido es Obligatorio'; //hacemos referencia a $alerta de ActiveRecord
        }
        if(!$this->email){ //Si el campo nombre esta vacío
            self::$alertas['error'][] = 'El email es Obligatorio'; //hacemos referencia a $alerta de ActiveRecord
        }
        if(!$this->telefono){ //Si el campo nombre esta vacío
            self::$alertas['error'][] = 'El telefono es Obligatorio'; //hacemos referencia a $alerta de ActiveRecord
        }
        if(!$this->password || strlen($this->password) < 8){ //Si el campo nombre esta vacío
            self::$alertas['error'][] = 'El password es Obligatorio y debe contener al menos 8 caracteres'; //hacemos referencia a $alerta de ActiveRecord
        }  
        /*if(strlen($this->password) < 8){
            self::$alertas['error'][] = 'El password debe contener al menos 8 caracteres';
        }*/
        return self::$alertas; //retorna los errores en caso de que haya
    }

    public function validarLogin(){
        if(!$this->email){
            self::$alertas['error'][] = 'El email es Obligatorio';
        }
        if(!$this->password){ //Si el campo nombre esta vacío
            self::$alertas['error'][] = 'El password es Obligatorio'; //hacemos referencia a $alerta de ActiveRecord
        } 

        return self::$alertas;
    }

    public function validarEmail(){
        if(!$this->email){
            self::$alertas['error'][] = 'El email es Obligatorio';
        }
        return self::$alertas; //Retornamos las alertas producidas
    }

    public function validarPassword(){
        if(!$this->password){
            self::$alertas['error'][] = 'El Password es Obligatorio';
        }
        if(strlen($this->password) < 8){
            self::$alertas['error'][] = 'El Password debe tener al menos 8 caracteres';
        }
        return self::$alertas; //Retornamos las alertas producidas
    }

            //Revisar si el usuario ya existe
    public function existeUsuario(){
        $query = "SELECT * FROM  " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1"; //LIMIT 1, a la 1° coincidencia se detenga
        $resultado = self::$db->query($query);

        if($resultado->num_rows){ //Si ya hay un registro
            self::$alertas['error'][] = 'El usuario ya esta registrado'; //Colocamos una alerta
        }
        return $resultado; //Y retornamos el resultado
    }

    //Hasheamos la password
    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken(){
        $this->token = uniqid();
    }

    public function comprobarPasswordAndVerificado($password){
        $resultado = password_verify($password, $this->password);
        if(!$resultado || !$this->confirmado){
            self::$alertas['error'][] = 'Password incorrecto o tu cuenta no ha sido confirmada';
        }else{
            return true;
        }
    }
}