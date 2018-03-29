<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Proyecto_model extends CI_Model {

    public function __construct(){
        $this->load->database();
        $this->load->helper('utilidades');
    }

    /*******************************
        Insertar Proyecto
    *******************************/

    public function insertar($data){


        $validaciones = array(
            'codigo' => $data['codigo']
        );
        $resultado = verificar_duplicidad('proyectos',$validaciones);

        if($resultado['err']){
            return $resultado;
        }

        $data_insertar = array(
            'id_empresa' => $data['empresa'],
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

    /*******************************
        Traer todos los proyectos
    *******************************/

    public function todos(){

        $this->db->select('p.id,p.nombre, p.codigo, p.id_empresa, p.nombre as empresa, p.id_tipo_servicio,v.nombre as tipo_servicio, p.id_oportunidad, p.fecha_inicio,p.fecha_fin');
        $this->db->from('proyectos p');
        $this->db->join('empresas e', 'p.id_empresa=e.id');
        $this->db->join('vmca_tipo_servicio v', 'p.id_tipo_servicio = v.id');
        $query = $this->db->get();
        $resultado = array(
            'err' => FALSE,
            'mensaje' => 'Proyectos cargados exitosamente',
            'proyectos' => $query->result()
        );

        return $resultado;

    }

    /*******************************
        Traer proyecto por ID
    *******************************/

    public function por_id($id){
        $this->db->select('p.id, p.id_empresa, e.nombre as empresa, p.id_tipo_servicio, v.nombre as tipo_servicio, p.id_linea_servicio, p.id_alianza, p.id_oportunidad, p.codigo, p.nombre, p.fecha_inicio, p.fecha_fin, p.habilitado, p.tiene_ticket, p.horas_disponibles, p.facturable');
        $this->db->from('proyectos p');
        $this->db->join('empresas e', 'p.id_empresa=e.id');
        $this->db->join('vmca_tipo_servicio v', 'p.id_tipo_servicio = v.id');
        $this->db->where(array('p.id' => $id));
        $query = $this->db->get();
        $resultado = array(
            'err' => FALSE,
            'mensaje' => 'Proyecto cargado exitosamente',
            'proyecto' => $query->result()
        );

        return $resultado;
    }

    /*******************************
        Actualizar Proyecto
    *******************************/

    public function actualizar( $id, $data ){

        $data_update = array(
            'id_empresa' => $data['id_empresa'],
            'id_tipo_servicio' => $data['id_tipo_servicio'],
            'id_linea_servicio' => $data['id_linea_servicio'],
            'id_alianza' => $data['id_alianza'],
            'id_oportunidad' => $data['id_oportunidad'],
            'codigo' => $data['codigo'],
            'nombre' => $data['nombre'],
            'fecha_inicio' => $data['inicio'],
            'fecha_fin' => $data['fin'],
            'habilitado' => $data['habilitado'],
            'tiene_ticket' => $data['ticket'],
            'horas_disponibles' => $data['horas'],
            'facturable' => $data['facturable']
        );
        
        $this->db->set($data_update);
        $this->db->where('id', $id);
        $this->db->update('proyectos');

        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Proyecto actualizado exitosamente'
        );

        return $respuesta;
    }  
}
