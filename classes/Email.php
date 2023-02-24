<?php 
namespace Classes;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Email{
    public $email;
    public $nombre;
    public $token;
    public $apellido;

    public function __construct($email, $nombre, $apellido, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->token = $token;        
    }

    public function enviarConfirmacion() {
        //Crear el objeto de email
       try{$mail = new PHPMailer(true); 
        $mail->isSMTP(); //Protocolo de envio de email
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port       = 2525;  
        $mail->Username = '58d433e6d7754b';
        $mail->Password = '1900a816b2d44c';

        $mail->setFrom('cuentas@appsalon.com', 'AppSalon');//Quien lo envia
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Confirma tu cuenta';

        //Indicamos que vamos a utilizar HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p>Hola <strong>" . $this->nombre . " ". $this->apellido . "</strong>. Has creado una cuenta en AppSalon, 
                        solo necesitamos que confirmes tu cuenta presionando el siguiente enlace.</p>";
        $contenido .= "<p>Presiona aquí: <a href='http://localhost:3000/confirmar-cuenta?token=" . $this->token . "'>Confirmar cuenta</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";
        $mail->Body = $contenido;

        //Enviamos el email
        $mail->send();
            //echo "Mensaje enviado";
        }catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function enviarInstrucciones(){
        
        //Crear el objeto de email
        try{$mail = new PHPMailer(true);
        //Estos datos iniciales te los da mailtrap al iniciar sesion, en la parte de inboxes
        $mail->isSMTP(); //Protocolo de envio de email
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port       = 2525;  
        $mail->Username = '58d433e6d7754b';
        $mail->Password = '1900a816b2d44c';

        $mail->setFrom('cuentas@appsalon.com', 'AppSalon');//Quien lo envia
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Reestablece tu password';

        //Indicamos que vamos a utilizar HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p>Hola <strong>" . $this->nombre . " ". $this->apellido . "</strong>. Has solicitado reestablecer tu password, 
                        presiona el siguiente enlace.</p>";
        $contenido .= "<p>Presiona aquí: <a href='http://localhost:3000/recuperar?token=" . $this->token . "'>Reestablecer password</a></p>";
        $contenido .= "<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje.</p>";
        $contenido .= "</html>";
        $mail->Body = $contenido;

        //Enviamos el email
        $mail->send();
            //echo "Mensaje enviado";
        }catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}