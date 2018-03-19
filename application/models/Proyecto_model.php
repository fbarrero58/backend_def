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

        $this->db->select('id, codigo, nombre');
        $query = $this->db->get('proyectos');
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
        $this->db->select('a.id, b.nombre as Empresa, c.nombre as Servicio, d.nombre as Linea, a.nombre, a.fecha_inicio, a.fecha_fin, a.habilitado, a.tiene_ticket, a.horas_disponibles, a.facturable');
        $this->db->from('proyectos a');
        $this->db->join('empresas b', 'a.id_empresa = b.id');
        $this->db->join('vmca_tipo_servicio c', 'a.id_tipo_servicio = c.id');
        $this->db->join('vmca_lineas_servicio d', 'a.id_linea_servicio = d.id');
        $this->db->where(array('a.id' => $id));
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
            'id_tipo_servicio' => $data['tipo_servicio'],
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
