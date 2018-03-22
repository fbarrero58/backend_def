<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;

class Usuarios extends REST_Controller {
	public function __construct(){

        header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header("Access-Control-Allow-Origin: *");

        parent::__construct();
        $this->load->model('Usuario_model');
        $this->load->helper('utilidades');
    }

    /******************************
        Insertar Usuario
    ******************************/

    public function index_post(){ 

        $data = $this->post();
        $token = $_GET['token'];
        $resultadoToken = validar_token($token);

        if( $resultadoToken['err'] ){
            return $this->response($resultadoToken, 403);
        }

        $this->load->library('form_validation');
        $this->form_validation->set_data($data);

        if( $this->form_validation->run( 'usuarios_post' ) ){
            
            $resultado = $this->Usuario_model->insertar($data);

            if ($resultado['err']){
                return $this->response($resultado, 404);
            }else{
                $respuesta = array(
                    'err' => False,
                    'mensaje' => 'Usuario creado exitosamente'
                );
                //ENVIAR CORREO ELECTRONICO
                return $this->response( $respuesta, 201);
            }  
        }else{
            $respuesta = array(
                'err' => TRUE,
                'mensaje' => $this->form_validation->get_errores_arreglo()
            );
            return $this->response( $respuesta, 400);
        }
    }

    /******************************
        Obtener usuarios
    ******************************/

    public function index_get($id=null){

        $token = $_GET['token'];
        $resultadoToken = validar_token($token);

        if( $resultadoToken['err'] ){
            return $this->response($resultadoToken, 403);
        }

        $usuario = $this->Usuario_model->obtener($id);

        if(!isset($usuario)){
            $respuesta = array(
                'err' => TRUE,
                'mensaje' => 'No existe un usuario con el ID '. $id
            );
            return $this->response($respuesta, 404);
        }else{
            $respuesta = array(
                'err' => FALSE,
                'mensaje' => 'Registro cargado correctamente',
                'Usuarios' => $usuario
            );
            return $this->response($respuesta); //retorna a json 
        }
    }

    /******************************
        Actualizar usuarios
    ******************************/

    public function index_put( $id=null){

        $data = $this->put();
        $token = $_GET['token'];
        $resultadoToken = validar_token($token);

        if( $resultadoToken['err'] ){
            return $this->response($resultadoToken, 403);
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

            if( $this->form_validation->run( 'usuarios_put' ) ){

                $respuesta = $this->Usuario_model->actualizar($id,$data);
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

    /******************************
        Asignar modulos
    ******************************/

    public function modulo_post($id=null){

        $token = $_GET['token'];
        $resultadoToken = validar_token($token);

        if( $resultadoToken['err'] ){
            return $this->response($resultadoToken, 403);
        }

        if( !isset($id) ){
            $respuesta = array(
                'err' => TRUE,
                'mensaje' => 'Debe especificar el ID del usuario'
            );
            return $this->response($respuesta, 400);
        }

        $data = $this->post();

        $respuesta = $this->Usuario_model->asignar_modulo($id, $data);

        if( $respuesta['err'] ){
            return $this->response($respuesta);
        }else{
            return $this->response($respuesta,400);
        }

        

    }

    /******************************
        Traer modulos de usuario
    ******************************/

    public function modulo_get($id=null){

        $token = $_GET['token'];
        $resultadoToken = validar_token($token);

        if( $resultadoToken['err'] ){
            return $this->response($resultadoToken, 403);
        }

        $respuesta = $this->Usuario_model->traer_modulos($id);

        return $this->response($respuesta);

    }

    /******************************
        Eliminar modulo de usuario
    ******************************/

    public function modulo_delete($id_usuario=null, $id_modulo=null){

        $token = $_GET['token'];
        $resultadoToken = validar_token($token);

        if( $resultadoToken['err'] ){
            return $this->response($resultadoToken, 403);
        }

        if( !isset($id_usuario) || !isset($id_modulo) ){
            $respuesta = array(
                'err' => TRUE,
                'mensaje' => 'Se debe especificar el usuario y el módulo'
            );
            $this->response($respuesta, 400);
        }

        $respuesta = $this->Usuario_model->eliminar_modulo($id_usuario, $id_modulo);

        return $this->response($respuesta);

    }
    
    
}
