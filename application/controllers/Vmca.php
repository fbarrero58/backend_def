<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;

class Vmca extends REST_Controller {

    public function __construct(){

		header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header("Access-Control-Allow-Origin: *");

        parent::__construct();
		$this->load->model('Vmca_model');
		$this->load->helper('utilidades');
	}

	public function actividades_get(){
		$token = $_GET['token'];
        $resultadoToken = validar_token($token);

        if( $resultadoToken['err'] ){
            return $this->response($resultadoToken, 403);
		}
		
		$resultado = $this->Vmca_model->traer_actividades();
		return $this->response($resultado);	
	}

	public function lineaservicio_get(){
		$token = $_GET['token'];
        $resultadoToken = validar_token($token);

        if( $resultadoToken['err'] ){
            return $this->response($resultadoToken, 403);
		}
		
		$resultado = $this->Vmca_model->traer_lineaservicio();
		return $this->response($resultado);	
	}

	public function tiposervicio_get(){
		$token = $_GET['token'];
        $resultadoToken = validar_token($token);

        if( $resultadoToken['err'] ){
            return $this->response($resultadoToken, 403);
		}
		
		$resultado = $this->Vmca_model->traer_tiposervicio();
		return $this->response($resultado);	
	}

	public function roles_get(){
		$token = $_GET['token'];
        $resultadoToken = validar_token($token);

        if( $resultadoToken['err'] ){
            return $this->response($resultadoToken, 403);
		}
		
		$resultado = $this->Vmca_model->traer_roles();
		return $this->response($resultado);	
	}

	public function tipoestudio_get(){
		$token = $_GET['token'];
        $resultadoToken = validar_token($token);

        if( $resultadoToken['err'] ){
            return $this->response($resultadoToken, 403);
		}
		
		$resultado = $this->Vmca_model->traer_tipoestudio();
		return $this->response($resultado);	
	}

	public function perfiles_get(){
		$token = $_GET['token'];
        $resultadoToken = validar_token($token);

        if( $resultadoToken['err'] ){
            return $this->response($resultadoToken, 403);
		}
		
		$resultado = $this->Vmca_model->traer_perfiles();
		return $this->response($resultado);	
	}

	public function modulos_get(){
		$token = $_GET['token'];
        $resultadoToken = validar_token($token);

        if( $resultadoToken['err'] ){
            return $this->response($resultadoToken, 403);
		}
		
		$resultado = $this->Vmca_model->traer_modulos();
		return $this->response($resultado);	
	}

	public function tipoempresa_get(){
		$token = $_GET['token'];
        $resultadoToken = validar_token($token);

        if( $resultadoToken['err'] ){
            return $this->response($resultadoToken, 403);
		}
		
		$resultado = $this->Vmca_model->traer_tipoempresa();
		return $this->response($resultado);	
	}


	public function estadoscomerciales_get(){
		$token = $_GET['token'];
        $resultadoToken = validar_token($token);

        if( $resultadoToken['err'] ){
            return $this->response($resultadoToken, 403);
		}
		
		$resultado = $this->Vmca_model->traer_estadoscomerciales();
		return $this->response($resultado);	
	}

	public function estadosfacturacion_get(){
		$token = $_GET['token'];
        $resultadoToken = validar_token($token);

        if( $resultadoToken['err'] ){
            return $this->response($resultadoToken, 403);
		}
		
		$resultado = $this->Vmca_model->traer_estadosfacturacion();
		return $this->response($resultado);	
	}

	public function estadospago_get(){
		$token = $_GET['token'];
        $resultadoToken = validar_token($token);

        if( $resultadoToken['err'] ){
            return $this->response($resultadoToken, 403);
		}
		
		$resultado = $this->Vmca_model->traer_estadospago();
		return $this->response($resultado);	
	}


}
