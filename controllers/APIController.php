<?php 
namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController {

    public static function index(){
        $servicios = Servicio::all();
        echo json_encode($servicios);  //Convierte a objeto para manejarlo con JS, ya que los arreglos asociativos no existen en el
    }

    public static function guardar(){
        //Almacena la cita y devuelve le id
        $cita = new Cita($_POST);
        $resultado = $cita->guardar(); //Guardamos en la BD

        $id = $resultado['id'];

        //Almacena los servicios con el id de  la cita 
        $idServicios = explode(",", $_POST['servicios']);

        foreach($idServicios as $idServicio){
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];

            //Guardamos en la BD
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }

        //Retornamos una respuesta
        echo json_encode(['resultado' => $resultado]);

        /*$respuesta = [
            'resultado' => $resultado
        ];*/
    }

    
    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            $cita = Cita::find($id);
            $cita->eliminar();
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }
}