<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vmca_model extends CI_Model {
    public function __construct(){
        $this->load->database();
	}

	public function traer_actividades(){
		$this->db->select('a.id,a.id_tipo_servicio,t.nombre as tipo_servicio,a.nombre');
        $this->db->from('vmca_actividades a');
        $this->db->join(' vmca_tipo_servicio t', 'a.id_tipo_servicio = t.id');
        $query = $this->db->get();
        $resultado = array(
            'err' => FALSE,
            'mensaje' => 'Actividades cargadas exitosamente',
            'actividades' => $query->result()
        );
		return $resultado;
	}

	public function traer_lineaservicio(){
		$this->db->select('*');
        $this->db->from('vmca_lineas_servicio');
        $query = $this->db->get();
        $resultado = array(
            'err' => FALSE,
            'mensaje' => 'Lineas de servicio cargadas exitosamente',
			'lineas' => $query->result()
        );
		return $resultado;
	}

	public function traer_tiposervicio(){
		$this->db->select('*');
        $this->db->from('vmca_tipo_servicio');
        $query = $this->db->get();
        $resultado = array(
            'err' => FALSE,
            'mensaje' => 'Tipos de servicio cargados exitosamente',
            'servicios' => $query->result()
        );
		return $resultado;
	}

	public function traer_roles(){
		$this->db->select('*');
        $this->db->from('vmca_roles');
        $query = $this->db->get();
        $resultado = array(
            'err' => FALSE,
            'mensaje' => 'Roles cargados exitosamente',
            'roles' => $query->result()
        );
		return $resultado;
	}

	public function traer_tipoestudio(){
		$this->db->select('*');
        $this->db->from('vmca_tipo_estudios');
        $query = $this->db->get();
        $resultado = array(
            'err' => FALSE,
            'mensaje' => 'Tipos de estudio cargados exitosamente',
            'tipos de estudio' => $query->result()
        );
		return $resultado;
	}

	public function traer_perfiles(){
		$this->db->select('*');
        $this->db->from('vmca_perfiles');
        $query = $this->db->get();
        $resultado = array(
            'err' => FALSE,
            'mensaje' => 'Perfiles cargados exitosamente',
            'perfiles' => $query->result()
        );
		return $resultado;
	}

	public function traer_modulos(){
		$this->db->select('*');
        $this->db->from('vmca_modulos');
        $query = $this->db->get();
        $resultado = array(
            'err' => FALSE,
            'mensaje' => 'Modulos cargados exitosamente',
            'módulos' => $query->result()
        );
		return $resultado;
	}

	public function traer_tipoempresa(){
		$this->db->select('*');
        $this->db->from('vmca_tipo_empresa');
        $query = $this->db->get();
        $resultado = array(
            'err' => FALSE,
            'mensaje' => 'Empresas cargados exitosamente',
            'empresas' => $query->result()
        );
		return $resultado;
	}

	/*
		Faltan
			- tipo empresa
			- estados comerciales
			- estados facturacion
			- estados pago
			- actividades comerciales
			- estados pipeline
    */

}
