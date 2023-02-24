<?php 
namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    public static function login(Router $router){
        $alertas = [];
       // $auth = new Usuario;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();

            if(empty($alertas)){
                //Comprobar que exista el usuario
                $usuario = Usuario::where('email', $auth->email);
                if($usuario){
                    //Verificar el password
                    if($usuario->comprobarPasswordAndVerificado($auth->password)){
                        //Autenticamos el usuario
                        //session_start(); //No iniciamos sesión porque nos dice que ya esta activa (en Router)
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " ". $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        //Redireccionamos, segun el tipo de usuario (admin o no)
                        if($usuario->admin === "1"){
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                            //debuguear('Eres admin');
                        }else{
                            header('Location: /cita');
                            //debuguear('Eres cliente');
                        }
                        
                    }
                }else{
                    Usuario::setAlerta('error', 'Usuario no econtrado');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/login', [
            'alertas' => $alertas
        ]); //ender viene de Router
    }

    public static function logout(){
        $_SESSION = [];
        header('Location: /');
    }

    public static function olvide(Router $router){
        $alertas = []; //creamos el arreglo paara guardar las alertas

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail(); //Igualamos el arreglo de alertas para recibir las que retorna la funcion
            
            if(empty($alertas)){
                //verificamos que el email exista
                $usuario = Usuario::where('email', $auth->email);
                if($usuario && $usuario->confirmado === "1"){
                    //Generamos un token
                    $usuario->crearToken();
                    $usuario->guardar();
                //TODO: Enviar el email (TODO hace referencia a cosas por hacer), en este caso ya lo hicimos, pero lo dejamos como ejemplo
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->apellido, $usuario->token);
                    $email->enviarInstrucciones();
                    Usuario::setAlerta('exito', 'Hemos enviado las instrucciones a tu correo');
                }else{
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                }                
            }
        }
        
        $alertas = Usuario::getAlertas();
        $router->render('auth/olvide-password', [
            'alertas' => $alertas
        ]);
    }

    public static function recuperar(Router $router){
        $alertas = [];
        $error = false;
        $token = s($_GET['token']);

        //Buscamos usuario por su token
        $usuario = Usuario::where('token', $token);
        
        if(empty($usuario)){
            Usuario::setAlerta('error', 'Token no válido');
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Leer el nuevo password
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();

            if(empty($alertas)){
                $usuario->password = null;
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;

                $resultado = $usuario->guardar();
                if($resultado){
                    header('Location: /');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-password', [
            'alertas' => $alertas,
            'error' => $error
        ]);
        
    }

    public static function crear(Router $router){
        $usuario = new Usuario();

        //Alertas vacias
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            //Revisar que alerta este vacío
            if(empty($alertas)){
                //verificar que el usuario no este registrado
                $resultado = $usuario->existeUsuario();
                if($resultado->num_rows){
                    $alertas = Usuario::getAlertas();
                }else{
                    //Hashear password
                    $usuario->hashPassword();

                    //Generar un token único
                    $usuario->crearToken();

                    //Enviar email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->apellido, $usuario->token);
                    $email->enviarConfirmacion();
                    
                    //Creamos el usuario
                    $resultado = $usuario->guardar();
                    if($resultado){
                        header('Location: /mensaje');
                    }
                    //debuguear($usuario);
                }
            }
        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario ,
            'alertas' => $alertas
        ]);
    }

    //Para el mensaje despues de guardar
    public static function mensaje(Router $router){
        $router->render('auth/mensaje'); //ender viene de Router
    }

    //Para la parte donde debe confirmar su cuenta 
    public static function confirmar(Router $router){
        $alertas = [];

        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);
        if(empty($usuario)){
            //Mostrar mensaje de error
            Usuario::setAlerta('error', 'Token no válido');
        }else{
            //Modificar a usuario confirmado
            $usuario->confirmado = "1";
            $usuario->token = "";
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta comprobada correctamente');
        }

        //Obtenemos las alertas
        $alertas = Usuario::getAlertas();
        //redireccionamos
        $router->render('auth/confirmar-cuenta', [
            'alertas'=> $alertas
        ]);
    }
}