<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;

class Solicitudes extends REST_Controller {
	public function __construct(){

		header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header("Access-Control-Allow-Origin: *");

        parent::__construct();
		$this->load->model('Solicitud_model');
		$this->load->helper('utilidades');
	}
	
	/******************************
        Insertar Permiso
	******************************/

	public function permiso_post(){ 		
		$data = $this->post();
		$token = $_GET['token'];
        $resultadoToken = validar_token($token);

        if( $resultadoToken['err'] ){
            return $this->response($resultadoToken, 403);
		}
		
		$this->load->library('form_validation');
		$this->form_validation->set_data($data);

		if( $this->form_validation->run('permisos_post') ){

			if($data['id_usuario_solicitante']==$data['id_usuario_aprobador']){
				$respuesta = array(
					'err' => TRUE,
					'mensaje' => "Solicitud no puede ser aprobada por usuario solicitante"
				);
				return $this->response( $respuesta, 400 );	    
			}	

			$resultado = $this->Solicitud_model->insertar_permiso($data);
				    
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
        Insertar Vacación
	******************************/

	public function vacacion_post(){
		$data = $this->post();
		$token = $_GET['token'];
        $resultadoToken = validar_token($token);

        if( $resultadoToken['err'] ){
            return $this->response($resultadoToken, 403);
        }
		
		$this->load->library('form_validation');
		$this->form_validation->set_data($data);

		if( $this->form_validation->run('vacaciones_post') ){

			if($data['id_usuario_solicitante']==$data['id_usuario_aprobador']){
				$respuesta = array(
					'err' => TRUE,
					'mensaje' => "Solicitud no puede ser aprobada por usuario solicitante"
				);
				return $this->response( $respuesta, 400 );	    
			}

			$resultado = $this->Solicitud_model->insertar_vacacion($data);
				    
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
        Insertar Día Compensatorio
	******************************/

	public function compensatorio_post(){
		$data = $this->post();
		$token = $_GET['token'];
        $resultadoToken = validar_token($token);

        if( $resultadoToken['err'] ){
            return $this->response($resultadoToken, 403);
		}
		
		$this->load->library('form_validation');
		$this->form_validation->set_data($data);

		if( $this->form_validation->run('compensatorio_post') ){

			if($data['id_usuario_solicitante']==$data['id_usuario_aprobador']){
				$respuesta = array(
					'err' => TRUE,
					'mensaje' => "Solicitud no puede ser aprobada por usuario solicitante"
				);
				return $this->response( $respuesta, 400 );	    
			}

			$resultado = $this->Solicitud_model->insertar_compensatorio($data);
				    
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
        Traer Solicitudes
	******************************/
	
	public function usuario_get( $id=null ){
		$token = $_GET['token'];
        $resultadoToken = validar_token($token);

        if( $resultadoToken['err'] ){
            return $this->response($resultadoToken, 403);
        }

        $resultado = $this->Solicitud_model->solicitudes_traer($id);
		return $this->response($resultado);
	}

	/******************************
	   Traer solicitudes por aprobar
	******************************/

	public function aprobacion_get( $id ){
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
			$resultado = $this->Solicitud_model->aprobacion_traer($id);
			return $this->response($resultado);
		}

	}

	/******************************
        Aprobar/Rechazar Solicitud
	******************************/

	public function aprobacion_put($id=null){ //pasar usario por url?
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
			if( $this->form_validation->run( 'aprobar_put' ) ){

                $respuesta = $this->Solicitud_model->aprobar($id,$data);
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
        Modificar permiso
	******************************/
	public function permiso_put($id=null ){
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
            if( $this->form_validation->run( 'permisos_put' ) ){
				$respuesta = $this->Solicitud_model->modificar_permiso($id,$data);
				if ($resultado['err']){
					return $this->response($resultado, 404);
				}
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
        Modificar Vacación
	******************************/
	public function vacacion_put($id=null){
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
            if( $this->form_validation->run( 'vacaciones_put' ) ){
                $respuesta = $this->Solicitud_model->modificar_vacacion($id,$data);
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
        Modificar Compensatorio
	******************************/

	public function compensatorio_put($id=null){
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
            if( $this->form_validation->run( 'compensatorio_put' ) ){
                $respuesta = $this->Solicitud_model->modificar_compensatorio($id,$data);
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

	}


