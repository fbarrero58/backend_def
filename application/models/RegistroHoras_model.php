<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class RegistroHoras_model extends CI_Model {
    public function __construct(){
        $this->load->database();
	}

	/******************************
        Insertar Registro de Horas
	******************************/

	public function insertar($data){
		$this->db->select('horas_consumidas,horas_disponibles');
		$this->db->where('id', $data['id_proyecto']);
		$query = $this->db->get('proyectos');

		$horas = $query->row();
		$horas_disp = $horas->horas_disponibles;
		$horas_cons = $horas->horas_consumidas;
		$horas_suma = $horas_cons + $data['horas'];
	
		if (!is_null($horas_disp)){
			if($horas_suma <= $horas_disp){
			//actualizar horas consumidas
			$data_update = array(
				'horas_consumidas' => $horas_suma
			);
			
			$this->db->set($data_update);
			$this->db->where('id', $data['id_proyecto']);
			$this->db->update('proyectos');
			}else{
				$respuesta = array(
					'err' => TRUE,
					'mensaje' => 'Excedio el limite máximo de horas'
				);
				return $respuesta;	
			}
		}

		//insertar nuevo registro de hora
		$data_insertar = array(
            'id_proyecto' => $data['id_proyecto'],
            'id_actividad' => $data['id_actividad'],
			'id_tipo_servicio' => $data['id_tipo_servicio'],
			'id_usuario' => $data['id_usuario'],
			'fecha' => $data['fecha'],
			'horas' => $data['horas'],
			'ticket' => $data['ticket'],
			'descripcion' => $data['descripcion']
		);

		$this->db->insert('registro_horas', $data_insertar);

        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Registro de horas creado exitosamente'
        );
		return $respuesta;     
	}

	/******************************
        Actualizar Registro de Horas
	******************************/
	public function actualizar($id, $data){	
		
		$this->db->select('rh.horas ,p.horas_consumidas, p.horas_disponibles');
		$this->db->from('registro_horas as rh');
        $this->db->join('proyectos as p', 'rh.id_proyecto=p.id');
		$this->db->where(array('rh.id' => $id));	
        $query = $this->db->get();

		$horas = $query->row();

		$horas_disp = $horas->horas_disponibles;
		$horas_resta = $horas->horas_consumidas - $horas->horas;
		$horas_suma = $horas_resta + $data['horas'];
		//return $horas_suma;


		if (!is_null($horas_disp)){
			if($horas_suma <= $horas_disp){
			//actualizar horas consumidas
			$data_update = array(
				'horas_consumidas' => $horas_suma
			);
			
			$this->db->set($data_update);
			$this->db->where('id', $data['id_proyecto']);
			$this->db->update('proyectos');
			}else{
				$respuesta = array(
					'err' => TRUE,
					'mensaje' => 'Excedio el limite máximo de horas'
				);
				return $respuesta;	
			}
		}

		$data_update = array(
            'id_proyecto' => $data['id_proyecto'],
            'id_actividad' => $data['id_actividad'],
			'id_tipo_servicio' => $data['id_tipo_servicio'],
			'id_usuario' => $data['id_usuario'],
			'fecha' => $data['fecha'],
			'horas' => $data['horas'],
			'ticket' => $data['ticket'],
			'descripcion' => $data['descripcion']
		);

		$this->db->set($data_update);
        $this->db->where('id', $id);
		$this->db->update('registro_horas');
		
        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Registro de horas modificada exitosamente'
		);
		
		return $respuesta;
	}

	/******************************
        Eliminar Registro de Horas
	******************************/

	public function eliminar($id){
		$this->db->select('rh.horas ,p.horas_consumidas, p.horas_disponibles,p.id');
		$this->db->from('registro_horas as rh');
        $this->db->join('proyectos as p', 'rh.id_proyecto=p.id');
		$this->db->where(array('rh.id' => $id));	
        $query = $this->db->get();

		$horas = $query->row();

		$horas_disp = $horas->horas_disponibles;
		$id_proyecto = $horas->id;
		$horas_resta = $horas->horas_consumidas - $horas->horas;

		if (!is_null($horas_disp)){
			//actualizar horas consumidas
			$data_update = array(
				'horas_consumidas' => $horas_resta
			);

			$this->db->set($data_update);
			$this->db->where('id', $id_proyecto);
			$this->db->update('proyectos');
		}

		// eliminar responsabilidad
		$this->db->where('id', $id);
		$this->db->delete('registro_horas');

        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Registro de horas eliminado exitosamente'
		);

		return $respuesta;
	}

	/******************************
        Traer Registro de Horas
	******************************/

	public function traer($id){
       $this->db->select('rh.id, rh.id_proyecto, rh.id_actividad, va.nombre as actividad, rh.id_tipo_servicio, vt.nombre as tipo_servicio, rh.id_usuario, rh.fecha, rh.horas, rh.ticket, rh.descripcion');
        $this->db->from('registro_horas rh');
        $this->db->join('vmca_actividades va', 'rh.id_actividad=va.id');
        $this->db->join('vmca_tipo_servicio vt', 'rh.id_tipo_servicio = vt.id');
        $this->db->where(array('rh.id_usuario' => $id));
        $query = $this->db->get();
        $resultado = array(
            'err' => FALSE,
            'mensaje' => 'Registro de horas cargado exitosamente',
            'proyecto' => $query->result()
        );

		return $resultado;
	}

}
