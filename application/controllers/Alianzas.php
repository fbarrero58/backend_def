<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;

class Alianzas extends REST_Controller {

    public function __construct(){

        header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header("Access-Control-Allow-Origin: *");

        parent::__construct();
        $this->load->model('Alianza_model');
        $this->load->model('Contacto_model');
        $this->load->helper('utilidades');
    }

    /*******************************
        POST
    *******************************/

    public function index_post(){

        $data = $this->post();
        $token = $_GET['token'];
        $resultadoToken = validar_token($token);

        if( $resultadoToken['err'] ){
            return $this->response($resultadoToken);
        }

        $this->load->library('form_validation');
        $this->form_validation->set_data($data);

        if( $this->form_validation->run('alianzas_post') ){

            $resultado = $this->Alianza_model->insertar($data);

            if($resultado['err']){
                return $this->response($resultado, 400);
            }

            return $this->response($resultado, 201);

        }else{

            $respuesta = array(
                'err' => TRUE,
                'mensaje' => $this->form_validation->get_errores_arreglo()
            );
            return $this->response( $respuesta, 400 );

        }

    }

    /*******************************
        GET
    *******************************/

    public function index_get( $id=null ){

        $token = $_GET['token'];
        $resultadoToken = validar_token($token);

        if( $resultadoToken['err'] ){
            return $this->response($resultadoToken);
        }
        
        $resultado = $this->Alianza_model->todos();
        return $this->response($resultado);

    }

    /*******************************
        PUT
    *******************************/

    public function index_put( $id=null ){

        $data = $this->put();
        $token = $_GET['token'];
        $resultadoToken = validar_token($token);

        if( $resultadoToken['err'] ){
            return $this->response($resultadoToken);
        }

        $this->load->library('form_validation');
        $this->form_validation->set_data($data);

        if( !isset($id) ){

            $respuesta = array(
                'err' => TRUE,
                'mensaje' => 'Se debe especificar un ID'
            );
            return $this->response($respuesta,404);

        }else{

            if( $this->form_validation->run( 'alianzas_post' ) ){

                $respuesta = $this->Alianza_model->actualizar($id,$data);
                return $this->response($respuesta);

            }else{

                $respuesta = array(
                    'err' => TRUE,
                    'mensaje' => $this->form_validation->get_errores_arreglo()
                );
                return $this->response($respuesta, 400);
            }

        }
        
    }

    /*******************************
        GET - Contactos
    *******************************/

    public function contacto_get($id=null){

        $token = $_GET['token'];
        $resultadoToken = validar_token($token);

        if( $resultadoToken['err'] ){
            return $this->response($resultadoToken, 403);
        }

        if( !isset($id) ){
            $respuesta = array(
                'err' => true,
                'mensaje' => 'Se debe especificar el ID de la alianza'
            );
            return $this->response($respuesta,400);
        }

        $respuesta = $this->Contacto_model->todos($id,'alianza');
        return $this->response($respuesta);

    }

    /*******************************
        POST - Contactos
    *******************************/

    public function contacto_post(){

        $token = $_GET['token'];
        $resultadoToken = validar_token($token);

        if( $resultadoToken['err'] ){
            return $this->response($resultadoToken, 403);
        }

        $data = $this->post();

        $respuesta = $this->Contacto_model->insertar($data);

        $this->response($respuesta);

    }

    /*******************************
        PUT - Contactos
    *******************************/

    public function contacto_put($id){

        $token = $_GET['token'];
        $resultadoToken = validar_token($token);

        if( $resultadoToken['err'] ){
            return $this->response($resultadoToken, 403);
        }

        $data = $this->put();

        $resultado = $this->Contacto_model->actualizar($id,$data);
        return $this->response($resultado);

    }

}