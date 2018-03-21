<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;

class Login extends REST_Controller {

    public function __construct(){

        header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header("Access-Control-Allow-Origin: *");

        parent::__construct();
        $this->load->model('Login_model');
        $this->load->helper('utilidades');
    }

    public function index_get(){
        return $this->response('saludos desde el get');
    }

    public function imagen_post(){

        $resultado = subir_archivo('usuarios',$_FILES);

        if( $resultado ){
            $respuesta = array(
                'OK' => TRUE,
                'mensaje' => 'Archivo cargado exitosamente'
            );
            return $this->response($respuesta);
        }else{
            $respuesta = array(
                'OK' => FALSE,
                'mensaje' => 'No se pudo cargar el archivo'
            );
            return $this->response($respuesta,500);
        }
    }

    /*******************************
        POST - Iniciar Sesión
    *******************************/

    public function index_post(){

        $data = $this->post();  

        $respuesta = array(
            'OK' => TRUE,
            'mensaje' => $data
        );

        $respuesta = $this->Login_model->ingresar($data);

        if($respuesta['err']){
            return $this->response($respuesta, 400);
        }else{
            return $this->response($respuesta);
        }

    }

    /*******************************
        PUT - Actualizar contraseña
    *******************************/

    public function index_put(){

        $data = $this->put();
        $respuesta = $this->Login_model->nueva_pass($data);
        return $this->response($respuesta);

    }

    /*******************************
        Desencriptar token - Prueba
    *******************************/

    public function validar_get( ){
        $valor = $_GET['token'];

        $resultado = validar_token($valor);

        return $this->response($resultado);
    }

}