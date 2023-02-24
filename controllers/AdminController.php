<?php
namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController{
    public static function index(Router $router){

        isAdmin();

        $fecha = $_GET["fecha"] ?? date('Y-m-d'); //Si no hay fecha a buscar, toma la del dia actual
        $fechas = explode('-', $fecha);
        if(!checkdate($fechas[1], $fechas[2], $fechas[0])){ //Si es diferente a true
            header('Location: /404');
        }

        //Consultar la base de datos
        $consulta = " SELECT c.id, c.hora, CONCAT(u.nombre, ' ',u.apellido) as cliente, ";
        $consulta .= " u.email, u.telefono, s.nombre as servicio, s.precio";
        $consulta .= " FROM citas c";
        $consulta .= " LEFT OUTER JOIN usuarios u ";
        $consulta .= " ON c.usuarioId=u.id ";
        $consulta .= " LEFT OUTER JOIN citasservicios cs ";
        $consulta .= " ON cs.citaId=c.id ";
        $consulta .= " LEFT OUTER JOIN servicios s ";
        $consulta .= " ON s.id=cs.servicioId ";
        $consulta .= " WHERE fecha = '$fecha' ";    

        $citas = AdminCita::SQL($consulta);

        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha
        ]);
    }
}