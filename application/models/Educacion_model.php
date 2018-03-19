<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Educacion_model extends CI_Model {
    public function __construct(){
        $this->load->database();
	}
	
	/******************************
        Insertar Educación
	******************************/

	public function insertar($data){

        $data_insertar = array(
            'id_usuario' => $data['id_usuario'],
            'id_tipo_estudio' => $data['id_tipo_estudio'],
            'pais' => $data['pais'],
            'institucion' => $data['institucion'],
            'titulo' => $data['titulo'],
            'fecha_inicio' => $data['fecha_inicio'],
            'fecha_fin' => $data['fecha_fin']
        );

        $this->db->insert('educacion_usuario', $data_insertar);

        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Educación creada exitosamente'
        );

        return $respuesta;     
	}
	
	/******************************
        Traer Educación
	******************************/

	public function traer($id){
		$this->db->select('e.id, e.id_usuario, e.id_tipo_estudio, t.nombre,e.titulo, e.institucion, e.fecha_inicio, e.fecha_fin, e.pais');
        $this->db->from('educacion_usuario e');
		$this->db->join('vmca_tipo_estudios t', 'e.id_tipo_estudio=t.id');
		if ($id != null){
			$this->db->where(array('e.id_usuario' => $id));
		}

		$query = $this->db->get();
        $resultado = array(
            'err' => FALSE,
            'mensaje' => 'Educación cargada exitosamente',
            'proyecto' => $query->result()
        );
		return $resultado;
	}

	/******************************
        Modificar Educación
	******************************/

	public function actualizar($id, $data){	
		$data_update = array(
            'id_tipo_estudio' => $data['id_tipo_estudio'],
            'pais' => $data['pais'],
            'institucion' => $data['institucion'],
			'titulo' => $data['titulo'],
			'fecha_inicio' => $data['fecha_inicio'],
			'fecha_fin' => $data['fecha_fin']
		);

		$this->db->set($data_update);
        $this->db->where('id', $id);
		$this->db->update('educacion_usuario');
		
        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Educación modificada exitosamente'
		);
		
		return $respuesta;

	}

	/******************************
        eliminar Educación
	******************************/

	public function eliminar_educacion($id){

		$this->db->where('id', $id);
		$this->db->delete('educacion_usuario');

        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Educación eliminada exitosamente'
		);

		return $respuesta;
	}


}
