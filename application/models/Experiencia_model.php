<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Experiencia_model extends CI_Model {
    public function __construct(){
        $this->load->database();
	}

	/******************************
        Insertar empresa
	******************************/

	public function insertar_empresa($data){
		$data_insertar = array(
            'id_usuario' => $data['id_usuario'],
            'nombre' => $data['nombre'],
			'industria' => $data['industria']
		);

		$this->db->insert('empresas_usuario', $data_insertar);

        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Empresa creada exitosamente'
        );
        return $respuesta;     
	}


	/******************************
        Insertar cargo
	******************************/

	public function insertar_cargo($data){
		$data_insertar = array(
            'id_empresa' => $data['id_empresa'],
            'nombre' => $data['nombre'],
			'fecha_inicio' => $data['fecha_inicio'],
			'fecha_fin' => $data['fecha_fin']
		);
		
		$this->db->insert('cargos_empresa', $data_insertar);

        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Cargo creado exitosamente'
        );

        return $respuesta;     
	}

	/******************************
        Insertar responsabilidad
	******************************/

	public function insertar_responsabilidad($data){
		$data_insertar = array(
            'id_cargo' => $data['id_cargo'],
            'descripcion' => $data['descripcion']
		);
		
		$this->db->insert('responsabilidades_cargo', $data_insertar);

        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Responsabilidad creada exitosamente'
        );

        return $respuesta;     
	}

	/******************************
       Actualizar empresa
	******************************/

	public function actualizar_empresa($id, $data){	
		$data_update = array(
            'id_usuario' => $data['id_usuario'],
            'nombre' => $data['nombre'],
            'industria' => $data['industria']
		);

		$this->db->set($data_update);
        $this->db->where('id', $id);
		$this->db->update('empresas_usuario');
		
        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Empresa modificada exitosamente'
		);
		

		return $respuesta;

	}

	/******************************
       Actualizar cargo
	******************************/

	public function actualizar_cargo($id, $data){	
		$data_update = array(
            'id_empresa' => $data['id_empresa'],
            'nombre' => $data['nombre'],
			'fecha_inicio' => $data['fecha_inicio'],
			'fecha_fin' => $data['fecha_fin']
		);

		$this->db->set($data_update);
        $this->db->where('id', $id);
		$this->db->update('cargos_empresa');
		
        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Cargo modificado exitosamente'
		);
		
		return $respuesta;

	}

	/******************************
       Actualizar cargo
	******************************/

	public function actualizar_responsabilidad($id, $data){	
		$data_update = array(
            'id_cargo' => $data['id_cargo'],
            'descripcion' => $data['descripcion']
		);

		$this->db->set($data_update);
        $this->db->where('id', $id);
		$this->db->update('responsabilidades_cargo');
		
        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Responsabilidad modificada exitosamente'
		);
		
		return $respuesta;

	}

	/******************************
       Traer experiencia
	******************************/

	public function traer_experiencia($id){
		$this->db->select('*');
		$this->db->from('empresas_usuario');
		$this->db->where(array('id_usuario' => $id));
		$query = $this->db->get();

		$arreglo_empresas = array();
		$arreglo_cargos = array();
		$arreglo_general = array();

		foreach($query->result_array() as $row){
			$this->db->reset_query(); 
			$this->db->select('*');
			$this->db->from('cargos_empresa');
			$this->db->where(array('id_empresa' => $row['id']));
			$query2 = $this->db->get();
			$result = $query2->result();

			$arreglo_cargos = array();

			foreach($query2->result_array() as $rowc){
				$this->db->reset_query(); 
				$this->db->select('*');
				$this->db->from('responsabilidades_cargo');
				$this->db->where(array('id_cargo' => $rowc['id']));
				$query3 = $this->db->get();
				$resultc = $query3->result();	
				$arreglo_responsabilidades = array();

				foreach($query3->result_array() as $rowr){
					$modelo_responsa = array(
						'id' => $rowr['id'],
						'id_cargo' => $rowr['id_cargo'],
						'descripcion' => $rowr['descripcion']
					);
					array_push($arreglo_responsabilidades,$modelo_responsa);
				}

				$modelo_cargos = array(
					'id' => $rowc['id'],
					'id_empresa' => $rowc['id_empresa'],
					'nombre' => $rowc['nombre'],
					'fecha_inicio' => $rowc['fecha_inicio'],
					'fecha_fin' => $rowc['fecha_fin'],
					'Responsabilidades' => $arreglo_responsabilidades
				);
				array_push($arreglo_cargos,$modelo_cargos);
			}

			$modelo_empresa = array(
				'id' => $row['id'],
				'nombre' => $row['nombre'],
				'industria'=> $row['industria'],
				'cargos' => $arreglo_cargos
			);
	
			array_push($arreglo_empresas, $modelo_empresa);		
		}
		return $arreglo_empresas;
	}

	/******************************
       Eliminar responsabilidad
	******************************/

	public function eliminar_responsabilidad($id){
		$this->db->where('id', $id);
		$this->db->delete('responsabilidades_cargo');
		
        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Responsabilidad eliminada exitosamente'
		);

		return $respuesta;
	}

	/******************************
       Eliminar cargo
	******************************/

	public function eliminar_cargo($id){

		// eliminar responsabilidad
		$this->db->where('id_cargo', $id);
		$this->db->delete('responsabilidades_cargo');
		
		//eliminar cargo
		$this->db->where('id', $id);
		$this->db->delete('cargos_empresa');

        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Cargo eliminado exitosamente'
		);

		return $respuesta;
	}

	/******************************
       Eliminar empresa
	******************************/

	public function eliminar_empresa($id){

		$this->db->select('id');
		$this->db->from('cargos_empresa');
		$this->db->where(array('id_empresa' => $id));
		$query = $this->db->get();

		foreach($query->result_array() as $row){			
			// eliminar responsabilidad
			$this->db->where('id_cargo',  $row['id']);
			$this->db->delete('responsabilidades_cargo');
		}

			// eliminar cargo
			$this->db->where('id_empresa',  $id);
			$this->db->delete('cargos_empresa');

			//eliminar empresa
			$this->db->where('id',  $id);
			$this->db->delete('empresas_usuario');

			$respuesta = array(
				'err' => FALSE,
				'mensaje' => 'Empresa eliminada exitosamente'
			);
	
			return $respuesta;
	}


}

