<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Propuesta_model extends CI_Model {
    public function __construct(){
        $this->load->database();
	}

	/******************************
        Insertar Propuesta
	******************************/

	public function insertar($data){
		//insertar propuesta
        $data_insertar = array(
            'id_proyecto' => $data['id_proyecto'],
            'id_estado_comercial' => $data['id_estado_comercial'],
            'id_version' => $data['id_version'],
            'num_version' => $data['num_version'],
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
			'horas_vendidas' => $data['horas_vendidas'],
			'valor_total' => $data['valor_total'],
			'fecha_entrega' => $data['fecha_entrega'],
			'ultima_version' => $data['ultima_version'],
			'link_drive' => $data['link_drive'],
			'tipo_moneda' => $data['tipo_moneda']
        );

		$this->db->insert('propuestas', $data_insertar);

		$id_propuesta = $this->db->insert_id();
		
		//insertar log_propuesta
		$data_insertar_log = array(
			'id_propuesta' => $id_propuesta,
			'id_estado_comercial' => $data['id_estado_comercial'],
			'fecha' => date('Y-m-d')	
			);
			$this->db->insert('log_propuesta', $data_insertar_log);

        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Propuesta creada exitosamente'
        );

        return $respuesta;
	}

	/******************************
        Actualizar Propuesta
	******************************/

	public function actualizar($id, $data){	
		$this->db->where('id',$id);
		$this->db->where('id_estado_comercial', $data['id_estado_comercial']);
		$this->db->select("*");
        $this->db->from('propuestas');
		$query = $this->db->get();
		
		if( $query->num_rows() == 0 ){
			//insertar log_propuesta
			$data_insertar = array(
			'id_propuesta' => $id,
			'id_estado_comercial' => $data['id_estado_comercial'],
			'fecha' => date('Y-m-d')	
			);
			$this->db->insert('log_propuesta', $data_insertar);
			$this->db->reset_query(); 
		}
		
		//insertar propuesta
        $data_update = array(
            'id_proyecto' => $data['id_proyecto'],
            'id_estado_comercial' => $data['id_estado_comercial'],
            'id_version' => $data['id_version'],
            'num_version' => $data['num_version'],
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
			'horas_vendidas' => $data['horas_vendidas'],
			'valor_total' => $data['valor_total'],
			'fecha_entrega' => $data['fecha_entrega'],
			'ultima_version' => $data['ultima_version'],
			'link_drive' => $data['link_drive'],
			'tipo_moneda' => $data['tipo_moneda']
        );

		$this->db->set($data_update);
        $this->db->where('id', $id);
		$this->db->update('propuestas');
		
        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Propuesta modificada exitosamente'
		);
		
		return $respuesta;
	}


	/******************************
        Insertar Condicion Comercial
	******************************/

	public function insertar_condicion($id, $data){
        $data_insertar = array(
            'id_propuesta' => $id,
            'id_estado_facturacion' => $data['id_estado_facturacion'],
            'id_estado_pago' => $data['id_estado_pago'],
            'detalle_condicion' => $data['detalle_condicion'],
            'num_factura' => $data['num_factura'],
            'fecha_facturacion' => $data['fecha_facturacion'],
			'total_clp' => $data['total_clp'],
			'total_uf' => $data['total_uf'],
			'valor_uf' => $data['valor_uf'],
			'detalles_adicionales' => $data['detalles_adicionales'],
			'liberado' => $data['liberado']
        );

        $this->db->insert('condiciones_comerciales', $data_insertar);

        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Condición comercial creada exitosamente'
        );

        return $respuesta;
	}

	/******************************
        Actualizar Condicion Comercial
	******************************/

	public function actualizar_condicion($id, $data){	
		$data_update = array(
            'id_estado_facturacion' => $data['id_estado_facturacion'],
            'id_estado_pago' => $data['id_estado_pago'],
            'detalle_condicion' => $data['detalle_condicion'],
            'num_factura' => $data['num_factura'],
            'fecha_facturacion' => $data['fecha_facturacion'],
			'total_clp' => $data['total_clp'],
			'total_uf' => $data['total_uf'],
			'valor_uf' => $data['valor_uf'],
			'detalles_adicionales' => $data['detalles_adicionales'],
			'liberado' => $data['liberado']
        );
		$this->db->set($data_update);
        $this->db->where('id', $id);
		$this->db->update('condiciones_comerciales');
		
        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Condición comercial modificada exitosamente'
		);
		
		return $respuesta;
	}

	/*******************************
        Traer todas las propuestas
    *******************************/

    public function todos(){
		$this->db->select('p.id_proyecto, py.codigo as codigo_proyecto, py.nombre as nombre_proyecto, p.id_estado_comercial, ec.nombre as estado_comercial, p.id_version, p.num_version, p.nombre, p.descripcion, p.horas_vendidas, p.valor_total, p.fecha_entrega,p.ultima_version, p.link_drive, p.tipo_moneda');
		$this->db->from('propuestas p');
		$this->db->join('proyectos py', 'p.id_proyecto = py.id');
		$this->db->join('vmca_estados_comerciales ec', 'p.id_estado_comercial = ec.id');
		$query = $this->db->get();

        if( $query->num_rows() > 0 ){
            $respuesta = array(
				'err' => FALSE,
				'mensaje' => 'Propuestas cargadas exitosamente',
                'modulos' => $query->result()
            );
        }else{
            $respuesta = array(
                'err' => FALSE,
                'mensaje' => 'No existen propuestas'
            );
        }

        return $respuesta;
    }

    /*******************************
        Traer propuesta por ID
    *******************************/

    public function por_id($id){
		$this->db->select('p.id_proyecto, py.codigo as codigo_proyecto, py.nombre as nombre_proyecto, p.id_estado_comercial, ec.nombre as estado_comercial, p.id_version, p.num_version, p.nombre, p.descripcion, p.horas_vendidas, p.valor_total, p.fecha_entrega,p.ultima_version, p.link_drive, p.tipo_moneda');
		$this->db->from('propuestas p');
		$this->db->join('proyectos py', 'p.id_proyecto = py.id');
		$this->db->join('vmca_estados_comerciales ec', 'p.id_estado_comercial = ec.id');
		$this->db->where(array('p.id' => $id));
		$query = $this->db->get();

		$arreglo_empresas = array();
		$arreglo_cargos = array();
		$arreglo_general = array();

		foreach($query->result_array() as $row){
			$this->db->reset_query(); 
			$this->db->select('c.id, c.id_estado_facturacion, ef.nombre as estado_facturacion , c.id_estado_pago, ep.nombre as estado_pago ,c.detalle_condicion, c.num_factura, c.fecha_facturacion, c.total_clp, c.total_uf, c.valor_uf, c.detalles_adicionales');
			$this->db->from('condiciones_comerciales c');
			$this->db->join('vmca_estados_facturacion ef', 'c.id_estado_facturacion = ef.id');
			$this->db->join('vmca_estados_pago ep', 'c.id_estado_pago = ep.id');
			$this->db->where(array('c.id_propuesta' => $id));
			$query2 = $this->db->get();
			$result = $query2->result();

			$arreglo_cargos = array();

			$modelo_empresa = array(
				'Propuesta' => $row,
				'condiciones_comerciales' => $result
			);	
			array_push($arreglo_cargos, $modelo_empresa);
		}
		return $arreglo_cargos;
	}

}
