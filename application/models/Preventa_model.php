<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Preventa_model extends CI_Model {
    public function __construct(){
        $this->load->database();
	}

	/******************************
        Insertar Preventa
	******************************/

	public function insertar_preventa($data){

        $data_insertar = array(
            'id_linea_servicio' => $data['id_linea_servicio'],
            'id_usuario' => $data['id_usuario'],
            'id_contacto' => $data['id_contacto'],
            'id_estado_pipeline' => $data['id_estado_pipeline'],
            'monto' => $data['monto'],
            'descripcion' => $data['descripcion'],
			'tipo_moneda' => $data['tipo_moneda'],
			'fecha_posible' => $data['fecha_posible']
        );

		$this->db->insert('preventa', $data_insertar);
		
		$id_preventa = $this->db->insert_id();

		//insertar log_preventa
		$data_insertar_log = array(
		'id_preventa' => $id_preventa,
		'id_pipeline' => $data['id_estado_pipeline'],
		'fecha' => date('Y-m-d')	
		);
		$this->db->insert('log_preventa', $data_insertar_log);

        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Preventa creada exitosamente'
        );

        return $respuesta;     
	}

	/******************************
        Actualizar Preventa
	******************************/

	public function actualizar_preventa($id, $data){	
		$this->db->where('id',$id);
		$this->db->where('id_estado_pipeline', $data['id_estado_pipeline']);
		$this->db->select("*");
        $this->db->from('preventa');
		$query = $this->db->get();
		
		if( $query->num_rows() == 0 ){
			//insertar log_propuesta
			$data_insertar_log = array(
			'id_preventa' => $id,
			'id_pipeline' => $data['id_estado_pipeline'],
			'fecha' => date('Y-m-d')	
			);
			$this->db->insert('log_preventa', $data_insertar_log);
			$this->db->reset_query(); 
		}
		
		//insertar propuesta
        $data_update = array(
			'id_linea_servicio' => $data['id_linea_servicio'],
            'id_usuario' => $data['id_usuario'],
            'id_contacto' => $data['id_contacto'],
            'id_estado_pipeline' => $data['id_estado_pipeline'],
            'monto' => $data['monto'],
            'descripcion' => $data['descripcion'],
			'tipo_moneda' => $data['tipo_moneda'],
			'fecha_posible' => $data['fecha_posible']
        );

		$this->db->set($data_update);
        $this->db->where('id', $id);
		$this->db->update('preventa');
		
        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Preventa modificada exitosamente'
		);
		
		return $respuesta;
	}

}
