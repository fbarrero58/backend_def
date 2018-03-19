<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Solicitud_model extends CI_Model {

    public function __construct(){
        $this->load->database();
	}

	//crear funcion que inserte permiso

	/******************************
        Insertar Permiso
	******************************/

	public function insertar_permiso($data){
		$data_insertar = array(
            'id_usuario_solicitante' => $data['id_usuario_solicitante'],
            'id_usuario_aprobador' => $data['id_usuario_aprobador'],
            'tipo_solicitud' => "Permiso",
            'estado' => "En espera",
           'fecha_solicitud' => date('Y-m-d')
		);
		
		$this->db->insert('solicitudes', $data_insertar);
		$id_solicitud= $this->db->insert_id(); 
		$this->db->reset_query();  
		
		//permisos
		$data_insertar = array(
            'id_solicitud' => $id_solicitud,
            'fecha' => $data['fecha'],
            'horas' => $data['horas'],
            'descripcion' => $data['descripcion'],
			'remunerado' => $data['remunerado']
		);

		 $this->db->insert('permisos', $data_insertar);
		
        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Solicitud de permiso creada exitosamente'
		);

		return $respuesta;
	}

	/******************************
        Insertar Vacacion
	******************************/

	public function insertar_vacacion($data){
		$data_insertar = array(
            'id_usuario_solicitante' => $data['id_usuario_solicitante'],
            'id_usuario_aprobador' => $data['id_usuario_aprobador'],
            'tipo_solicitud' => "Vacaciones",
            'estado' => "En espera",
           'fecha_solicitud' => date('Y-m-d')
		);
		
		$this->db->insert('solicitudes', $data_insertar);
		$id_solicitud= $this->db->insert_id(); 
		$this->db->reset_query();  
		
      //vacaciones
		$data_insertar = array(
            'id_solicitud' => $id_solicitud,
            'desde' => $data['desde'],
            'hasta' => $data['hasta']
		);

		$this->db->insert('vacaciones', $data_insertar);
		
        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Solicitud de vacaciones creada exitosamente'
		);

		return $respuesta;
	}

	/******************************
        Insertar Día Compensatorio
	******************************/

	public function insertar_compensatorio($data){
		$data_insertar = array(
            'id_usuario_solicitante' => $data['id_usuario_solicitante'],
            'id_usuario_aprobador' => $data['id_usuario_aprobador'],
            'tipo_solicitud' => "Compensatorio",
            'estado' => "En espera",
           'fecha_solicitud' => date('Y-m-d')
		);
		
		$this->db->insert('solicitudes', $data_insertar);
		$id_solicitud= $this->db->insert_id(); 
		$this->db->reset_query(); 
		
		//día compensatorio
		$data_insertar = array(
            'id_solicitud' => $id_solicitud,
            'fecha' => $data['fecha'],
            'razon' => $data['razon']
		);

		$this->db->insert('dia_compensatoria', $data_insertar);
		
        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Solicitud de día compensatorio creada exitosamente'
		);

		return $respuesta;
		
	}

	/******************************
       Traer solicitudes 
	******************************/

	public function solicitudes_traer($id){
		$this->db->select('s.id, s.id_usuario_solicitante, s.id_usuario_aprobador, CONCAT(i.nombres , " " , i.apellidos) As nombre_aprobador,s.tipo_solicitud, s.estado, s.fecha_solicitud');
        $this->db->from('solicitudes s');
		$this->db->join('usuarios_info_personal i', 's.id_usuario_aprobador = i.id_usuario');
		if ($id != null){
			$this->db->where(array('s.id_usuario_solicitante' => $id));
		}

		$query = $this->db->get();
        $resultado = array(
            'err' => FALSE,
            'mensaje' => 'Solicitudes cargadas exitosamente',
            'proyecto' => $query->result()
        );
		return $resultado;
	}

	/******************************
       Traer Solicitudes por aprobar
	******************************/

	public function aprobacion_traer($id){
		$this->db->select('s.id, s.id_usuario_solicitante, CONCAT(i.nombres , " " , i.apellidos) As nombre_solicitante, s.id_usuario_aprobador,s.tipo_solicitud, s.estado, s.fecha_solicitud');
        $this->db->from('solicitudes s');
		$this->db->join('usuarios_info_personal i', 's.id_usuario_solicitante = i.id_usuario');
		if ($id != null){
			$this->db->where(array('s.id_usuario_aprobador' => $id));
		}

		$query = $this->db->get();
        $resultado = array(
            'err' => FALSE,
            'mensaje' => 'Solicitudes cargadas exitosamente',
            'proyecto' => $query->result()
        );
		return $resultado;
	}

	/******************************
       Aprobar/Rechazar solicitudes 
	******************************/

	public function aprobar($id, $data){
        $data_update = array(
            'estado' => $data['estado']        
		);
		$this->db->set($data_update);
        $this->db->where('id', $id);
		$this->db->update('solicitudes');

        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Solicitud actualizada exitosamente'
        );
        return $respuesta;
	}

	/******************************
        Modificar Permiso
	******************************/

	public function modificar_permiso($id, $data){	
		//validar que solicitud este en espera
		$validaciones = array(
            'id' => $id,
            'id_usuario_solicitante ='=> $data['id_usuario_aprobador']
        );
        $resultado = verificar_duplicidad('solicitudes',$validaciones);

        if($resultado['err']){
			$respuesta = array(
				'err' => true,
				'mensaje' =>  "Solicitud no puede ser aprobada por usuario solicitante"
			);
			return $respuesta;
		}	

		// actualizar
		$data_update = array(
            'id_usuario_aprobador' => $data['id_usuario_aprobador']
		);
		
		$this->db->set($data_update);
        $this->db->where('id', $id);
		$this->db->update('solicitudes');
		$this->db->reset_query();  
		
		//permisos
		$data_update = array(
            'fecha' => $data['fecha'],
            'horas' => $data['horas'],
            'descripcion' => $data['descripcion'],
			'remunerado' => $data['remunerado']
		);

		$this->db->set($data_update);
        $this->db->where('id_solicitud', $id);
		$this->db->update('permisos');
		
        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Solicitud de permiso modificada exitosamente'
		);
		

		return $respuesta;
	}

	/******************************
        Modificar Vacación
	******************************/

	public function modificar_vacacion($id, $data){
		//validar que solicitud este en espera
		$validaciones = array(
            'id' => $id,
            'id_usuario_solicitante ='=> $data['id_usuario_aprobador']
        );
        $resultado = verificar_duplicidad('solicitudes',$validaciones);

        if($resultado['err']){
			$respuesta = array(
				'err' => true,
				'mensaje' =>  "Solicitud no puede ser aprobada por usuario solicitante"
			);
			return $respuesta;
		}	
		
		// actualizar

		$data_update = array(
            'id_usuario_aprobador' => $data['id_usuario_aprobador']
		);

		$this->db->set($data_update);
        $this->db->where('id', $id);
		$this->db->update('solicitudes');
		$this->db->reset_query();  
		
		//vacaciones
		$data_update = array(
            'desde' => $data['desde'],
            'hasta' => $data['hasta']
		);

		$this->db->set($data_update);
        $this->db->where('id_solicitud', $id);
		$this->db->update('vacaciones');
		
        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Solicitud de vacaciones modificada exitosamente'
		);

		return $respuesta;
	}

	/******************************
        Modificar Compensatorio
	******************************/

	public function modificar_compensatorio($id, $data){
		
		//validar que solicitud este en espera
		$validaciones = array(
            'id' => $id,
            'id_usuario_solicitante ='=> $data['id_usuario_aprobador']
        );
        $resultado = verificar_duplicidad('solicitudes',$validaciones);

        if($resultado['err']){
			$respuesta = array(
				'err' => true,
				'mensaje' =>  "Solicitud no puede ser aprobada por usuario solicitante"
			);
			return $respuesta;
		}	
		
		// actualizar

		$data_update = array(
            'id_usuario_aprobador' => $data['id_usuario_aprobador']
		);
		
		$this->db->set($data_update);
        $this->db->where('id', $id);
		$this->db->update('solicitudes');
		$this->db->reset_query();  
		
		//compensatorio
		$data_update = array(
            'fecha' => $data['fecha'],
            'razon' => $data['razon']
		);

		$this->db->set($data_update);
        $this->db->where('id_solicitud', $id);
		$this->db->update('dia_compensatoria');
		
        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Solicitud de día compensatorio modificada exitosamente'
		);

		return $respuesta;
	}

	


}
