<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;

class Prueba extends REST_Controller {

    public function index_get(){
        $this->response('Saludos desde el GET');
    }

    public function index_post(){
        $data = $this->post();
        $this->response($data);
    }

    public function obtener_arreglo_get( $index ){

        $arreglo = array( "Manzana", "Pera", "Piña" );

        return $this->response($arreglo[$index]);

    }


}