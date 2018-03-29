<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    /*******************************
        Insertar Empresa
    *******************************/

    public function insertar($data){

        $query = $this->db->get_where('empresas', array('codigo' => $data['codigo']));

        if($query->num_rows() > 0){
            $respuesta = array(
                'err' => TRUE,
                'mensaje' => 'Este código ya esta asignado a otra Empresa'
            );
            return $respuesta;
        }

        $this->db->reset_query();

        $query = $this->db->get_where('empresas', array('alias' => $data['alias']));
        if($query->num_rows() > 0){
            $respuesta = array(
                'err' => TRUE,
                'mensaje' => 'Este alias ya esta asignado a otra Empresa'
            );
            return $respuesta;
        }

        $this->db->reset_query();

        $data_insertar = array(
            'id_tipo_empresa' => $data['tipo_empresa'],
            'codigo' => $data['codigo'],
            'nombre' => $data['nombre'],
            'habilitado' => $data['habilitado'],
            'alias' => $data['alias'],
            'condicion_pago' => $data['condicion_pago'],
        );

        $this->db->insert('empresas', $data_insertar);

        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Empresa creada exitosamente'
        );

        return $respuesta;
    }

    /*******************************
        Actualizar Empresa
    *******************************/

    public function actualizar( $id, $data ){

        $data_update = array(
            'id_tipo_empresa' => $data['tipo_empresa'],
            'nombre' => $data['nombre'],
            'habilitado' => $data['habilitado'],
            'condicion_pago' => $data['condicion_pago']
        );
        
        $this->db->set($data_update);
        $this->db->where('id', $id);
        $this->db->update('empresas');

        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Empresa actualizada exitosamente'
        );

        return $respuesta;

    }

    /*******************************
        Traer todas las empresas
    *******************************/

    public function todos(){
        $this->db->select('e.id, e.nombre, e.codigo, v.nombre as tipo_empresa');
        $this->db->from('empresas e');
        $this->db->join('vmca_tipo_empresa v', 'e.id_tipo_empresa= v.id');
        $query = $this->db->get();
        $resultado = array(
            'err' => FALSE,
            'mensaje' => 'Empresas cargadas exitosamente',
            'empresas' => $query->result()
        );

        return $resultado;
    }
        


    /*******************************
        Traer empresa por ID
    *******************************/

    public function por_id($id){
        $this->db->select('e.id, e.id_tipo_empresa, v.nombre as tipo_empresa, e.codigo, e.nombre, e.habilitado, e.alias, e.condicion_pago');
        $this->db->from('empresas e');
        $this->db->join('vmca_tipo_empresa v', 'e.id_tipo_empresa= v.id');
        $this->db->where('e.id', $id);
        $query = $this->db->get();
        $resultado = array(
            'err' => FALSE,
            'mensaje' => 'Empresa cargada exitosamente',
            'empresa' => $query->result()
        );

        return $resultado;
    }
    

}