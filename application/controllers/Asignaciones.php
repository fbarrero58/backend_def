<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;

class Asignaciones extends REST_Controller {

    public function __construct(){

        header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header("Access-Control-Allow-Origin: *");

        parent::__construct();
		$this->load->model('Asignacion_model');
		$this->load->helper('utilidades');
	}

	/******************************
        Insertar Asignación
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

        if( $this->form_validation->run('asignacion_post') ){

            $resultado = $this->Asignacion_model->insertar($data);

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

	/******************************
        Actualizar Asignación
	******************************/

	public function index_put($id=null){
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

            if( $this->form_validation->run( 'asignacion_put' ) ){

                $respuesta = $this->Asignacion_model->actualizar($id,$data);
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
        Traer Asignación
	******************************/

	public function index_get( $id=null ){

        $token = $_GET['token'];
        $resultadoToken = validar_token($token);

        if( $resultadoToken['err'] ){
            return $this->response($resultadoToken);
        }

        if(!isset($id)){
            $resultado = $this->Asignacion_model->todos();
        }else{
            $resultado = $this->Asignacion_model->por_id($id);
        }
        return $this->response($resultado);
	}
	
	/******************************
       Eliminar Asignación
	******************************/
	
	public function index_delete($id=null){
		$token = $_GET['token'];
        $resultadoToken = validar_token($token);

        if( $resultadoToken['err'] ){
            return $this->response($resultadoToken, 403);
		}
		
		if( !isset($id) ){
            $respuesta = array(
                'err' => TRUE,
                'mensaje' => 'Se debe especificar un ID'
            );
            return $this->response($respuesta,404);
        }else{
			$resultado = $this->Asignacion_model->eliminar($id);
			return $this->response($resultado);
		}
	}


}
