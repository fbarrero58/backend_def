<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;

class Propuestas extends REST_Controller {

    public function __construct(){

        header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header("Access-Control-Allow-Origin: *");

        parent::__construct();
		$this->load->model('Propuesta_model');
		$this->load->helper('utilidades');
	}

	/******************************
        Insertar Propuesta
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

        if( $this->form_validation->run('propuesta_post') ){

            $resultado = $this->Propuesta_model->insertar($data);

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
        Actualizar Propuesta
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

            if( $this->form_validation->run( 'propuesta_put' ) ){

                $respuesta = $this->Propuesta_model->actualizar($id,$data);
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
        Insertar Condicion Comercial
	******************************/

	public function condicion_post($id = null){
        $data = $this->post();
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

			if( $this->form_validation->run('condicion_post') ){

				$resultado = $this->Propuesta_model->insertar_condicion($id, $data);

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
	}

	/******************************
        Actualizar Asignación
	******************************/

	public function condicion_put($id=null){
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

            if( $this->form_validation->run( 'condicion_put' ) ){

                $respuesta = $this->Propuesta_model->actualizar_condicion($id,$data);
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
        Traer Propuesta
	******************************/

	public function index_get( $id=null ){
        $token = $_GET['token'];
        $resultadoToken = validar_token($token);

        if( $resultadoToken['err'] ){
            return $this->response($resultadoToken);
        }

        if(!isset($id)){
            $resultado = $this->Propuesta_model->todos();
        }else{
            $resultado = $this->Propuesta_model->por_id($id);
        }
        return $this->response($resultado);
	}

}
