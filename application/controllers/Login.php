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

    /*******************************
        POST - Iniciar Sesión
    *******************************/

    public function index_post(){

        $data = $this->post();  

        // $data = json_decode($data);

        $respuesta = array(
            'OK' => TRUE,
            'mensaje' => $data
        );

        //return $this->response($respuesta);

        //return $this->response($data);

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
        $this->response($respuesta);

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