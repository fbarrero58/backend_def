<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Asignacion_model extends CI_Model {
    public function __construct(){
        $this->load->database();
	}

	/******************************
        Insertar Asignación
	******************************/

	public function insertar(){

        $data_insertar = array(
            'id' => $data['empresa'],
            'id_tipo_servicio' => $data['tipo_servicio'],
            'id_linea_servicio' => $data['linea_servicio'],
            'id_alianza' => $data['alianza'],
            'id_oportunidad' => $data['oportunidad'],
            'codigo' => $data['codigo'],
            'nombre' => $data['nombre'],
            'fecha_inicio' => $data['inicio'],
            'fecha_fin' => $data['fin'],
            'habilitado' => $data['habilitado'],
            'tiene_ticket' => $data['ticket'],
            'horas_disponibles' => $data['horas'],
            'facturable' => $data['facturable'],
        );

        $this->db->insert('proyectos', $data_insertar);

        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Proyecto creado exitosamente'
        );

        return $respuesta;
	}

}
